<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Album\Form;

use Zend\Form\Form;

class KolorForm extends Form
{
    public function __construct($name = null)
    {
        // We will ignore the name provided to the constructor
        parent::__construct('kolor');

        $this->add([
            'name' => 'id',
            'type' => 'hidden',
        ]);
       
        $this->add([
            'name' => 'kolor',
            'type' => 'text',
            'options' => [
                'label' => 'Kolor',
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
        
         $this->add([
            'name' => 'idAlbum',
            'type' => 'hidden',
        ]);
         
       
        
       
       
    }
}