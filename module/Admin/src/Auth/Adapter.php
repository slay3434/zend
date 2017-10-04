<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Auth;

use Zend\Authentication\Adapter\AdapterInterface;
//use Zend\Authentication\Adapter\Ldap as LdapAdapter;
//use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Result;
use Zend\Session\Container; 

class Adapter implements AdapterInterface
{
    private $auth=null;
    
    private $login=null;
    private $password=null;
    
    private $config = null; 
    private $tableadapter = null;
    
  
    
     public function __construct($username=null, $password=null, $usertableadapter=null)
    {
         /*ldap config
//        $this->auth = new AuthenticationService();
//        $this->login = $username;
//        $this->password = $password;
//        
//        
//        $config = [
//                        'server1' => [
//                            'host'                   => '10.121.69.40',
//                            'accountDomainName'      => 'mf.gov.pl',
//                            'accountDomainNameShort' => 'mf',
//                            'accountCanonicalForm'   => 3,
//                            //'username'               => 'CN=user1,DC=foo,DC=net',
//                            //'password'               => 'pass1',
//                            //'baseDn'                 => 'OU=Sales,DC=foo,DC=net',
//                            //'bindRequiresDn'         => true,
//                        ],                        
//                    ];
//        
//        return new LdapAdapter($config, $username, $password);
          * 
          * 
          */
         
       
         
         $this->login = $username;
         $this->password = $password;
         $this->tableadapter = $usertableadapter;
         
         
    }
    
    
    public function authenticate()
    {
        $user  = $this->tableadapter->loginuser($this->login, $this->password, 1);

        //echo "<script type='text/javascript'>alert('ggg".$user."')</script>";


        if($user != null):
           $result = new Result(1, $user->login,array('Prawidłowe logowanie :).') );
        else:
            $result = new Result(0, null, array('Błędny login lub hasło.'));
        endif;

        $sessionObject = new Container('sessionadmin');        
        $sessionObject->logresult = $result;

        return $result;
    }
    
    public static function getlogresult()       
    {
       $sessionObject = new Container('sessionadmin'); 
       
       return  $sessionObject->logresult != null?$sessionObject->logresult: new Result(0, null, array('Błędny login lub hasło.'));
    }
    
    public static function logout(){
        $sessionObject = new Container('sessionadmin'); 
        
        $sessionObject->logresult = null;
    }
    


    
}