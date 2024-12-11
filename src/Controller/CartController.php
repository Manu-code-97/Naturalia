<?php

namespace App\Controller;

use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function show(): Response
    {
        $cart = $this->cartService->getCart();

        return $this->render('_fragment/panier.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(int $id): Response
    {
        $this->cartService->addItem($id);

        return $this->redirectToRoute('cart_show');
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove')]
    public function remove(int $id): Response
    {
        $this->cartService->removeItem($id);

        return $this->redirectToRoute('cart_show');
    }

    #[Route('/cart/clear', name: 'cart_clear')]
    public function clear(): Response
    {
        $this->cartService->clearCart();

        return $this->redirectToRoute('cart_show');
    }
}

