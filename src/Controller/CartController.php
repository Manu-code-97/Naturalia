<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
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
        return $this->render('checkout/index.html.twig', [
            'items' => $this->cartService->getCart(),
            'total' => $this->cartService->getTotal(),
        ]);
    }

    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function addToCart($id): JsonResponse
    {
        $this->cartService->add($id);

        return new JsonResponse([
            'items' => $this->cartService->getCart(),
            'total' => $this->cartService->getTotal(),
        ]);
    }

    #[Route('/bill', name: 'app_bill')]
    public function showBill(ProduitRepository $produitRepository): Response
    {
        // Récupérer les produits (vous pouvez ajuster cette logique selon vos besoins)
        /* $products = $produitRepository->findAll(); */
        $items = $this->cartService->getCart();
        $total = $this->cartService->getTotal();

        return $this->render('bill.html.twig', [
            /* 'products' => $products, */
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

        return new JsonResponse([
            'items' => $this->cartService->getCart(),
            'total' => $this->cartService->getTotal(),
        ]);
    }

    #[Route('/cart/remove/{id}', name: 'cart_remove', methods: ['POST'])]
    public function removeFromCart($id): JsonResponse
    {
        $this->cartService->remove($id);

        return new JsonResponse([
            'items' => $this->cartService->getCart(),
            'total' => $this->cartService->getTotal(),
        ]);
    }
}

