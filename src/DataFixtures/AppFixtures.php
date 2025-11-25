<?php

namespace App\DataFixtures;

use App\Entity\User;
use App\Entity\Pathologie;
use App\Entity\Conference;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class AppFixtures extends Fixture
{
    public function __construct(private UserPasswordHasherInterface $hasher) {}

    public function load(ObjectManager $manager): void
    {
        // ADMIN
        $admin = new User();
        $admin->setEmail("admin@mail.com");
        $admin->setName("Administrateur");
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->hasher->hashPassword($admin, "adminpass"));
        $manager->persist($admin);

        // MEDECIN
        $m1 = new User();
        $m1->setEmail("alice@mail.com");
        $m1->setName("Dr Alice");
        $m1->setRoles(["ROLE_MEDECIN"]);
        $m1->setPassword($this->hasher->hashPassword($m1, "alicepass"));
        $manager->persist($m1);

        // PATHOLOGIE
        $p = new Pathologie();
        $p->setLibelle("Épilepsie");
        $manager->persist($p);

        // CONFÉRENCE
        $c = new Conference();
        $c->setTitre("Conférence épilepsie 2025");
        $c->setDate(new \DateTime("2025-12-01 15:00"));
        $c->setMedecin($m1);
        $c->setPathologie($p);
        $manager->persist($c);
        $manager->flush();
    }
}
