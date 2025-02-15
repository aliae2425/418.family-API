<?php

namespace App\Controller\User\Collection;

use App\Entity\Cart;
use App\Entity\User;
use App\Entity\Family;
use App\Entity\FamilyCollection;
use App\Repository\CartRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class CartController extends AbstractController
{
    #[Route('/cart', name: 'user_cart_index')]
    public function index(CartRepository $repo): Response
    {

        $user = $this->getUser();
        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }
        $cart = $repo->findCurrentUserCart($user);
        // dd($cart);

        return $this->render('User/Collection/cart/index.html.twig', [
            'cart' => $cart,
        ]);
    }

    #[Route('/cart/add/{id}', name: 'user_cart_add', requirements: ['id' => '\d+'])]
    public function addItem(Family $family, CartRepository $repo, Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

        $cart = $repo->findCurrentUserCart($user);
        if ($cart === null) {
            $cart = new Cart();
            $cart->setUser($user);
        }

        $cart->addFamilly($family);
        $cart->setValue($cart->getValue() + $family->getPrice());
        $user->setCurrentCartCount($user->getCurrentCartCount() + 1);
        $em->persist($user);
        $em->persist($cart);
        $em->flush();   

        $referer = $request->headers->get('referer');
        $this->addFlash('success', 'L\'article a bien été ajouté à votre panier');
        return $this->redirect($referer);
    }

    #[Route('/cart/remove/{id}', name: 'user_cart_remove', requirements: ['id' => '\d+'])]
    public function removeItem(Family $family, Request $request, CartRepository $repo, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

        $cart = $repo->findCurrentUserCart($user);
        if ($cart === null) {
            $this->addFlash('danger', "Vous n'avez pas de panier");
        }
        $user->setCurrentCartCount($user->getCurrentCartCount() - 1);
        $cart->removeFamilly($family);
        $cart->setValue($cart->getValue() - $family->getPrice());
        $em->persist($user);
        $em->persist($cart);
        $em->flush();

        $referer = $request->headers->get('referer');
        $this->addFlash('success', 'L\'article a bien été supprimé de votre panier');
        return $this->redirect($referer);
    }

    #[Route('/cart/clear', name: 'user_cart_clear')]
    public function clearCart(Request $request, CartRepository $repo, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

        $cart = $repo->findCurrentUserCart($user);
        if ($cart === null) {
            $this->addFlash('danger', "Vous n'avez pas de panier");
        }

        $cart->clearFamillies();
        $user->setCurrentCartCount(0);
        $em->persist($user);
        $em->persist($cart);
        $em->flush();
        $this->addFlash('success', 'Votre panier a bien été vidé');
        
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    #[Route('/cart/quick-add/{id}', name: 'user_cart_quickAdd', requirements: ['id' => '\d+'])]
    public function quickAddItem(Family $family, Request $request, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

        if ($user->getCoins() < $family->getPrice()) {
            $this->addFlash('danger', 'Vous n\'avez pas assez de pièces pour acheter cet article');
            return $this->redirectToRoute('public_asset_index');
        }

        $cart = new Cart();
        $cart->setUser($user);
        $cart->addFamilly($family);
        $cart->setValue($cart->getValue() + $family->getPrice());
        $cart->setValidate(true);
        $cart->setValidationAt(new \DateTimeImmutable());

        $user->removeCoins($cart->getValue());
        $user->addFamilliesCollection($family);
        $user->updateActivity();

        $em->persist($user);
        $em->persist($cart);
        $em->flush(); 

        $this->addFlash('success', 'L\'article a bien été ajouté à votre collection');
        $referer = $request->headers->get('referer');
        return $this->redirect($referer);
    }

    #[Route('/cart/validate', name: 'user_cart_checkout')]
    public function validateCart(Request $request, CartRepository $repo, EntityManagerInterface $em)
    {
        $user = $this->getUser();
        if ($user === null) {
            return $this->redirectToRoute('app_login');
        }

        $cart = $repo->findCurrentUserCart($user);
        if ($cart === null) {
            $this->addFlash('danger', "Vous n'avez pas de panier");
        }

        if ($user->getCoins() < $cart->getValue()) {
            $this->addFlash('danger', 'Vous n\'avez pas assez de pièces pour valider votre panier');
        }else if ($cart->getFamillies()->isEmpty()) {
            $this->addFlash('danger', 'Votre panier est vide');
        }else {
            foreach($cart->getFamillies() as $family) {
                $user->addFamilliesCollection($family);
            }

            $cart->setValidationAt(new \DateTimeImmutable());
            $cart->setValidate(true);

            $user->removeCoins($cart->getValue());
            $user->updateActivity();
            $user->setCurrentCartCount(0);

            $em->persist($user);
            $em->persist($cart);
            $newCart = new Cart();
            $newCart->setUser($user);
            $em->persist($newCart);
            $em->flush();
            $this->addFlash('success', 'Votre panier a bien été validé');
        }
        $referer = $request->headers->get('referer');
        $this->addFlash('success', 'L\'article a bien été ajouté à votre panier');
        return $this->redirect($referer);
    }
}
