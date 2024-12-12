<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class CartService
{
    private SessionInterface $session;
    private const CART_KEY = 'cart';

    public function __construct(SessionInterface $session)
    {
        $this->session = $session;
    }

    public function addItem(int $productId, int $quantity = 1): void
    {
        // Récupérer le panier actuel
        $cart = $this->session->get(self::CART_KEY, []);

        // Ajouter ou mettre à jour le produit dans le panier
        if (isset($cart[$productId])) {
            $cart[$productId] += $quantity;
        } else {
            $cart[$productId] = $quantity;
        }

        // Sauvegarder dans la session
        $this->session->set(self::CART_KEY, $cart);
    }

    public function removeItem(int $productId): void
    {
        $cart = $this->session->get(self::CART_KEY, []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
        }

        $this->session->set(self::CART_KEY, $cart);
    }

    public function getCart(): array
    {
        return $this->session->get(self::CART_KEY, []);
    }

    public function clearCart(): void
    {
        $this->session->remove(self::CART_KEY);
    }
}

