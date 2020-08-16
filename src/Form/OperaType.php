<?php

namespace App\Form;


use App\Entity\Place;

use App\Entity\Treatment;
use App\Entity\Opera;
use App\Entity\User;

use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Security\Core\Security;

use App\Repository\TreatmentRepository;
use App\Repository\PlaceRepository;
use App\Repository\UserRepository;





class OperaType extends AbstractType
{

    private $treatmentRepository;
    private $placeRepository;
    private $userRepository;

    //private $typeId;
    private $centerId;

    public function __construct(Security $security, TreatmentRepository $treatmentRepository, PlaceRepository $placeRepository, UserRepository $userRepository )
    {
        $this->treatmentRepository = $treatmentRepository;
        $this->placeRepository = $placeRepository;
        $this->userRepository = $userRepository;


        $this->centerId = $security->getUser()->getCenter()->getId();



    }


    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event) {


            $form = $event->getForm();
            $opera = $event->getData();

            //$this->typeId = $opera->getType();

            //var_dump($opera);die;

            $form
                ->add('made_at', DateType::class, [
                    'widget' => 'single_text',
                    //'input' => 'string',
                    'format' => 'dd/MM/yyyy',
                    // prevents rendering it as type="date", to avoid HTML5 date pickers
                    'html5' => false,
                    // adds a class that can be selected in JavaScript
                    //'attr' => ['class' => 'js-datepicker'],               // desde el form
                    // 'label' => '',                                       // desde el form

                ])
                ->add('treatment', EntityType::class,[
                    'label' => 'label.treatment',
                    'class' =>  Treatment::class,
                    'choices' => $this->treatmentRepository->findBy(['type' => '6'], ['name' => 'ASC']),
                    'choice_label' => 'name',
                    'placeholder' => 'label.treatments',
                    'required' => false,

                ])
                ->add('user', EntityType::class,[
                    'label' => 'label.medic.user',
                    'class' =>  User::class,

                    'choices' => $this->userRepository->findBy(['center' => $this->centerId, 'medic' => true], ['lastname' => 'ASC']),

                    'choice_label' => 'lastname',

                    'required' => false,

            ]);

            if($opera->getId()){

                $form
                ->add('place', EntityType::class,[
                    'label' => 'label.place',
                    'class' =>  Place::class,
                    'choices' => $this->placeRepository->findBy(['center' => $this->centerId], ['name' => 'ASC']),
                    'choice_label' => 'name',
                    'placeholder' => 'label.places',
                    'required' => false,

                ]);



                #->add('tags', TagsInputType::class, [
                    #    'label' => 'label.tags',
                    #    'required' => false,
                    #])
                ;

            }

        });
    }







    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Opera::class,
        ]);
    }
}
