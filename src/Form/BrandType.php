<?php

namespace App\Form;

use App\Entity\Fabricant;
use App\Form\FormFactory\FormListenerFactory;
use Doctrine\DBAL\Types\Type;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
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

    private $paddingAttr = [
        'class' => 'mx-5'
    ];

    public function __construct(
        private FormListenerFactory $formListenerFactory
    ){}

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la marque',
            ])
            ->add('thumbnailFile', FileType::class, [
                'label' => 'Banière',
            ])
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\BrandCategory',
                'choice_label' => 'name',
                'label' => 'Catégorie',
            ])
            ->add('sousTitre', TextType::class, [
                'required' => false,
            ])
            ->add('description', TextareaType::class, [
                'required' => false,
            ])
            ->add('lien', CollectionType::class, [
                'entry_type' => LinkType::class,
                'entry_options' => [
                    'label' => false,
                ],
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'label' => 'Liens',
                'attr' => [
                    'data-controller' => 'form_collection',
                ]
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Enregistrer',
            ])
            // ->addEventListener(FormEvents::PRE_SUBMIT, $this->formListenerFactory->AutoSlug('name'))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Fabricant::class,
        ]);
    }
}
