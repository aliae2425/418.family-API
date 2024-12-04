<?php

namespace App\Form;

use App\Entity\BrandCategory;
use App\Entity\Brands;
use App\Factory\FormEventFactory;
use Doctrine\Common\EventSubscriber;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;

class BrandType extends AbstractType
{

    public function __construct(
        private FormEventFactory $formEventFactory
    ){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('categories', EntityType::class, [
                'multiple' => true,
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
            ->add('slug', HiddenType::class, [
                'required' => false, 

            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->formEventFactory->autoSlug('name'))
            ->addEventListener(FormEvents::POST_SUBMIT, $this->formEventFactory->dateTimeUpdate())
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Brands::class,
        ]);
    }
}
