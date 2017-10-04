<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGatewayInterface;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;
use Zend\Paginator\Paginator;

use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Sql;

class AclPermissionsTable
{
    private $tableGateway;
    private $db;

    public function __construct(TableGatewayInterface $tableGateway, AdapterInterface $db)
    {
        $this->tableGateway = $tableGateway;
        $this->db = $db;
    }

    public function fetchAll()
    {
        return $this->tableGateway->select();
    }
    
      public function getRolesPermissions($roleid)
    {              
         
          
        $sql = new Sql($this->db);
        $select = $sql->select();      
        $select->from(array('p'=>'aclpermissions'));
        $select->columns(array('id','permission','module'));
        //$select::JOIN_LEFT;
        $select->join(array('rp'=>'aclrolespermissions'), 'p.id = rp.permission_id');
        $select->where(array('rp.role_id' => $roleid));
        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        return $results;   
              
    }


    
    
    
    public function getPermissions($id)
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

    public function savePermissions(AclPermissions $permission)
    {
        $data = [
            'permission' =>  $permission->permission, 
            'module'=> $permission->module,
        ];

        $id = (int) $permission->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getPermissions($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deletePermission($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}