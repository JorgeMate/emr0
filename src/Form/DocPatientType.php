<?php

namespace App\Form;

use App\Entity\DocPatient;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Validator\Constraints\NotNull;



class DocPatientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {

        /** @var DocPatient|null $image */

        $doc = $options['data'] ?? null;
        $isEdit = $doc && $doc->getId();

        if(!$isEdit || !$image->getName())
        {
            $docConstraints = [
                new NotNull([
                    'message' => 'Please upload a DOC file  !!!',
                ])

            ];
        }

        $docConstraints = [
            new File([
                'maxSize' => '2M',
                'mimeTypes' => [
                    
                    'application/pdf',
                    'application/x-pdf',
                ]
            ]),
        ];



        $builder->add('docFile', FileType::class, [
            'mapped' => false,
            'label' => ' ',
            'required' => false,
            'constraints' => $docConstraints

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
