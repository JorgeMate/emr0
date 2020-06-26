<?php

namespace App\DataFixtures;

#use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\Center;
use App\Entity\User;


class UserFixtures extends AppFixtures
{

    private $passwordEncoder;

        public function __construct(UserPasswordEncoderInterface $passwordEncoder)
        {
            $this->passwordEncoder = $passwordEncoder;
        }


    public function load(ObjectManager $manager)
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
        
        $manager->persist($center);

        $user = new User();

        
        $this->passUniversalEncoded = $this->passwordEncoder->encodePassword(
            $user,
            $this->passUniversal
        );



        $user->setCenter($center);
        $user->setCenterUser(true);
        $user->setFirstName('Jorge');
        $user->setLastName('Maté');
        $user->setEmail('jorgematemartinez@gmail.com');
        $user->setTel('(+34) 636 831 823');


        $user->setPassword($this->passwordEncoder->encodePassword(
                         $user,
                         '4444'
                     ));

        $manager->persist($user);
        $manager->flush();
    }
}
