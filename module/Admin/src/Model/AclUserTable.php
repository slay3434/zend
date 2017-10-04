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

class AclUserTable
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
    
    public function loginuser($login, $password, $safe = false)                        
    {
        
           //echo "<script type='text/javascript'>alert('ggg".$password."')</script>";
        
        $result = null;
        if($safe == 1):
         $select = $this->tableGateway->select(['login'=>$login, 'password'=>$password]);
     
//        $select = $this->tableGateway->select(function (Select $select) use($login, $password){
//            $select->where(array("login"=>$login, "password"=>$password));
//        });
       
        
        
        $result = $select->current();
          
                 
        endif;
        
        return $result;        
    }
    

    
    
    
    public function getUser($id)
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

    public function saveUser(AclUser $user)
    {
        $data = [
            'login' => $user->login,
            'password'  => $user->password,
        ];

        $id = (int) $user->id;

        if ($id === 0) {
            $this->tableGateway->insert($data);
            return;
        }

        if (! $this->getUser($id)) {
            throw new RuntimeException(sprintf(
                'Cannot update album with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->update($data, ['id' => $id]);
    }

    public function deleteUser($id)
    {
        $this->tableGateway->delete(['id' => (int) $id]);
    }
}