<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Application\Form\LoginForm;
use Application\Model\UserTable;
//use Application\Model\User;

//use Application\Auth\Adapter;
//use Zend\Authentication\AuthenticationService;



class IndexController extends AbstractActionController
{

    
        public function __construct()
    {
        
        
       
        //echo "<script type='text/javascript'>alert('".$ss->login."')</script>";
        //echo "<script type='text/javascript'>alert('".$auth->authenticate()."')</script>";
        
    }
    
    
    public function indexAction()
    {            
        return new ViewModel();
    }
    
//      public function waslmethodAction()
//      {
//         // echo "ala ma kota";
//          
//          
//           //echo $this->params()->fromRoute('login', 0);
//          $login= $this->params()->fromQuery('login', 1);
//            $pswd= $this->params()->fromQuery('password', 1);
//          
//           $auth = new WaslAdapter($login,$pswd, $this->usertable);
//        
//         $test="cos";
//         $loginResult = $auth->authenticate();
//           
//           $tmpview =  new ViewModel(array('nazwa'=>$test, 'users'=>$loginResult));
//           //$tmpview->setTemplate('/layout/layout');
//           $layout = $this->layout();
//           $layout->setTemplate('/layout/layoutnobreadcrumbs');
//        //echo "<script type='text/javascript'>alert('".WaslAdapter::getlogresult()->getCode()."')</script>";
//           
////            $config = [
////                        'server1' => [
////                            'host'                   => 'LDAP://10.121.69.40',
////                            //'accountDomainName'      => 'mf.gov.pl',
////                            'accountDomainNameShort' => 'mf\\',
////                            'accountCanonicalForm'   => 3,
////                            //'username'               => 'CN=user1,DC=foo,DC=net',
////                            //'password'               => 'pass1',
////                            'baseDn'                 => 'OU=UKS-Olsztyn,OU=RESORT,DC=mf,DC=gov,DC=pl',
////                            'bindRequiresDn'         => true,
////                        ],                        
////                    ];
////        $auth = new AuthenticationService();
////        $adapter= new LdapAdapter($config, 'cfyl','');
////        $result = $auth->authenticate($adapter);
//        
////        foreach ($result->getMessages() as $i => $message) {
////            if ($i < 2) {
////                continue;
////            }
////echo "<script type='text/javascript'>alert('".$message."')</script>";
//            // Potentially log the $message
////        }
//
//           
//          //$tmpview->setTerminal(true);
//          //return $test;
//          return $tmpview;
//      }
//      
//      public function loginAction()
//      {
//            $layout = $this->layout();
//            $layout->setTemplate('/layout/layoutnobreadcrumbs');
//          
//            $form = new LoginForm();
//            $form->get('submit')->setValue('Zaloguj');
//          
//            $request = $this->getRequest();
//
//            if (! $request->isPost()) {
//                return ['form' => $form];
//            }
//          
//            
//        
//            if ($request->isPost()) {
//               $cancel = $request->getPost('submit', 'cancel');
//               if($cancel=='cancel')
//               { 
//                   return $this->redirect()->toRoute('home');
//               }
//            }
//            
//            $form->setData($request->getPost());
//           
//            if (! $form->isValid()) {
//            return ['form' => $form];
//            }
//            
//            
//            
//            
//            
//           //echo "<script type='text/javascript'>alert(".$form->getData()->login.")</script>";
//            
//           return $this->redirect()->toRoute('application', ['action' => 'waslmethod'], ['query' => ['login' =>$request->getPost()->user, 'password' =>$request->getPost()->password]]);
//
//      }
//      
//      public function logoutAction()
//      {
//          WaslAdapter::logout();
//          return $this->redirect()->toRoute('application');
//      }
}
