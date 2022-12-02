<?php

namespace App\DataFixtures;

use App\Entity\Pub;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class PubFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $oconnels = new Pub();
        $oconnels->setName("O'Connell's");
        $oconnels->setImage("oconnell.jpg");
        $oconnels->setAddress("6 Pl. du Parlement de Bretagne");
        $oconnels->setZipCode("35000");
        $oconnels->setCity("Rennes");
        $manager->persist($oconnels);

        $templeBar = new Pub();
        $templeBar->setName("Temple Bar");
        $templeBar->setImage("templebar.jpg");
        $templeBar->setAddress("647-48 Temple Bar");
        $templeBar->setZipCode("D02 N725");
        $templeBar->setCity("Dublin");
        $manager->persist($templeBar);

        $theBrazenHead = new Pub();
        $theBrazenHead->setName("The Brazen Head");
        $theBrazenHead->setImage("thebrazenhead.jpg");
        $manager->persist($theBrazenHead);

        $mulligans = new Pub();
        $mulligans->setName("Mulligans");
        $mulligans->setImage("mulligans.jpg");
        $manager->persist($mulligans);

        $manager->flush();
    }
}
