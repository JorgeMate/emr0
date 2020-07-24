<?php

namespace App\Form;

use App\Entity\DocPatient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Validator\Constraints\Image;
use Symfony\Component\Validator\Constraints\NotNull;
#use Vich\UploaderBundle\Form\Type\VichFileType;



class DocPatient2Type extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /** @var DocPatient|null $image */

        $image = $options['data'] ?? null;
        $isEdit = $image && $image->getId();

        $imageConstraints = [
            new Image([
                'maxSize' => '2M',
                'mimeTypes' => [
                    'image/*',
                    'application/pdf',
                ]
            ]),
        ];


        if(!$isEdit || !$image->getName())
        {
            $imageConstraints = [
                new NotNull([
                    'message' => 'Please upload an image !!!',
                ])

            ];
        }

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
            'data_class' => DocPatient::class,
        ]);
    }
}
