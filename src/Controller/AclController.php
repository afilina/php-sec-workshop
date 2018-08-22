<?php

namespace App\Controller;

use App\Interfaces\ReflectionInterface;
use App\Repository\PurchaseRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AclController extends Controller
{
    /**
     * @Route("/acl/{purchaseId}", name="acl")
     */
    public function acl(PurchaseRepository $purchaseRepo, ReflectionInterface $reflection, int $purchaseId)
    {
        $purchase = $purchaseRepo->findOneBy(['id' => $purchaseId]);

        if ($purchase == null) {
            throw $this->createNotFoundException();
        }

        $code = $reflection->getMethodLines($this, 'acl', 1, 1, true);

        return $this->render('acl/index.html.twig', [
            'purchase' => $purchase,
            'code' => $code,
        ]);
    }

    /**
     * @Route("/acl-fixed/{purchaseId}", name="acl_fixed")
     */
    public function aclFixed(PurchaseRepository $purchaseRepo, ReflectionInterface $reflection, int $purchaseId)
    {
        //...

        $code = $reflection->getMethodLines($this, 'aclFixed', 1, 1, true);

        return $this->render('acl/index.html.twig', [
            'purchase' => $purchase,
            'code' => $code,
        ]);
    }
}
