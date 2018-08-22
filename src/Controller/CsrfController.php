<?php

namespace App\Controller;

use App\Entity\Purchase;
use App\Interfaces\ReflectionInterface;
use App\Repository\PurchaseRepository;

use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class CsrfController extends Controller
{
    /**
     * @Route("/csrf", name="csrf")
     */
    public function index(PurchaseRepository $purchaseRepo, ReflectionInterface $reflection)
    {
        $purchases = $purchaseRepo->findBy(['user' => 1]);
        return $this->render('csrf/index.html.twig', [
            'purchases' => $purchases,
            'code' => $reflection->getMethodLines($this, 'refund', -4, 8, true),
        ]);
    }

    /**
     * @Route("/csrf/refund/{id}", name="csrf_refund")
     */
    public function refund(string $id, PurchaseRepository $purchaseRepo, EntityManagerInterface $em)
    {
        $purchase = $purchaseRepo->findOneBy(['id' => $id, 'user' => 1]);
        $em->remove($purchase);
        $em->flush();

        return $this->redirectToRoute('csrf');
    }

    /**
     * @Route("/csrf-fixed", name="csrf_fixed")
     */
    public function indexFixed(Request $request, PurchaseRepository $purchaseRepo, EntityManagerInterface $em, ReflectionInterface $reflection)
    {
        $purchases = $purchaseRepo->findBy(['user' => 1]);

        //...

        return $this->render('csrf/fixed.html.twig', [
            'purchases' => $purchases,
            'form' => '',
            'code' => '',
            'token' => '',
        ]);
    }

    /**
     * @Route("/create-purchase/{redirect}", name="create_purchase")
     */
    public function createPurchase(string $redirect, EntityManagerInterface $em)
    {
        $purchase = new Purchase();
        $purchase->setAmount(500);
        $purchase->setUser($em->getReference('App\Entity\User', 1));
        $em->persist($purchase);
        $em->flush();
        return $this->redirectToRoute($redirect);
    }
}
