<?php

namespace App\Controller;

use App\Interfaces\ReflectionInterface;
use App\Repository\PurchaseRepository;
use Doctrine\DBAL\FetchMode;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InjectionController extends Controller
{
    /**
     * @Route("/sql-injection/{userId}", name="injection")
     */
    public function injection(EntityManagerInterface $em, ReflectionInterface $reflection, string $userId)
    {
        $stmt = $em->getConnection()->query("SELECT id, amount FROM purchase WHERE user_id = {$userId}");
        $stmt->execute();
        $purchases = $stmt->fetchAll(FetchMode::ASSOCIATIVE);

        $code = $reflection->getMethodLines($this, 'injection', 1, 3, true);

        return $this->render('injection/index.html.twig', [
            'purchases' => $purchases,
            'code' => $code,
        ]);
    }

    /**
     * @Route("/sql-injection-fixed/{userId}", name="injection_fixed")
     */
    public function injectionFixed(EntityManagerInterface $em, ReflectionInterface $reflection, string $userId)
    {
        $stmt = $em->getConnection()->prepare('SELECT id, amount FROM purchase WHERE user_id = :user_id');
        $stmt->execute(['user_id' => $userId]);
        $purchases = $stmt->fetchAll(FetchMode::ASSOCIATIVE);

        $code = $reflection->getMethodLines($this, 'injectionFixed', 1, 3, true);

        return $this->render('injection/index.html.twig', [
            'purchases' => $purchases,
            'code' => $code,
        ]);
    }

    /**
     * @Route("/sql-injection-fixed-symfony/{userId}", name="injection_fixed_symfony")
     */
    public function injectionFixedSymfony(PurchaseRepository $purchaseRepo, ReflectionInterface $reflection, string $userId)
    {
        $purchases = $purchaseRepo->findBy(['user' => $userId]);

        $code = $reflection->getMethodLines($this, 'injectionFixedSymfony', 1, 1, true);

        return $this->render('injection/index.html.twig', [
            'purchases' => $purchases,
            'code' => $code,
        ]);
    }
}
