<?php

namespace App\Form;

use App\Entity\Brands;
use App\Entity\Family;
use App\Entity\familyCategory;
use App\Factory\FormEventFactory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class FamilyType extends AbstractType
{

    public function __construct(
        private FormEventFactory $formEventFactory
    ){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('familyCategory', EntityType::class, [
                'class' => familyCategory::class,
                'choice_label' => 'name',
            ])
            ->add('brand', EntityType::class, [
                'class' => Brands::class,
                'required' => false,
                'choice_label' => 'name',
            ])
            ->add('thumbnailFile', DropzoneType::class, [
                'label' => 'Image',
                'required' => false,
            ])
            ->add('revitFamilyFile', DropzoneType::class, [
                'required' => true,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, $this->formEventFactory->dateTimeUpdate())   
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Family::class,
        ]);
    }
}
