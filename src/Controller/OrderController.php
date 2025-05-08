<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderTypeForm;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrderController extends AbstractController
{
    //    #[Route('/order', name: 'app_order')]
    //    public function index(): Response
    //    {
    //        return $this->render('order/index.html.twig', [
    //            'controller_name' => 'OrderController',
    //        ]);
    //    }

    // src/Controller/OrderController.php
    #[Route('/order', name: 'order')]
    public function order(Request $request, EntityManagerInterface $em): Response {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $order = new Order();
        $form = $this->createForm(OrderTypeForm::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($order);
            $em->flush();
            return $this->redirectToRoute('order_success');
        }

        return $this->render('order/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
