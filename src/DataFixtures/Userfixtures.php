<?php

namespace App\DataFixtures;

use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

use App\Entity\User;
#use App\Entity\Center;

class Userfixtures extends Fixture
{
    #private $loadSuperUser = 1;
    private $loadCenter = 0;
    /////////////////////////////


    private $passUniversal = '4444';
    private $passUniversalEncoded;

    private $passwordEncoder;

        public function __construct(UserPasswordEncoderInterface $passwordEncoder)
        {
            $this->passwordEncoder = $passwordEncoder;
        }


    public function load(ObjectManager $manager)
    {


        if ($this->loadCenter){
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

        }

        

        $user = new User();
        if ($this->loadCenter){
            $user->setCenter($center);
            $user->setCenterUser(true);
        }
        $user->setFirstName('Jorge');
        $user->setLastName('Maté');
        $user->setEmail('jorgematemartinez@gmail.com');
        $user->setTel('(+34) 636 831 823');

        $this->passUniversalEncoded = $this->passwordEncoder->encodePassword(
            $user,
            $this->passUniversal
        );

        $user->setPassword($this->passUniversalEncoded);
        $user->setEnabled(true);

        $roles[] = 'ROLE_SUPER_ADMIN';
        $user->setRoles($roles);
        
        $manager->persist($user);
        $manager->flush();
    }



}
