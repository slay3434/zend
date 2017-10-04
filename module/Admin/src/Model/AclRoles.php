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

class AclRoles
{
    public $id;
    public $role;
    public $parent_role;
    
    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->role = !empty($data['role']) ? $data['role'] : null;
        $this->parent_role  = !empty($data['parent_role']) ? $data['parent_role'] : null;
    }
    
     public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'role' => $this->role,
            'parent_role'  => $this->parent_role,
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
            'name' => 'role',
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
                        'max' => 20,
                        'messages'=> array(
                                'stringLengthTooShort' => 'Minimalna długość to 4 znaki', 
                                'stringLengthTooLong' => 'Please enter User Name between 4 to 20 character!' ),
                    ],                   
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'parent_role',
            'required' => false,
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
                        'max' => 20,
                        'messages'=> array(
                                'stringLengthTooShort' => 'Minimalna długość to 4 znaki', 
                                'stringLengthTooLong' => 'Please enter User Name between 4 to 20 character!' ),
                    ],
                ],
            ],
        ]);

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
}