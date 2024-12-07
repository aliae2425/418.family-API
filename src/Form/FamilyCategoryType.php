<?php

namespace App\Form;

use App\Entity\FamilyCategory;
use App\Factory\FormEventFactory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class FamilyCategoryType extends AbstractType
{
    public function __construct(
        private FormEventFactory $formEventFactory,
    ){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('parents', EntityType::class, [
                'class' => FamilyCategory::class,
                'choice_label' => 'Name',
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Save',
            ])
            ->add('slug', HiddenType::class)
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->formEventFactory->autoSlug('name'))
            ->addEventListener(FormEvents::POST_SUBMIT, $this->formEventFactory->dateTimeUpdate())
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => FamilyCategory::class,
        ]);
    }
}
