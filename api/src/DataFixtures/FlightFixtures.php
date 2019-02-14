<?php
/**
 * Created by IntelliJ IDEA.
 * User: gurnavdeepsingh
 * Date: 14/02/2019
 * Time: 10:16
 */

namespace App\DataFixtures;

use App\Entity\Flight;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Faker;

class FlightFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {

        // On configure dans quelles langues nous voulons nos données
        $faker = Faker\Factory::create('fr_FR');

        // on créé 10 personnes
        for ($i = 0; $i < 10; $i++) {
            $airports = $manager->getRepository('App:Airport')->findAll();
            $planes = $manager->getRepository('App:Plane')->findAll();
            $flight = new Flight();
            $flight->setDepartureAirport($airports[rand(0, count($airports)-1)]);
            $flight->setArrivalAirport($airports[rand(0, count($airports)-1)]);
            $flight->setDepartureDate($faker->dateTime($format = 'Y-m-d'));
            $flight->setArrivalDate($faker->dateTime($format = 'Y-m-d'));
            $flight->setNumber($faker->randomNumber(4));
            $flight->setPlane($planes[$i]);
            $manager->persist($flight);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return array(
            AirportFixtures::class,
            PlaneFixtures::class,
        );
    }
}
