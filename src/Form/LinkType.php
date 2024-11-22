<?php

namespace App\Form;

use App\Entity\Link;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Url;

class LinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Site web' => 'site',
                    'Linkedin' => 'social',
                    'Facebook' => 'facebook',
                    'Instagram' => 'instagram',
                    'Twitter' => 'twitter',
                    'Youtube' => 'youtube',
                    'Autre' => 'other',
                ],
                'label' => 'Type de lien',
                'attr' => [
                    'class' => 'flex-auto w-32'
                ],
            ])
            ->add('Link', TextType::class, [
                'label' => 'Lien',
                'constraints' => [
                    new Url(),
                ],
                'attr' => [
                    'class' => 'flex-auto w-32'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Link::class,
        ]);
    }
}
