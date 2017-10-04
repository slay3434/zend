<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class AclPermissions
{
    public $id;
    public $permission;
    public $module;
    
    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->permission = !empty($data['permission']) ? $data['permission'] : null;
        $this->module = !empty($data['module']) ? $data['module'] : null;
   
    }
    
     public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'permission' => $this->permission,
            'module'=> $this->module,

        ];
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }

    public function getInputFilter()
    {
        if ($this->inputFilter) {
            return $this->inputFilter;
        }

        $inputFilter = new InputFilter();

        $inputFilter->add([
            'name' => 'id',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'permission',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 4,
                        'max' => 50,
                        'messages'=> array(
                                'stringLengthTooShort' => 'Minimalna długość to 4 znaki', 
                                'stringLengthTooLong' => 'Maksymalna długość to 50 znaków' ),
                    ],                   
                ],
            ],
        ]);
        
        
         $inputFilter->add([
            'name' => 'module',
            'required' => true,
            'filters' => [
                ['name' => StripTags::class],
                ['name' => StringTrim::class],
            ],
            'validators' => [
                [
                    'name' => StringLength::class,
                    'options' => [
                        'encoding' => 'UTF-8',
                        'min' => 2,
                        'max' => 50,
                        'messages'=> array(
                                'stringLengthTooShort' => 'Minimalna długość to 2 znaki', 
                                'stringLengthTooLong' => 'Maksymalna długość to 50 znaków' ),
                    ],                   
                ],
            ],
        ]);

       

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}