<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;

class BaseForm extends AbstractType
{
    protected array $collectionButtonClassnames = [
        'button_delete_options' => [
            'label' => 'X',
            'attr' => [
                'class' => 'form__button--remove-collection',
            ],
        ],
        'button_add_options' => [
            'label' => '+ Hinzufügen',
            'attr' => [
                'class' => 'form__button--add-collection',
            ],
        ]
    ];
}