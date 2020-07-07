<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use Faker\ORM\Doctrine\Populator;

use App\Entity\Center;
use App\Entity\User;


class UserFixtures extends Fixture
{
    private $locale = 'nl_NL';
    private $repeatData = true;

    private $generator;
    private $populator;

    private $manager;
    private $encoder;

    private $passUniversal = '4444';


    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
        $this->generator = \Faker\Factory::create($this->locale);        
    }


    public function load(ObjectManager $manager, $loadsuper = 1, $seedCenters = 3)
    {
        $this->populator = new Populator($this->generator, $manager);
        $this->manager = $manager;

        if($loadsuper)
        {
            $this->loadSuper();
        }

        if($seedCenters)
        {

        }






        $manager->flush();
    }






    private function loadSuper()
    {

        $center = new Center();
        $center->setName('Kimberly Systems SLU');
        $center->setContactPerson('Jorge Maté Martínez');
        $center->setTel('(+34) 636 831 823');
        $center->setEmail('kimberly.systems@gmail.com');
        $center->setAddress('Piteres 2 1-C');
        $center->setPostcode('E-03590');
        $center->setCity('Altea');
        $center->setEnabled(true);
        
        $this->manager->persist($center);

        $user = new User();
        $user->setCenter($center);
        $user->setCenterUser(true);
        $user->setFirstName('Jorge');
        $user->setLastName('Maté');
        $user->setEmail('jorgematemartinez@gmail.com');
        $user->setTel('(+34) 636 831 823');

        $this->passUniversalEncoded = $this->encoder->encodePassword(
            $user,
            $this->passUniversal
        );

        $user->setPassword($this->passUniversalEncoded);
        $user->setEnabled(true);

        $roles[] = 'ROLE_SUPER_ADMIN';
        $user->setRoles($roles);
        
        $this->manager->persist($user);
        $this->manager->flush();
    }

    


}
