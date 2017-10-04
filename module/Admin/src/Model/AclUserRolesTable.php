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

class AclUserRolesTable
{
    private $tableGateway;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {
     
        
        return $this->tableGateway->select();
    }
    
 

    
    
    
    public function getUserRoles($id)
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

    public function saveUserRoles(AclUserRoles $userroles)
    {
        $data = [
            'user_id' => $userroles->user_id,
            'role_id'  => $userroles->role_id,
        ];

        $id = (int) $userroles->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getUserRoles($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update user roles with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

     public function deleteUserRoles($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
    public function deleteUserRolesByRole($id)
    {
        $this->tableGateway->delete(['role_id' => (int) $id]);
    }
}