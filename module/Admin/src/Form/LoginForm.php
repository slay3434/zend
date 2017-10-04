<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Form;

use Zend\Form\Form;

class LoginForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('user');

        $this->add([
            'name' => 'password',
            'type' => 'password',
            'options' => [
                'label' => 'Hasło',
            ],
        ]);
       
        $this->add([
            'name' => 'user',
            'type' => 'text',
            'options' => [
                'label' => 'Login',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Zaloguj',
                'id'    => 'submitbutton',
            ],
        ]);
        $this->add([
            'name' => 'cancel',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Anuluj',
                'id'    => 'cancebutton',
            ],
        ]);
        

         
       
        
       
       
    }
}