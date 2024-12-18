<?php

namespace App\Service;

use App\Repository\ProduitRepository;
use Symfony\Component\HttpFoundation\RequestStack;

class CartService
{
    private $requestStack;
    private $produitRepository;

    public function __construct(RequestStack $requestStack, ProduitRepository $produitRepository)
    {
        $this->requestStack = $requestStack;
        $this->produitRepository = $produitRepository;
    }

    private function getSession()
    {
        

        return $this->requestStack->getSession();
    }

    public function add(int $id)
    {
        $session = $this->getSession();
        $cart = $session->get('cart', []);

        if (!isset($cart[$id])) {
            $cart[$id] = 0;
        }

        $cart[$id]++;

        $session->set('cart', $cart);
    }

    public function remove(int $id)
    {
        $session = $this->getSession();
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
        }

        $session->set('cart', $cart);
    }

    public function decrease(int $id)
    {
        $session = $this->getSession();
        $cart = $session->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id] > 1) {
                $cart[$id]--;
            } else {
                unset($cart[$id]);
            }
        }

        $session->set('cart', $cart);
    }

    public function getCart(): array
{
    $session = $this->getSession();
    $cart = $session->get('cart', []);
    $cartWithData = [];

    foreach ($cart as $id => $quantity) {
        $product = $this->produitRepository->findOneBy([ 'id' => $id ]);

        if ($product) {
            $cartWithData[] = [
                'product' => [
                    'id'          => $product->getId(),
                    'image'       => $product->getImage(),
                    'nom'         => $product->getNom(),
                    'prix'        => $product->getPrix(),
                    'description' => $product->getDescription(),
                    'poids'       => $product->getPoids()
                ],
                'quantity' => $quantity,
            ];
        }
    }

    return $cartWithData;
}

    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getCart() as $item) {
            if ($item['product']) {
                $total += $item['product']['prix'] * $item['quantity'];

            }
        }

        return $total;
    }

    public function clear()
    {
        $this->getSession()->remove('cart');
    }
}