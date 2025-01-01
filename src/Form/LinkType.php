<?php

namespace App\Form;

use App\Entity\Brands;
use App\Entity\Link;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LinkType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Site web' => 'site',
                    'Facebook' => 'facebook',
                    'Instagram' => 'instagram',
                    'Twitter' => 'twitter',
                    'LinkedIn' => 'linkedin',
                    'Pinterest' => 'pinterest',
                    'YouTube' => 'youtube',
                    'TikTok' => 'tiktok',
                    'Catalogue' => 'catalog',
                    'Autre' => 'other',
                ],
            ])
            ->add('URL')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Link::class,
        ]);
    }
}
