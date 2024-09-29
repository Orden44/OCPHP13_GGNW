<?php

namespace App\DataFixtures;

use App\Entity\CartItems;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class CartItemsFixtures extends Fixture implements DependentFixtureInterface, FixtureGroupInterface
{
    public const CART_ITEMS_1 = 'cart items 1';
    public const CART_ITEMS_2 = 'cart items 2';
    public const CART_ITEMS_3 = 'cart items 3';
    public const CART_ITEMS_4 = 'cart items 4';
    public const CART_ITEMS_5 = 'cart items 5';


    public function load(ObjectManager $manager): void
    {
        $cartItems1 = new CartItems;
        $cartItems1
            ->setByUser($this->getReference(UserFixtures::USER_4))
            ->setProduct($this->getReference(ProductFixtures::PRODUCT_8))
            ->setQuantity(2)
            ->setUnitPrice($cartItems1->getQuantity()*$cartItems1->getProduct()->getPrice($this->getReference(ProductFixtures::PRODUCT_8)));
        $manager->persist($cartItems1);
        $this->addReference(self::CART_ITEMS_1, $cartItems1);  

        $cartItems2 = new CartItems;
        $cartItems2
            ->setByUser($this->getReference(UserFixtures::USER_4))
            ->setProduct($this->getReference(ProductFixtures::PRODUCT_2))
            ->setQuantity(3)
            ->setUnitPrice($cartItems2->getQuantity()*$cartItems2->getProduct()->getPrice($this->getReference(ProductFixtures::PRODUCT_2)));
        $manager->persist($cartItems2);
        $this->addReference(self::CART_ITEMS_2, $cartItems2);  

        $cartItems3 = new CartItems;
        $cartItems3
            ->setByUser($this->getReference(UserFixtures::USER_4))
            ->setProduct($this->getReference(ProductFixtures::PRODUCT_5))
            ->setQuantity(1)
            ->setUnitPrice($cartItems3->getQuantity()*$cartItems3->getProduct()->getPrice($this->getReference(ProductFixtures::PRODUCT_5)));
        $manager->persist($cartItems3);
        $this->addReference(self::CART_ITEMS_3, $cartItems3);  

        $cartItems4 = new CartItems;
        $cartItems4
            ->setByUser($this->getReference(UserFixtures::USER_1))
            ->setProduct($this->getReference(ProductFixtures::PRODUCT_5))
            ->setQuantity(3)
            ->setUnitPrice($cartItems4->getQuantity()*$cartItems4->getProduct()->getPrice($this->getReference(ProductFixtures::PRODUCT_5)));
        $manager->persist($cartItems4);
        $this->addReference(self::CART_ITEMS_4, $cartItems4);  

        $cartItems5 = new CartItems;
        $cartItems5
            ->setByUser($this->getReference(UserFixtures::USER_3))
            ->setProduct($this->getReference(ProductFixtures::PRODUCT_9))
            ->setQuantity(1)
            ->setUnitPrice($cartItems5->getQuantity()*$cartItems5->getProduct()->getPrice($this->getReference(ProductFixtures::PRODUCT_9)));
        $manager->persist($cartItems5);
        $this->addReference(self::CART_ITEMS_5, $cartItems5);  

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            UserFixtures::class, ProductFixtures::class
        ];
    }

    public static function getGroups(): array
    {
        return ['CartItemsFixtures'];
    }
}
