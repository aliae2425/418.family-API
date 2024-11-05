<?php

namespace App\Form;

use App\Entity\Category;
use App\Entity\Fabricant;
use App\Entity\Family;
use App\Form\FormFactory\FormListenerFactory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FamilyType extends AbstractType
{

    public function __construct(
        private FormListenerFactory $formListenerFactory
    ){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('familyFileName')
            ->add('thumbnailFile')
            ->add('fabricant', EntityType::class, [
                'class' => Fabricant::class,
                'choice_label' => 'name',
                "required" => false,
            ])
            ->add('categori', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->formListenerFactory->AutoSlug('name'));
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Family::class,
        ]);
    }
}
