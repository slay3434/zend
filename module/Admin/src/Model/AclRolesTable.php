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
use Zend\Db\Sql\Sql;

use Zend\Db\Adapter\AdapterInterface;
//use Zend\Paginator\Adapter\DbSelect;
//use Zend\Paginator\Paginator;

class AclRolesTable
{
    private $tableGateway;
        private $db;

    public function __construct(TableGatewayInterface $tableGateway, AdapterInterface $db)
    {
        $this->db = $db;
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {            
        return $this->tableGateway->select();
    }
    
     public function getParentRoles()
    {

        return $this->tableGateway->select(['parent_role' => null]);
        
    }
    
    public function getUserRoles($id)
    {              
        $sql = new Sql($this->db);
        $select = $sql->select();      
        $select->from(array('r'=>'aclroles'));
        $select->columns(array('id','role','parent_role'));
        //$select::JOIN_LEFT;
        $select->join(array('ur'=>'acluserroles'), 'r.id = ur.role_id');
        $select->where(array('ur.user_id' => $id));
        $statement = $sql->prepareStatementForSqlObject($select);
        $results = $statement->execute();
        return $results;   
              
    }
    
    
    public function getAclRoles($id)
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

    public function saveAclRoles(Aclroles $aclrole)
    {
        $data = [
            'role' => $aclrole->role,
            'parent_role'  => $aclrole->parent_role,
        ];

        $id = (int) $aclrole->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getAclRoles($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteAclRoles($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}