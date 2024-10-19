<?php

namespace App\DataFixtures;

use App\Entity\Product;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class ProductFixtures extends Fixture implements FixtureGroupInterface
{
    public const PRODUCT_1 = 'product 1';
    public const PRODUCT_2 = 'product 2';
    public const PRODUCT_3 = 'product 3';
    public const PRODUCT_4 = 'product 4';
    public const PRODUCT_5 = 'product 5';
    public const PRODUCT_6 = 'product 6';
    public const PRODUCT_7 = 'product 7';
    public const PRODUCT_8 = 'product 8';
    public const PRODUCT_9 = 'product 9';
    
    public function load(ObjectManager $manager): void
    {
        $faker = (new \Faker\Factory())::create('fr_FR');
        $productName = [
            "Kit d'hygiène recyclable",
            "Shot Tropical",
            "Gourde en bois",
            "Disques Démaquillants x3",
            "Bougie Lavande & Patchouli",
            "Brosse à dent",
            "Kit couvert en bois",
            "Nécessaire, déodorant Bio",
            "Savon Bio"
        ];
        $productPhoto = [
            "img/produit1.webp",
            "img/produit2.webp",
            "img/produit3.webp",
            "img/produit4.webp",
            "img/produit5.webp",
            "img/produit6.webp",
            "img/produit7.webp",
            "img/produit8.webp",
            "img/produit9.webp"
        ];
        $productShortDescription = [
            "Pour une salle de bain éco-friendly",
            "Fruits frais, pressés à froid",
            "50cl, bois d’olivier",
            "Solution efficace pour vous démaquiller en douceur ",
            "Cire naturelle",
            "Bois de hêtre rouge issu de forêts gérées durablement",
            "Revêtement Bio en olivier & sac de transport",
            "50ml déodorant à l’eucalyptus",
            "Thé, Orange & Girofle"
        ];
        $productPrice = [
            24.99,
            4.50,
            16.90,
            19.90,
            32,
            5.40,
            12.30,
            8.50,
            18.90
        ];

        // Création des produits
        $product1 = new Product();
        $product1
            ->setName($productName[0])
            ->setPhoto($productPhoto[0])
            ->setShortDescription($productShortDescription[0])
            ->setDescription($faker->paragraph(4))
            ->setPrice($productPrice[0]);
        $manager->persist($product1);
        $this->addReference(self::PRODUCT_1, $product1);   

        $product2 = new Product();
        $product2
            ->setName($productName[1])
            ->setPhoto($productPhoto[1])
            ->setShortDescription($productShortDescription[1])
            ->setDescription($faker->paragraph())
            ->setPrice($productPrice[1]);
        $manager->persist($product2);
        $this->addReference(self::PRODUCT_2, $product2);   

        $product3 = new Product();
        $product3
            ->setName($productName[2])
            ->setPhoto($productPhoto[2])
            ->setShortDescription($productShortDescription[2])
            ->setDescription($faker->paragraph(6))
            ->setPrice($productPrice[2]);
        $manager->persist($product3);
        $this->addReference(self::PRODUCT_3, $product3);   

        $product4 = new Product();
        $product4
            ->setName($productName[3])
            ->setPhoto($productPhoto[3])
            ->setShortDescription($productShortDescription[3])
            ->setDescription($faker->paragraph(5))
            ->setPrice($productPrice[3]);
        $manager->persist($product4);
        $this->addReference(self::PRODUCT_4, $product4);   

        $product5 = new Product();
        $product5
            ->setName($productName[4])
            ->setPhoto($productPhoto[4])
            ->setShortDescription($productShortDescription[4])
            ->setDescription($faker->paragraph(4))
            ->setPrice($productPrice[4]);
        $manager->persist($product5);
        $this->addReference(self::PRODUCT_5, $product5);   

        $product6 = new Product();
        $product6
            ->setName($productName[5])
            ->setPhoto($productPhoto[5])
            ->setShortDescription($productShortDescription[5])
            ->setDescription($faker->paragraph(7))
            ->setPrice($productPrice[5]);
        $manager->persist($product6);
        $this->addReference(self::PRODUCT_6, $product6);  
        
        $product7 = new Product();
        $product7
            ->setName($productName[6])
            ->setPhoto($productPhoto[6])
            ->setShortDescription($productShortDescription[6])
            ->setDescription($faker->paragraph(4))
            ->setPrice($productPrice[6]);
        $manager->persist($product7);
        $this->addReference(self::PRODUCT_7, $product7);   

        $product8 = new Product();
        $product8
            ->setName($productName[7])
            ->setPhoto($productPhoto[7])
            ->setShortDescription($productShortDescription[7])
            ->setDescription("Déodorant Nécessaire, une formule révolutionnaire composée exclusivement d'ingrédients naturels pour une protection efficace et bienfaisante.

            Chaque flacon de 50 ml renferme le secret d'une fraîcheur longue durée, sans compromettre votre bien-être ni l'environnement. Conçu avec soin, ce déodorant allie le pouvoir antibactérien des extraits de plantes aux vertus apaisantes des huiles essentielles, assurant une sensation de confort toute la journée. 

            Grâce à sa formule non irritante et respectueuse de votre peau, Nécessaire offre une alternative saine aux déodorants conventionnels, tout en préservant l'équilibre naturel de votre corps.")
            ->setPrice($productPrice[7]);
        $manager->persist($product8);
        $this->addReference(self::PRODUCT_8, $product8);   

        $product9 = new Product();
        $product9
            ->setName($productName[8])
            ->setPhoto($productPhoto[8])
            ->setShortDescription($productShortDescription[8])
            ->setDescription($faker->paragraph())
            ->setPrice($productPrice[8]);
        $manager->persist($product9);
        $this->addReference(self::PRODUCT_9, $product9);   

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['ProductFixtures'];
    }
}
