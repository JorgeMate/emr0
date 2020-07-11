<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;


class MedicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder

        ->add('speciality', TextType::class, [
            'label' => 'label.medic.spec',
        ])

        ->add('title', TextType::class, [
            'label' => 'label.medic.title',
        ])

        ->add('tax_code', TextType::class, [
            'label' => 'label.medic.tax',
            'required' => false,
        ])
        ->add('reg_code1', TextType::class, [
            'label' => 'label.medic.reg1',
            'required' => false,
        ])
        ->add('reg_code2', TextType::class, [
            'label' => 'label.medic.reg2',
            'required' => false,
        ])

        ->add('internal', CheckboxType::class, [
            'label' => 'label.medic.internal',
            'required' => false,
        ])
        ->add('cod', TextType::class, [
            'label' => 'label.medic.COD',
        ])
;
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
