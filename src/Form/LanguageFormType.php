<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\LanguageDTO;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Intl\Languages;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class LanguageFormType extends BaseForm
{
    protected array $languages;

    public function __construct()
    {
        $this->languages = Languages::getNames();
        $default = ['Auswählen' => null];
        $germanName = $this->languages['de'];
        $englishName = $this->languages['en'];
        unset($this->languages['de'], $this->languages['en']);
        $this->languages = array_combine($this->languages, $this->languages);
        $german = [$germanName => $germanName];
        $english = [$englishName => $englishName];
        $this->languages = $default + $german + $english + $this->languages;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('title', ChoiceType::class,
                [
                    'choices' => $this->languages,
                    'label_attr' => ['hidden' => true],
                    'row_attr' => ['class' => 'form-group'],
                ])
            ->add('level', RangeType::class,
                [
                    'label' => 'Level',
                    'row_attr' => ['class' => 'form-group'],
                    'attr' => [
                        'min' => 0,
                        'max' => 10,
                        'step' => 1,
                    ],
                ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LanguageDTO::class,
            'custom_option' => null,
        ]);
        $resolver->setRequired('custom_option');
    }
}
