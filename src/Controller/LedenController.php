<?php


namespace App\Controller;

use App\Entity\Registration;
use App\Entity\Training;

use App\Entity\Lesson;
use App\Entity\User;
use App\Form\LedenFormType;
use App\Form\LedenProfielType;
use App\Form\RegistrationType;
use App\Repository\LessonRepository;
use App\Repository\RegistrationRepository;
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


class LedenController extends AbstractController
{
    /**
     * @Route("/leden_homepage", name="leden_homepage")
     */

    public function homepage(UserRepository $userRepository)
    {
        $user = $userRepository->find(['id'=>$this->getUser()]);
        return $this->render('leden/leden_homepage.html.twig',[
            'users' =>$user
        ]);
    }

    /**
     * @Route("/leden_gegevens", name="leden_gegevens")
     */
    public function ledenGegevens(UserRepository $articleRepo,UserRepository  $userRepository)
    {
        {
            $user = $userRepository->find(['id'=>$this->getUser()]);
            $articles = $articleRepo->findAll();


            return $this->render('leden/leden_gegevens.html.twig', [
                'articles' => $articles,
                'users' =>$user
            ]);
        }
    }

    /**
     * @Route("/profiel/{id}", name="profiel")
     *
     */
    public function edit(User $user, Request $request, EntityManagerInterface $em){
        $form = $this->createForm(LedenProfielType::class,$user);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){

            $data= $form->getData();
            $user->setFirstname($_POST['firstname']);
            $user->setLastname($_POST['lastname']);
            $user->setStreet($_POST['street']);
            $user->setPlace($_POST['place']);
            $user->setDateofbirth($data->getDateofbirth());

            $em->persist($user);
            $em->flush();
            $this->addFlash('update', 'Training Updated!');
            return $this->redirectToRoute('profiel', [
                'id' => $user->getId(),
            ]);


        }
        return $this->render('leden/leden_aanpassen.html.twig',
            ['editForm' =>$form->createView(), "users" => $user]);
    }




    /**
     * @Route("/lessen_overzicht", name="lessen_overzicht")
     */
    public function lessenOverzicht(TrainingRepository $trainingRepository,Request $request,EntityManagerInterface $entityManager,UserRepository $userRepository,RegistrationRepository $registrationRepository,LessonRepository $lessonRepository)
    {
        {
            $users =  $userRepository->find($this->getUser());
            $registration = $registrationRepository->findBy(['user' => $users->getId()]);

            if (isset($_POST['uitschijven'])){
                $data = $_POST['uitschijven'];
                $entityManager->remove($registrationRepository->find($data));
                $entityManager->flush();
                echo "Werkt";

                $this->addFlash("remove", "Het is verwijderd");
                return $this->redirectToRoute("app_deelnemer_overzicht");
            }

            return $this->render('leden/lessen_overzicht.html.twig', [
                "users" =>  $users ,
                "lesson" => $registration
            ]);
        }
    }
}