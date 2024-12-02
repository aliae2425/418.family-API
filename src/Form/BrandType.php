<?php

namespace App\Form;

use App\Entity\BrandCategory;
use App\Entity\Brands;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class BrandType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('slug')
            ->add('categories', EntityType::class, [
                'class' => BrandCategory::class,
                'choice_label' => 'name',
            ])
            ->add('File', DropzoneType::class, [
                'label' => 'Image',
                "required" => false,
                'attr' => [
                    'placeholder' => 'Choisir une image'
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Brands::class,
        ]);
    }
}
