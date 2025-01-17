<?php

namespace App\DataFixtures;

use App\Entity\Evenement;
use App\Entity\Plateau;
use App\Factory\CarteFactory;
use App\Factory\DuelFactory;
use App\Factory\EvenementFactory;
use App\Factory\PlateauFactory;
use App\Factory\UtilisateurFactory;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        UtilisateurFactory::createMany(5);

        EvenementFactory::createMany(15, function() {
            return [
                'organisateur' => UtilisateurFactory::new(),
                'participant' => UtilisateurFactory::randomSet(2)
            ];
        });

        PlateauFactory::createMany(7, function() {
            return ['evenement' => EvenementFactory::random()];
        });

        CarteFactory::createMany(6, function() {
            return ['evenement' => EvenementFactory::random()];
        });

        DuelFactory::createMany(2, function() {
            return ['evenement' => EvenementFactory::random()];
        });

        $manager->flush();
    }
}
