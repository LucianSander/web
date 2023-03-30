<?php

namespace Pessoa\Form;

use Zend\Form\Form;

class PessoaForm extends Form
{
    public function __construct($name=null)
    {
        parent::__construct('pessoa');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);

        $this->add([
            'name' => 'nome',
            'type' => 'text',
            'options' => [
                'label' => 'Nome',
            ],
        ]);

        $this->add([
            'name' => 'sobrenome',
            'type' => 'text',
            'options' => [
                'label' => 'Sobrenome',
            ],
        ]);
        $this->add([
            'name' => 'email',
            'type' => 'text',
            'options' => [
                'label' => 'Email',
            ],
        ]);
        $this->add([
            'name' => 'situacao',
            'type' => 'text',
            'options' => [
                'label' => 'Situacao',
            ],
        ]);

        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id' => 'submitbutton',
            ],
        ]);
    }
}