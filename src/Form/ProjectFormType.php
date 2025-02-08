<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\ProjectDTO;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
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
            ->add('Title', TextType::class,
                [
                    'label' => 'Projektname',
                ])
            ->add('description', TextareaType::class,
                [
                    'label' => 'Beschreibung',
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
                    'autocomplete' => true,
                ])
            ->add('tasks', TextareaType::class,
                [
                    'label' => 'Aufgabenbereich',
                ])
            ->add('workflow', TextareaType::class,
                [
                    'label' => 'Workflow',
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
