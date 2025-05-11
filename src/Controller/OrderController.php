<?php

namespace App\Controller;

use App\Entity\Order;
use App\Form\OrderTypeForm;
use App\Repository\OrderRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrderController extends AbstractController
{
    #[Route('/order', name: 'app_order', methods: ['GET', 'POST'])]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $order = new Order();
        $form = $this->createForm(OrderTypeForm::class, $order);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Привязываем пользователя к заказу
            $order->setUser($this->getUser());

            $em->persist($order);
            $em->flush();

            $this->addFlash('success', 'Заказ успешно создан!');
            return $this->redirectToRoute('app_orders_list');
        }

        return $this->render('order/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/orders', name: 'app_orders_list')]
    public function list(OrderRepository $orderRepository): Response
    {
        // Получаем все заказы (для админа) или только текущего пользователя
        $orders = $this->isGranted('ROLE_ADMIN')
            ? $orderRepository->findAllOrderedByDate()
            : $orderRepository->findByUser($this->getUser());

        return $this->render('order/index.html.twig', [
            'orders' => $orders
        ]);
    }
}
