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


class ArticleController extends AbstractController
{
    /**
     * @Route("/", name="bezoeker_homepage")
     */

    public function homepage()
    {
        return $this->render('bezoeker/bezoeker_hompepage.html.twig');
    }

    /**
     * @Route("/contact", name="contact")
     */

    public function contact()
    {
        return $this->render('bezoeker/contact.html.twig');
    }



}