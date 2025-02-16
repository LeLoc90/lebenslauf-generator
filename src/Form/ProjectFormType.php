<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\ProjectDTO;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class ProjectFormType extends BaseForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('title', TextType::class,
                [
                    'label' => 'Projektname',
                    'row_attr' => ['class' => 'form-group form-floating'],
                ])
            ->add('year', NumberType::class,
                [
                    'label' => 'Jahr',
                    'row_attr' => ['class' => 'form-group form-floating'],
                ])
            ->add('description', TextareaType::class,
                [
                    'label' => 'Beschreibung',
                    'row_attr' => ['class' => 'form-group form-floating'],
                    'attr' => ['rows' => 6],
                ])
            ->add('technologies', ChoiceType::class,
                [
                    'choices' => [
                        'Auswählen' => '',
                        'PHP' => 'PHP',
                        'Symfony' => 'Symfony',
                        'Docker' => 'Docker',
                        'Jira' => 'Jira',
                        'Confluence' => 'Confluence',
                        'Bamboo' => 'Bamboo',
                        'Bitbucket' => 'Bitbucket',
                        'MySQL' => 'MySQL',
                        'PostgreSQL' => 'PostgreSQL',
                        'JavaScript' => 'JavaScript',
                        'TypeScript' => 'TypeScript',
                        'React' => 'React',
                        'Redux' => 'Redux',
                        'Redux-Saga' => 'Redux-Saga',
                        'Material-UI' => 'Material-UI',
                        'HTML5' => 'HTML5',
                        'CSS3' => 'CSS3',
                        'REST API' => 'REST-API',
                        'Node.js' => 'Node-js',
                        'Git' => 'Git'
                    ],
                    'choice_attr' => function ($choice) {
                        return null === $choice ? ['disabled' => true] : [];
                    },
                    'autocomplete' => true,
                    'label' => 'Technologien',
                    'multiple' => true,
                    'row_attr' => ['class' => 'form-group form-floating'],
                ])
            ->add('task', TextareaType::class,
                [
                    'label' => 'Aufgabenbereich',
                    'row_attr' => ['class' => 'form-group form-floating'],
                    'attr' => ['rows' => 6],
                ])
            ->add('workflow', TextareaType::class,
                [
                    'label' => 'Workflow',
                    'row_attr' => ['class' => 'form-group form-floating'],
                    'attr' => ['rows' => 6],
                ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ProjectDTO::class,
            'custom_option' => null,
        ]);
        $resolver->setRequired('custom_option');
    }
}
