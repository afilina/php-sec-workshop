<?php

namespace App\Controller;

use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class XssController extends Controller
{
    /**
     * @Route("/xss", name="xss")
     */
    public function xss(Request $request)
    {
        $form = $this->createFormBuilder(null)
            ->add('comment', TextareaType::class, [
                'data' => '<script>alert("Hacked");</script>',
                'attr' => ['style' => 'height:120px'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Send'
            ])
            ->getForm();

        $form->handleRequest($request);

        $comment = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData()['comment'];
        }

        return $this->render('xss/index.html.twig', [
            'form' => $form->createView(),
            'comment' => $comment,
            'code' => '{{ comment | raw }}',
        ]);
    }

    /**
     * @Route("/xss-fixed", name="xss_fixed")
     */
    public function xssFixed(Request $request)
    {
        $form = $this->createFormBuilder(null)
            ->add('comment', TextareaType::class, [
                'data' => '<script>alert("Hacked");</script>',
                'attr' => ['style' => 'height:120px'],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Send'
            ])
            ->getForm();

        $form->handleRequest($request);

        $comment = '';
        if ($form->isSubmitted() && $form->isValid()) {
            $comment = $form->getData()['comment'];
        }

        return $this->render('xss/fixed.html.twig', [
            'form' => $form->createView(),
            'comment' => $comment,
            'code' => '{{ comment }}',
        ]);
    }
}
