<?php

namespace App\Controller;

use App\Repository\ProduitRepository;
use App\Repository\MagasinRepository;
use App\Repository\CalculDistanceMag;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use Symfony\Component\Routing\Annotation\Route;

class CheckOutController extends AbstractController
{
    private CartService $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    #[Route('/panier', name: 'app_check_out')]
    public function index(ProduitRepository $repo/* , $product */): Response
    {

        // $productDetail = $repo->find($product);
        // $productsSelection = $repo -> aleatProducts(20);

        $items = $this->cartService->getCart();
        /* dd($items); */
        $total = $this->cartService->getTotal();

            
        return $this->render('checkout/index.html.twig', [
            'controller_name' => 'CheckOutController',
            'items' => $items,
            'total' => $total,
            // 'productsSelection' => $productsSelection, 
        ]);
    }

    #[Route('/cart', name: 'cart_show')]
    public function showCart(): Response
    {
        return $this->render('checkout/index.html.twig', [
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
    #[Route('/cart/add/{id}', name: 'cart_add', methods: ['POST'])]
    public function addToCart($id): JsonResponse
    {
        $this->cartService->add($id);

        return new JsonResponse([
            'items' => $this->cartService->getCart(),
            'total' => $this->cartService->getTotal(),
        ]);
    }

    #[Route('/cart/update/{id}', name: 'cart_update', methods: ['POST'])]
    public function updateCart($id, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $id = (int) $id; // Convertir l'ID en entier

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

    #[Route('/panier/livraison/', name: 'app_panier_livraison')]
    public function panierLivraison(): Response
    {   

        return $this->render('checkout/delivery.html.twig', [
        ]);
    }

    #[Route('/panier/retrait/{cp}', name: 'retrait', defaults: ['cp' => '75001'])]
    public function panierCollect(MagasinRepository $repo, CalculDistanceMag $calc, $cp): Response
    {   
        $magasinsDB = $repo->getAllStores();
        // dd($magasins);
        $magasins = $calc->calculDistance($magasinsDB, $cp);
        // dd($magasins);
        return $this->render('checkout/collect.html.twig', [
            'magasins' => $magasins,
            'cp' => $cp
        ]);
    }

    #[Route('/panier/paiement', name: 'app_panier_paiement')]
    #[IsGranted('ROLE_USER')]
    public function panierPaiement(ProduitRepository $repo): Response
    {
        //$products = $repo->findProductsOfSousCategory($livraison);
        $products = $repo->createQueryBuilder('p')
        ->getQuery()
        ->getResult();

        return $this->render('checkout/paiementDelivery.html.twig', [
            'controller_name' => 'CheckOutController',
            'products' => $products,
        ]);
    }


    #[Route('/confirmation', name: 'app_confirmation')]
    #[IsGranted('ROLE_USER')]
    public function confirmation(): Response
    {
        return $this->render('checkout/confirmation.html.twig', [
            'controller_name' => 'CheckOutController',
        ]);
    }
}
