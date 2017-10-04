<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Album\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

class KolorTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
    
    public function  getKolorByAlbum($id)
    {
        //if ($paginated) {
            return $this->fetchPaginatedResults($id);
        //}
        
        
          //return $this->tableGateway->select();
//        $id = (int) $id;
//        $rowset = $this->tableGateway->select(['idAlbum' => $id]);
//        
//        return $rowset;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }  
    
    private function fetchPaginatedResults($id)
    {
        // Create a new Select object for the table:
        $select = new Select($this->tableGateway->getTable());

        // Create a new result set based on the Album entity:
        $resultSetPrototype = new ResultSet();
        $resultSetPrototype->setArrayObjectPrototype(new Kolor());

        // Create a new pagination adapter object:
        $paginatorAdapter = new DbSelect(
            // our configured select object:
            $select->where(['idAlbum' => $id]),
            // the adapter to run it against:
            $this->tableGateway->getAdapter(),
            // the result set to hydrate:
            $resultSetPrototype
        );

        $paginator = new Paginator($paginatorAdapter);
        return $paginator;
    }
    

    public function getKolor($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }

    public function saveKolor(Kolor $kolor)
    {
        $data = [
            'idAlbum' => $kolor->idAlbum,
            'kolor'  => $kolor->kolor,
        ];

        $id = (int) $kolor->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getKolor($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update kolor with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteKolor($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}