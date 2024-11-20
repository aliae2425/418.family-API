<?php

namespace App\Form;

use App\Entity\Fabricant;
use App\Form\FormFactory\FormListenerFactory;
use Doctrine\DBAL\Types\Type;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Image;

class BrandType extends AbstractType
{
    public function __construct(
        private FormListenerFactory $formListenerFactory
    ){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('sousTitre', TextType::class, [
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('thumbnailFile', FileType::class, [
                'required' => false,
                'mapped' => false,
                'constraints' => [
                    new Image()
                ],
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
                'attr' => [
                    'class' => 'btn btn-primary',
                ],
            ])
            ->addEventListener(FormEvents::PRE_SUBMIT, $this->formListenerFactory->AutoSlug('name'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fabricant::class,
        ]);
    }
}
