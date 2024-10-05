<?php

namespace App\Service;

use App\Entity\User;

class TotalPrice
{
    public static function calculate(User $user)
    {
        $cart = $user->getCartItems();

        $totalPrice = 0;

        foreach ($cart as $cartItem) {
            $totalPrice += $cartItem->getUnitPrice() * $cartItem->getQuantity();
        }

        return $totalPrice;
    }
}