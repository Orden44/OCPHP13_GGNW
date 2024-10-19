<?php

namespace App\DataFixtures;

use DateTime;
use App\Entity\CustomerOrder;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use App\DataFixtures\UserFixtures;
use App\DataFixtures\CartItemsFixtures;

class CustomerOrderFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public const ORDER_1 = 'order 1';
    public const ORDER_2 = 'order 2';
    public const ORDER_3 = 'order 3';

    public function load(ObjectManager $manager): void
    {
        $order1 = new CustomerOrder;
        $order1
            ->setByUser($this->getReference(UserFixtures::USER_4))
            ->setOrderDate(new DateTime('now -' . mt_rand(1,25). ' day'));
            $cartItems1 = [
                $this->getReference(CartItemsFixtures::CART_ITEMS_1),
                $this->getReference(CartItemsFixtures::CART_ITEMS_2),
                $this->getReference(CartItemsFixtures::CART_ITEMS_3)
            ];

            foreach ($cartItems1 as $cartItems) {
                $order1->addCartItem($cartItems);
            }

            // Récupération des prix unitaires des éléments spécifiés
            $unitPrice1 = $order1->getCartItems()[0]->getUnitPrice();
            $unitPrice2 = $order1->getCartItems()[1]->getUnitPrice();
            $unitPrice3 = $order1->getCartItems()[2]->getUnitPrice();
            // Calcul du prix total du panier en additionnant les prix unitaires spécifiés
            $totalPrice = $unitPrice1 + $unitPrice2 + $unitPrice3;
            $order1->setTotalPrice($totalPrice);    
        $manager->persist($order1);
        $this->addReference(self::ORDER_1, $order1);  

        $order2 = new CustomerOrder;
        $order2
            ->setByUser($this->getReference(UserFixtures::USER_1))
            ->setOrderDate(new DateTime('now -' . mt_rand(1,25). ' day'))
            ->addCartItem($this->getReference(CartItemsFixtures::CART_ITEMS_4));
            $totalPrice = $order2->getCartItems()[0]->getUnitPrice();
            $order2->setTotalPrice($totalPrice);
        $manager->persist($order2);
        $this->addReference(self::ORDER_2, $order2);  

        $order3 = new CustomerOrder;
        $order3
            ->setByUser($this->getReference(UserFixtures::USER_3))
            ->setOrderDate(new DateTime('now -' . mt_rand(1,25). ' day'))
            ->addCartItem($this->getReference(CartItemsFixtures::CART_ITEMS_5));
            $totalPrice = $order3->getCartItems()[0]->getUnitPrice();
            $order3->setTotalPrice($totalPrice);
        $manager->persist($order3);
        $this->addReference(self::ORDER_3, $order3);  

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class, CartItemsFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return ['CustomerOrderFixtures'];
    }
}
