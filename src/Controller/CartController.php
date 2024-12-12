<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    #[Route('/cart', name: 'cart_show')]
    public function showCart(): Response
    {


        $items = $this->cartService->getCart();
        
        $total = $this->cartService->getTotal();

        return $this->render('checkout/index.html.twig', [
            'items' => $items,
            'total' => $total,
            
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function addToCart($id): JsonResponse
    {
        $this->cartService->add($id);
        $items = $this->cartService->getCart();
        $total = $this->cartService->getTotal();

        return new JsonResponse([
            'items' => $items,
            'total' => $total,
        ]);
    }

    #[Route('/cart/update/{id}', name: 'cart_update', methods: ['POST'])]
    public function updateCart($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if ($data['action'] === 'increase') {
            $this->cartService->add($id);
        } elseif ($data['action'] === 'decrease') {
            $this->cartService->decrease($id);
        }
        $items = $this->cartService->getCart();
        $total = $this->cartService->getTotal();

        return new JsonResponse([
            'items' => $items,
            'total' => $total,
        ]);
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['POST'])]
    public function removeFromCart($id): JsonResponse
    {
        $this->cartService->remove($id);
        $items = $this->cartService->getCart();
        $total = $this->cartService->getTotal();

        return new JsonResponse([
            'items' => $items,
            'total' => $total,
        ]);
    }
}

