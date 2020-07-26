<?php

namespace App\Form;

use App\Entity\DocImgPatient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;



class DocImgPatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /** @var DocImgPatient|null $image */

        $image = $options['data'] ?? null;
        $isEdit = $image && $image->getId();

        if(!$isEdit || !$image->getName())
        {
            $imageConstraints = [
                new NotNull([
                    'message' => 'Please upload an IMAGE file  !!!',
                ])

            ];
        }


        $imageConstraints = [
            new Image([
                'maxSize' => '2M',
                'mimeTypes' => [
                    'image/*',
                ]
            ]),
        ];



        $builder->add('docFile', FileType::class, [
            'mapped' => false,
            'label' => ' ',
            'required' => false,
            'constraints' => $imageConstraints

        ])

        ->add('description', TextType::class, [
            'label' => ' ',
            'required' => false,
        ]);


    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => DocImgPatient::class,
        ]);
    }
}
