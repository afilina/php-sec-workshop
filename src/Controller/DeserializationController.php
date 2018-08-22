<?php

namespace App\Controller;

use App\Interfaces\ReflectionInterface;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Yaml\Yaml;

class DeserializationController extends Controller
{
    /**
     * @Route("/yaml-create-config/{redirect}", name="yaml_create_config")
     */
    public function yamlCreateConfig(string $redirect)
    {
        file_put_contents(__DIR__.'/../../config.yaml', 'lang: en');
        return $this->redirectToRoute($redirect);
    }

    /**
     * @Route("/yaml-rm", name="yaml_rm")
     */
    public function yamlRm(Request $request, ReflectionInterface $reflection)
    {
        $yamlString = file_get_contents('https://gist.github.com/afilina/250d04bb102675c03b46ee9e912e71b5/raw/0f9cc28111c46ea53c8e4557b7ce225290686bcb/deserialization.yaml');

        $form = $this->createFormBuilder(null)
            ->add('submit', SubmitType::class, [
                'label' => 'Deserialize'
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            Yaml::parse($yamlString, Yaml::PARSE_OBJECT);
        }

        return $this->render('deserialization/index.html.twig', [
            'form' => $form->createView(),
            'code' => $reflection->getMethodLines($this, 'yamlRm', 11, 1, true),
            'yaml' => $yamlString,
            'ls' => `ls -l ../`,
        ]);
    }

    /**
     * @Route("/yaml-rm-fixed", name="yaml_rm_fixed")
     */
    public function yamlRmFixed(Request $request, ReflectionInterface $reflection)
    {
        $yamlString = file_get_contents('https://gist.github.com/afilina/250d04bb102675c03b46ee9e912e71b5/raw/0f9cc28111c46ea53c8e4557b7ce225290686bcb/deserialization.yaml');

        $form = $this->createFormBuilder(null)
            ->add('submit', SubmitType::class, [
                'label' => 'Deserialize'
            ])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            Yaml::parse($yamlString);
        }

        return $this->render('deserialization/index.html.twig', [
            'form' => $form->createView(),
            'code' => $reflection->getMethodLines($this, 'yamlRmFixed', 11, 1, true),
            'yaml' => $yamlString,
            'ls' => `ls -l ../`,
        ]);
    }
}
