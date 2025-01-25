<?php

namespace App\Controller;

use App\Repository\CartRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class GlobalController extends AbstractController
{

    public function getCartCount(CartRepository $cartRepository): int
    {
        $user = $this->getUser();
        if ($user) {
            $cart = $cartRepository->findCurrentUserCart($user);
            if ($cart) {
                return $cart->getFamillyCount();
            }
        }
        return 0;
    }
}
