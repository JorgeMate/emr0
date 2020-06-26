<?php

namespace App\DataFixtures;

#use Doctrine\Bundle\FixturesBundle\Fixture;
use Faker\ORM\Doctrine\Populator;


use Doctrine\Persistence\ObjectManager;

use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

#use Symfony\Component\Security\Core\User\UserInterface;

use Symfony\Component\Security\Core\Security;


use App\Entity\Center;
use App\Entity\User;


class SeedFixtures extends AppFixtures
{

    private $locale = 'nl_NL';
    private $repeatData = true;

    
    protected $generator;
    protected $populator;
    protected $passwordEncoder;

    private $centersNumber; 
    private $usersxCenter;

    private $security;

    private $passUniversalEncoded;
    private $passUniversal = '4444';

    

    public function __construct( Security $security, UserPasswordEncoderInterface $passwordEncoder, $centers = 5, $usersxCenter = 3)
    {

        
        $this->security = $security;

        $this->centersNumber = $centers;
        $this->usersxCenter = $usersxCenter;

    
        $this->passwordEncoder = $passwordEncoder;

        $user = $this->security->getUser();

        var_dump($user);

        $this->passUniversalEncoded = null;

        #$this->passUniversalEncoded = $this->passwordEncoder->encodePassword(
        #    $user,
        #    $this->passUniversal
        #);



        
        $this->generator = \Faker\Factory::create($this->locale);
        if ($this->repeatData){
            $this->generator->seed(1234);
        }


        

        

    }

    public function load(ObjectManager $manager)
    {
        $this->populator = new Populator($this->generator, $manager);







        if ($this->centersNumber){
            $this->seedCenters($this->centersNumber);   
        }


    }

    private function seedCenters()
    {
        $generator = $this->generator;

        for($x = 1; $x <= $this->centersNumber; $x++) {

            $this->populator->addEntity('App:Center', 1,    
                array(
                'name' => function() use ($generator) { return $this->generator->company(); },
                'slug' => function() use ($generator) { return $this->generator->slug(); },
                'contactPerson' => function() use ($generator) { return $this->generator->name(); },
                'address' => function() use ($generator) { return $this->generator->streetName(); },
                'tel' => function() use ($generator) { return $this->generator->phoneNumber(); },
                )
            );

            //$insertedPKs = $this->populator->execute();

            if($this->usersxCenter){
                $this->seedUsers();
            } else {
                $insertedPKs = $this->populator->execute();
            }

            #if($this->treatmentsxType){
            #    $this->seedTypes();
            #}

        }
    }


    private function seedUsers()
    {

        $password_requested_at = null;
        $confirmation_token = null;

        $generator = $this->generator;
        $this->populator->addEntity('App:User', $this->usersxCenter,
            array(
            'password' => $this->passUniversalEncoded,
            'tel' => function() use ($generator) { return $this->generator->phoneNumber(); },
            'passwordRequestedAt' => $password_requested_at,
            'confirmationToken' => $confirmation_token,
            'cod' => function() use ($generator) { return strtoupper($this->generator->lexify('???')); },
            'title' => function() use ($generator) { return $this->generator->randomElement($array = array ('Dr.','Dra.','Drs.')); },
            'tax_code' => function() use ($generator) { return $this->generator->bothify('??-########'); },
            'reg_code1' => function() use ($generator) { return $this->generator->bothify('?/########??'); },
            'reg_code2' => function() use ($generator) { return $this->generator->bothify('#? ####### ##'); },
            'speciality' => function() use ($generator) { return strtoupper($this->generator->lexify(' ?????????')); },
            )
        );


        $insertedPKs = $this->populator->execute();

    
    }


}
