<?php

namespace App\Form;

use App\Entity\Adress;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\FormEvents;
use App\Factory\FormEventFactory;

class AdressType extends AbstractType
{
    private array $countries;

    public function __construct(
        private FormEventFactory $formEventFactory
    )
    {
        $file = new Filesystem();
        $data = json_decode($file->readFile(__DIR__ . '/Data/contry.json'), true);

        // Assuming the JSON structure is an array of country names
        $this->countries = $data;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('street')
            ->add('city')
            ->add('postalCode', TextType::class, [
                'label' => 'Postal code',
            ])
            ->add('country', ChoiceType::class, [
                'label' => 'Pays',
                'placeholder' => 'Choisissez un pays',
                'required' => true,
                'choices' => array_combine($this->countries, $this->countries),
            ])
            ->addEventListener(FormEvents::POST_SUBMIT, $this->formEventFactory->dateTimeUpdate())
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Adress::class,
        ]);
    }
}
