<?php


namespace App\Controller;

use App\Entity\Registration;
use App\Entity\Training;
use App\Entity\User;
use App\Form\RegistrationType;
use App\Repository\TrainingRepository;
use App\Form\ArticleFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\UserCheckerInterface;

class Admin_ArticleController extends AbstractController
{
    /**
     * @Route("/admin_homepage", name="admin_homepage")
     */

    public function homepage(UserRepository $userRepository)
    {
            $user = $userRepository->find(['id'=>$this->getUser()]);

        return $this->render('administratie/admin_homepage.html.twig',[
            'users' =>$user
        ]);
    }

    /**
     * @Route("/training_bekijken", name="training_bekijken")
     */
    public function trainingBekijken(TrainingRepository $articleRepo,UserRepository  $userRepository)
    {
        {
            $user = $userRepository->find(['id'=>$this->getUser()]);
            $articles = $articleRepo->findAll();


            return $this->render('administratie/training_bekijken.html.twig', [
                'articles' => $articles,
                'users' =>$user
            ]);
        }
    }

    /**
     * @Route("/training_toevoegen", name="training_toevoegen")
     */
    public function new(EntityManagerInterface $em, Request $request, UserRepository  $userRepository)
    {
        $form = $this->createForm(ArticleFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $data = $form->getData();
            $training = new Training();
            $training->setNaam($data['naam']);
            $training->setDescription($data['description']);
            $training->setDuration($data['duration']);
            $training->setCosts($data['costs']);

            $em->persist($training);
            $em->flush();
            return $this->redirectToRoute('training_bekijken');
        }

        $user = $userRepository->find(['id'=>$this->getUser()]);
        return $this->render(
            'administratie/training_toevoegen.html.twig', [
            'articleForm' => $form->createView(),
            'users' =>$user
        ]);
    }

    /**
     * @Route("/{id}/training_aanpassen", name="training_aanpassen")
     */
    public function trainingAanpassen($id, EntityManagerInterface $em, Request $request, UserRepository  $userRepository)
    {
        $training = new Training();
        $training = $this->getDoctrine()->getRepository(Training::class)->find($id);
        $form = $this->createForm(ArticleFormType::class, $training);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $game = $form->getData();
            $em->persist($training);
            $em->flush();

            $this->addFlash('success', 'Article updated!');

            return $this->redirectToRoute('training_bekijken', [
                'id' => $training->getId(),
            ]);

        }
        $user = $userRepository->find(['id'=>$this->getUser()]);

        return $this->render('administratie/training_aanpassen.html.twig', [
            'articleForm' => $form->createView(),
            'users' =>$user
        ]);

    }

    /**
     * @Route("/{id}/training_verwijderen", name="training_verwijderen")
     */
    public function delete($id, EntityManagerInterface $em, Request $request)
    {
        $training = $this->getDoctrine()->getRepository(Training::class)->find($id);
        $em->remove($training);
        $em->flush();
        return $this->redirectToRoute('training_bekijken');
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function registreren(Request $request,EntityManagerInterface $entityManager , UserPasswordEncoderInterface $passwordEncoder)
    {
        $form = $this->createForm(RegistrationType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();
            $user = new User();

            $user->setFirstname($data['firstname']);
            $user->setLastname($data['lastname']);
            $user->setLoginname($data['loginname']);
            $user->setPreprovision($data['preprovision']);
            $user->setDateofbirth($data['dateofbirth']);
            $user->setGender($data['gender']);
            $user->setRoles(['ROLE_USER']);
            $user->setStreet($data['street']);
            $user->setPostelCode($data['postel_code']);
            $user->setPlace($data['place']);
            $user->setEmail($data['email']);
            $passwordEncoder = $passwordEncoder->encodePassword($user,$data['password']);
            $user->setPassword(  $passwordEncoder);


            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirect("/login");
        }
        return $this->render('bezoeker/registration.html.twig', [
            'form' => $form->createView() ,
            'controller_name' => 'Controller',
        ]);
    }
}