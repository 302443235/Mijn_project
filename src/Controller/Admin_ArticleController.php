<?php


namespace App\Controller;

use App\Entity\Training;
use App\Repository\TrainingRepository;
use App\Form\ArticleFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\HttpFoundation\Request;

class Admin_ArticleController extends AbstractController
{
    /**
     * @Route("/admin_homepage", name="admin_homepage")
     */

    public function homepage()
    {
        return $this->render('administratie/admin_homepage.html.twig');
    }

    /**
     * @Route("/training_bekijken", name="training_bekijken")
     */
    public function trainingBekijken(TrainingRepository $articleRepo)
    {
        {
            $articles = $articleRepo->findAll();
            return $this->render('administratie/training_bekijken.html.twig', [
                'articles' => $articles,
            ]);
        }
    }

    /**
     * @Route("/training_toevoegen", name="training_toevoegen")
     */
    public function new(EntityManagerInterface $em, Request $request)
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

        return $this->render(
            'administratie/training_toevoegen.html.twig', [
            'articleForm' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/training_aanpassen", name="training_aanpassen")
     */
    public function trainingAanpassen($id, EntityManagerInterface $em, Request $request)
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

        return $this->render('administratie/training_aanpassen.html.twig', [
            'articleForm' => $form->createView()
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
}