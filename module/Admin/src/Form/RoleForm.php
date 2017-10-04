<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Form;

use Zend\Form\Form;

class RoleForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('role');
        
         $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
       
        $this->add([
            'name' => 'role',
            'type' => 'text',
            'options' => [
                'label' => 'Rola',
            ],
        ]);
        
         $this->add([
            'name' => 'parent_role',
            'type' => 'text',
            'options' => [
                'label' => 'Rola nadrzędna',
            ],
        ]);
        
        $this->add([
            'name' => 'submit',
            'type' => 'submit',
            'attributes' => [
                'value' => 'Zapisz',
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