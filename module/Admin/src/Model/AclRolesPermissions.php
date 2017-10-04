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

class AclRolesPermissions
{
    public $id;
    public $role_id;
    public $permission;
    
    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->role_id = !empty($data['role_id']) ? $data['role_id'] : null;
        $this->permission_id  = !empty($data['permission_id']) ? $data['permission_id'] : null;
    }
    
     public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'role_id' => $this->role_id,
            'permission_id'  => $this->permission_id,
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
            'name' => 'role_id',
            'required' => true,
            'filters' => [             
                ['name' => ToInt::class],
            ],           
        ]);
        
         $inputFilter->add([
            'name' => 'permission_id',
            'required' => true,
            'filters' => [             
                ['name' => ToInt::class],
            ],           
        ]);
//
//        $inputFilter->add([
//            'name' => 'permission',
//            'required' => true,
//            'filters' => [
//                ['name' => StripTags::class],
//                ['name' => StringTrim::class],
//            ],
//            'validators' => [
//                [
//                    'name' => StringLength::class,
//                    'options' => [
//                        'encoding' => 'UTF-8',
//                        'min' => 8,
//                        'max' => 20,
//                        'messages'=> array(
//                                'stringLengthTooShort' => 'Minimalna długość to 4 znaki', 
//                                'stringLengthTooLong' => 'Please enter User Name between 4 to 20 character!' ),
//                    ],
//                ],
//            ],
//        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}