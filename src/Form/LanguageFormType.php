<?php

declare(strict_types=1);

namespace App\Form;

use App\Entity\Language;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class LanguageFormType extends BaseForm
{
    protected array $languages;

    public function __construct()
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('title', ChoiceType::class,
                [
                    'choices' => [
                        'Auswählen' => '',
                        'Arabisch' => 'Arabisch',
                        'Chinesisch' => 'Chinesisch',
                        'Deutsch' => 'Deutsch',
                        'Englisch' => 'Englisch',
                        'Französisch' => 'Französisch',
                        'Italienisch' => 'Italienisch',
                        'Japanisch' => 'Japanisch',
                        'Koreanisch' => 'Koreanisch',
                        'Niederländisch' => 'Niederländisch',
                        'Polnisch' => 'Polnisch',
                        'Portugiesisch' => 'Portugiesisch',
                        'Russisch' => 'Russisch',
                        'Schwedisch' => 'Schwedisch',
                        'Spanisch' => 'Spanisch',
                        'Türkisch' => 'Türkisch',
                        'Vietnamesisch' => 'Vietnamesisch',
                    ],
                    'preferred_choices' => ['Deutsch', 'Englisch'],
                    'label' => 'Sprache',
                    'row_attr' => ['class' => 'form-group form-floating'],
                ])
            ->add('level', ChoiceType::class,
                [
                    'choices' => [
                        '1' => '1',
                        '2' => '2',
                        '3' => '3',
                        '4' => '4',
                        '5' => '5',
                    ],
                    'label' => 'Stufe',
                    'row_attr' => ['class' => 'form-group form-floating'],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Language::class,
            'custom_option' => null,
        ]);
        $resolver->setRequired('custom_option');
    }
}
