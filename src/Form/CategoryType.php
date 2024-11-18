<?php

namespace App\Form;

use App\Entity\Category;
use App\Form\FormFactory\FormListenerFactory;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;

class CategoryType extends AbstractType
{

    public function __construct(
        private FormListenerFactory $formListenerFactory
    ){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description',TextareaType::class, [
                'constraints' => [
                    new Length(
                        min : 10,
                        max : 255,
                        minMessage: 'La description doit contenir au moins 10 caractères',
                        maxMessage: 'La description doit contenir au maximum 255 caractères'
                    ),
                ],
            ])
            ->add('_parent', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'id',
                'required' => false,
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->formListenerFactory->AutoSlug('name'));
          }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
        ]);
    }
}
