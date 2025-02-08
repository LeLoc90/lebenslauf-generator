<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\ResumeDTO;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class ResumeFormType extends BaseForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('introduction', TextareaType::class,
                [
                    'label' => 'Einleitung',
                ])
            ->add('name', TextType::class,
                [
                    'label' => 'Namen',
                ])
            ->add('positions', ChoiceType::class, [
                    'choices' => [
                        'Frontend-Entwickler' => 'Frontend-Entwickler',
                        'Backend-Entwickler' => 'Backend-Entwickler',
                        'Fullstack-Entwickler' => 'Fullstack-Entwickler',
                        'DevOps-Ingenieur' => 'DevOps-Ingenieur',
                        'Software-Architekt' => 'Software-Architekt',
                        'Scrum Master' => 'Scrum Master',
                        'Product Owner' => 'Product Owner',
                        'UI/UX-Designer' => 'UI/UX Designer',
                        'Datenbank-Administrator' => 'Datenbank Administrator',
                        'QA-Tester' => 'QA Tester'
                    ], 'multiple' => true, 'autocomplete' => true,]
            )
            ->add('languages', LiveCollectionType::class, [
                'entry_type' => LanguageFormType::class
            ])
            ->add('programmingLanguages', ChoiceType::class,
                [
                    'choices' => [
                        'Auswählen' => '',
                        'HTML5' => 'HTML',
                        'CSS/SASS/LESS' => 'CSS',
                        'JavaScript' => 'JavaScript',
                        'TypeScript' => 'TypeScript',
                        'PHP' => 'PHP',
                        'Python' => 'Python',
                        'Ruby' => 'Ruby',
                        'Java' => 'Java',
                        'C#' => 'C#',
                        'SQL' => 'SQL',
                        'Go' => 'Go',
                        'Kotlin' => 'Kotlin',
                        'Swift' => 'Swift',
                        'Rust' => 'Rust',
                        'Dart' => 'Dart'
                    ], 'multiple' => true,
                    'autocomplete' => true,
                ]
            )
            ->add('tools', ChoiceType::class,
                [
                    'choices' => [
                        'Auswählen' => '',
                        'Scrum' => 'Scrum',
                        'Kanban' => 'Kanban',
                        'Jira' => 'Jira',
                        'Git' => 'Git',
                        'Docker' => 'Docker',
                        'Atlassian Stack' => 'Atlassian Stack',
                        'PHPStorm' => 'PHPStorm',
                        'IntelliJ IDEA' => 'IntelliJ IDEA',
                        'VS Code' => 'VS Code',
                        'Eclipse' => 'Eclipse',
                        'Ubuntu' => 'Ubuntu',
                        'Fedora' => 'Fedora',
                        'MySQL/MariaDB/PostgreSQL' => 'MySQL/MariaDB/PostgreSQL',
                        'MongoDB' => 'MongoDB',
                        'Redis' => 'Redis',
                        'Laravel' => 'Laravel',
                        'Symfony' => 'Symfony',
                    ], 'multiple' => true,
                    'autocomplete' => true,
                ]
            )
            ->add('projects', LiveCollectionType::class, [
                'entry_type' => ProjectFormType::class
            ])
            ->add('photo', FileType::class, [
                'label' => 'Photo (JPG, PNG, GIF)',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => '.jpg, .jpeg, .png, .gif'],
            ]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ResumeDTO::class,
            'custom_option' => null,
        ]);
        $resolver->setRequired('custom_option');
    }
}
