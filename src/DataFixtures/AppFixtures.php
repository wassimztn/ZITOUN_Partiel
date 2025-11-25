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
        $admin->setEmail("admin@example.com");
        $admin->setName("Admin");
        $admin->setRoles(["ROLE_ADMIN"]);
        $admin->setPassword($this->hasher->hashPassword($admin, "password"));
        $manager->persist($admin);

        // MEDECIN
        $medecin = new User();
        $medecin->setEmail("medecin@example.com");
        $medecin->setName("Dr Médecin");
        $medecin->setRoles(["ROLE_MEDECIN"]);
        $medecin->setPassword($this->hasher->hashPassword($medecin, "password"));
        $manager->persist($medecin);

        // PATHOLOGIES
        $pathologie1 = new Pathologie();
        $pathologie1->setLibelle("Épilepsie");
        $manager->persist($pathologie1);

        $pathologie2 = new Pathologie();
        $pathologie2->setLibelle("Diabète");
        $manager->persist($pathologie2);

        $pathologie3 = new Pathologie();
        $pathologie3->setLibelle("Asthme");
        $manager->persist($pathologie3);

        // CONFÉRENCES
        $conf1 = new Conference();
        $conf1->setTitre("Traitement de l'épilepsie - Nouveautés 2025");
        $conf1->setDate(new \DateTime("2025-12-01 15:00"));
        $conf1->setMedecin($medecin);
        $conf1->setPathologie($pathologie1);
        $manager->persist($conf1);

        $conf2 = new Conference();
        $conf2->setTitre("Gestion du diabète type 2");
        $conf2->setDate(new \DateTime("2025-12-05 14:30"));
        $conf2->setMedecin($medecin);
        $conf2->setPathologie($pathologie2);
        $manager->persist($conf2);

        $manager->flush();
    }
}
