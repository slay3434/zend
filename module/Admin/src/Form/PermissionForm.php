<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Form;

use Zend\Form\Form;

class PermissionForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('user');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
        $this->add([
            'name' => 'permission',
            'type' => 'text',
            'options' => [
                'label' => 'Uprawnienie',
            ],
        ]);
        $this->add([
            'name' => 'module',
            'type' => 'text',
            'options' => [
                'label' => 'Moduł',
            ],
        ]);
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Go',
                'id'    => 'submitbutton',
            ],
        ]);
        $this->add([
            'name' => 'cancel',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Cancel',
                'id'    => 'cancebutton',
            ],
        ]);
        
        
        
       
       
    }
}