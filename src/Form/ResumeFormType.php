<?php

declare(strict_types=1);

namespace App\Form;

use App\DTO\ResumeDTO;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Dropzone\Form\DropzoneType;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;
use Symfonycasts\DynamicForms\DynamicFormBuilder;

class ResumeFormType extends BaseForm
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder = new DynamicFormBuilder($builder);

        $builder
            ->add('name', TextType::class,
                [
                    'label' => 'NAMEN',
                    'label_attr' => [
                        'class' => '',
                    ],
                    'row_attr' => [
                        "class" => "form-group",
                    ],
                    'attr' => [
                        'placeholder' => 'Namen',
                    ],
                    'required' => false,
                ])
            ->add('birthdate', DateType::class, [
                'label' => 'GEBRUTSDATUM',
                'widget' => 'single_text',
                'row_attr' => [
                    "class" => "form-group",
                ],
                'attr' => [
                    'placeholder' => 'Geburtsdatum',
                ],
                'required' => false,

            ])
            ->add('schoolGraduation', ChoiceType::class, [
                'choices' => [
                    'Auswählen' => '',
                    'Hauptschule' => 'Hauptschule',
                    'Realschule' => 'Realschule',
                    'Gymnasium' => 'Gymnasium',
                    'Fachhochschulreife' => 'Fachhochschulreife',
                    'Abitur' => 'Abitur',
                    'Bachelor' => 'Bachelor',
                    'Master' => 'Master',
                ],
                'label' => 'SCHULABSCHLUSS',
                'row_attr' => [
                    "class" => "form-group",
                ],
                'required' => false,

            ])
            ->add('trainingGraduation', ChoiceType::class, [
                'choices' => [
                    'Auswählen' => '',
                    'Fachinformatiker Anwendungsentwickler' => 'Fachinformatiker Anwendungsentwickler',
                    'Fachinformatiker Systemintegration' => 'Fachinformatiker Systemintegration',
                    'Fachinformatiker Daten- und Prozessanalyse' => 'Fachinformatiker Daten- und Prozessanalyse',
                    'IT-Systemelektroniker' => 'IT-Systemelektroniker',
                    'IT-Systemkaufmann' => 'IT-Systemkaufmann',
                ],
                'label' => 'AUSBILDUNGSABSCHLUSS',
                'required' => false,
                'row_attr' => [
                    "class" => "form-group",
                ]])
            ->add('positions', ChoiceType::class, [
                    'choices' => [
                        'Auswählen' => '',
                        'Lead-Entwickler' => 'Lead-Entwickler',
                        'Teamleiter' => 'Teamleiter',
                        'Frontend-Entwickler' => 'Frontend-Entwickler',
                        'Senior Frontend-Entwickler' => 'Senior Frontend-Entwickler',
                        'Backend-Entwickler' => 'Backend-Entwickler',
                        'Senior Backend-Entwickler' => 'Senior Backend-Entwickler',
                        'Fullstack-Entwickler' => 'Fullstack-Entwickler',
                        'DevOps-Ingenieur' => 'DevOps-Ingenieur',
                        'Software-Architekt' => 'Software-Architekt',
                        'Scrum Master' => 'Scrum Master',
                        'Product Owner' => 'Product Owner',
                        'UI/UX-Designer' => 'UI/UX Designer',
                        'Datenbank-Administrator' => 'Datenbank Administrator',
                        'QA-Tester' => 'QA Tester'
                    ], 'multiple' => true, 'autocomplete' => true,
                    'choice_attr' => function ($choice) {
                        return null === $choice ? ['disabled' => true] : [];
                    },
                    'label' => 'POSITIONEN',
                    'required' => false,
                    'row_attr' => [
                        "class" => "form-group",
                    ],]
            )
            ->add('languages', LiveCollectionType::class, [
                'entry_type' => LanguageFormType::class,
                'label' => 'SPRACHEN',
                'row_attr' => [
                    "class" => "form-collections",
                ],
                'attr' => [
                    'class' => 'form-collection form-collection--language',
                ],
                'entry_options' => [
                    'attr' => ['class' => 'form-collection-entry form-collection-entry--language'],
                    'label_attr' => ['hidden' => true],
                ],
                'button_delete_options' => [
                    'label' => 'X',
                    'attr' => [
                        'class' => 'form-button--delete-collection',
                    ],
                ],
                'button_add_options' => [
                    'label' => '+ Hinzufügen',
                    'attr' => [
                        'class' => 'form-button--add-collection',
                    ],
                ]
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
                    'choice_attr' => function ($choice) {
                        return null === $choice ? ['disabled' => true] : [];
                    },
                    'autocomplete' => true,
                    'label' => 'PROGRAMMIERSPRACHEN',
                    'required' => false,
                    'row_attr' => [
                        "class" => "form-group",
                    ]
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
                    'choice_attr' => function ($choice) {
                        return null === $choice ? ['disabled' => true] : [];
                    },
                    'autocomplete' => true,
                    'label' => 'HANDWERKZEUGE',
                    'required' => false,
                    'row_attr' => [
                        "class" => "form-group",
                    ]
                ]
            )
            ->add('projects', LiveCollectionType::class, [
                'entry_type' => ProjectFormType::class,
                'label' => 'PROJEKTE',
                'entry_options' => [
                    'attr' => ['class' => 'form-collection-entry'],
                    'label_attr' => ['hidden' => true],
                ],
                'row_attr' => [
                    "class" => "form-group",
                ],
                'attr' => [
                    'class' => 'form-collection',
                ],
                'button_delete_options' => [
                    'label' => 'X',
                    'attr' => [
                        'class' => 'form-button--delete-collection',
                    ],
                ],
                'button_add_options' => [
                    'label' => '+ Hinzufügen',
                    'attr' => [
                        'class' => 'form-button--add-collection',
                    ],
                ]
            ])
            ->add('photo', DropzoneType::class, [
                'label' => 'FOTO (jpg, png, gif)',
                'mapped' => false,
                'required' => false,
                'attr' => ['accept' => '.jpg, .jpeg, .png, .gif',
                    'placeholder' => 'Ziehen und Ablegen ein Photo oder klicken Sie hier',
                    'data-controller' => 'photoDropzone'],
                'row_attr' => [
                    "class" => "form-group",
                ]
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
