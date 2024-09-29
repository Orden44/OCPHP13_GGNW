<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use App\Entity\User;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Doctrine\Bundle\FixturesBundle\FixtureGroupInterface;

class UserFixtures extends Fixture implements FixtureGroupInterface
{
    public function __construct(
        private UserPasswordHasherInterface $encoder
    )
    {
    }

    public const USER_1 = 'user 1';
    public const USER_2 = 'user 2';
    public const USER_3 = 'user 3';
    public const USER_4 = 'user 4';
    public const USER_5 = 'user 5';

    public function load(ObjectManager $manager): void
    {        
        $faker = (new \Faker\Factory())::create('fr_FR');

        // Création des utilisateurs
        $user1 = new User();
        $user1
            ->setLastName('Orden')
            ->setFirstName('Vittorio')
            ->setEmail('orden@gmail.com')
            ->setRoles(['ROLE_ADMIN'])
            ->setPassword($this->encoder->hashPassword($user1, 'Motdepasse'))
            ->setCguAccepted(true)
            ->setApiEnabled(true);
        $manager->persist($user1);
        $this->addReference(self::USER_1, $user1);

        $user2 = new User();
        $user2
            ->setLastName($faker->lastName())
            ->setFirstName($faker->firstName())
            ->setEmail($faker->freeEmail())
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->encoder->hashPassword($user2, $user2->getFirstName()))
            ->setCguAccepted(true)
            ->setApiEnabled(false);
        $manager->persist($user2);
        $this->addReference(self::USER_2, $user2);

        $user3 = new User();
        $user3
            ->setLastName($faker->lastName())
            ->setFirstName($faker->firstName())
            ->setEmail($faker->freeEmail())
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->encoder->hashPassword($user3, $user3->getFirstName()))
            ->setCguAccepted(false)
            ->setApiEnabled(true);
        $manager->persist($user3);
        $this->addReference(self::USER_3, $user3);

        $user4 = new User();
        $user4
            ->setLastName($faker->lastName())
            ->setFirstName($faker->firstName())
            ->setEmail($faker->freeEmail())
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->encoder->hashPassword($user4, $user4->getFirstName()))
            ->setCguAccepted(false)
            ->setApiEnabled(false);
        $manager->persist($user4);
        $this->addReference(self::USER_4, $user4);

        $user5 = new User();
        $user5
            ->setLastName($faker->lastName())
            ->setFirstName($faker->firstName())
            ->setEmail($faker->freeEmail())
            ->setRoles(['ROLE_USER'])
            ->setPassword($this->encoder->hashPassword($user5, $user5->getFirstName()))
            ->setCguAccepted(true)
            ->setApiEnabled(true);
        $manager->persist($user5);
        $this->addReference(self::USER_5, $user5);

        $manager->flush();
    }

    public static function getGroups(): array
    {
        return ['UserFixtures'];
    }
}
