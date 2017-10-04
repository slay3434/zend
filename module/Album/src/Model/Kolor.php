<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Album\Model;

use DomainException;
use Zend\Filter\StringTrim;
use Zend\Filter\StripTags;
use Zend\Filter\ToInt;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;

class Kolor
{
    public $id;
    public $idAlbum;
    public $kolor;
    
    private $inputFilter;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->idAlbum = !empty($data['idAlbum']) ? $data['idAlbum'] : null;
        $this->kolor  = !empty($data['kolor']) ? $data['kolor'] : null;
    }
    
     public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'idAlbum' => $this->idAlbum,
            'kolor'  => $this->kolor,
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
            'name' => 'idAlbum',
            'required' => true,
            'filters' => [
                ['name' => ToInt::class],
            ],
        ]);

        $inputFilter->add([
            'name' => 'kolor',
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
                        'min' => 1,
                        'max' => 100,
                        'messages'=> array(
                                'stringLengthTooShort' => 'CHWDP', 
                                'stringLengthTooLong' => 'Please enter User Name between 4 to 20 character!' ),
                    ],                   
                ],
            ],
        ]);

        

        $this->inputFilter = $inputFilter;
        return $this->inputFilter;
    }
    
    
//<editor-fold defaultstate="collapsed" desc="My Fold">
//    public function getInputFilter()
//    {
//        if ($this->inputFilter) {
//            return $this->inputFilter;
//        }
//
//        $inputFilter = new InputFilter();
//
//        $inputFilter->add([
//            'name' => 'id',
//            'required' => true,
//            'filters' => [
//                ['name' => ToInt::class],
//            ],
//        ]);
//
//        $inputFilter->add([
//            'name' => 'artist',
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
//                        'min' => 10,
//                        'max' => 100,
//                        'messages'=> array(
//                                'stringLengthTooShort' => 'CHWDP', 
//                                'stringLengthTooLong' => 'Please enter User Name between 4 to 20 character!' ),
//                    ],                   
//                ],
//            ],
//        ]);
//
//        $inputFilter->add([
//            'name' => 'title',
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
//                        'min' => 1,
//                        'max' => 100,
//                    ],
//                ],
//            ],
//        ]);
//
//        $this->inputFilter = $inputFilter;
//        return $this->inputFilter;
//    }
    //</editor-fold>
}