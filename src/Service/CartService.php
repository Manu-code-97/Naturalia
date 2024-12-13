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
        //dd($cart);
        foreach ($cart as $id => $quantity) {
            $cartWithData[] = [
                'product' => $this->produitRepository->find($id),
                'quantity' => $quantity,
            ];
        }

        return $cartWithData;
    }

    public function getTotal(): float
    {
        $total = 0;
        foreach ($this->getCart() as $item) {
            $total += $item['product']->getPrix() * $item['quantity'];
        }

        return $total;
    }

    public function clear()
    {
        $this->getSession()->remove('cart');
    }
}