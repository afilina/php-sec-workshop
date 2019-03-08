<?php

namespace App\Controller;

use Doctrine\DBAL\DBALException;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index(EntityManagerInterface $em)
    {
        $error = null;
        try {
            $stmt = $em->getConnection()->query("SELECT id FROM purchase");
            $stmt->execute();
        } catch (DBALException $e) {
            $error = 'SQLLite is not configured correctly. Please open an issue in the GitHub project.';
        }
        return $this->render('default/index.html.twig', ['error' => $error]);
    }
}
