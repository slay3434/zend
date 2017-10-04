<?php

/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Form\Element;
use Zend\Form\Form;
use Zend\View\Model\JsonModel;
//use Zend\Db\Adapter\AdapterInterface;
use Zend\Session\Container;
use Admin\Form\LoginForm;
use Admin\Form\UserForm;
use Admin\Form\RoleForm;
use Admin\Form\PermissionForm;
//use Application\Model\User;
//use Application\Auth\Adapter;
//use Zend\Authentication\AuthenticationService;
use Admin\Model\AclRolesTable;
use Admin\Model\AclRoles;
use Admin\Model\AclRolesPermissionsTable;
use Admin\Model\AclRolesPermissions;
use Admin\Model\AclUserRolesTable;
use Admin\Model\AclUserRoles;
use Admin\Model\AclUserTable;
use Admin\Model\AclUser;
use Admin\Model\AclPermissionsTable;
use Admin\Model\AclPermissions;
use Zend\Authentication\AuthenticationService;
use Zend\Authentication\Adapter\Ldap as LdapAdapter;
use Admin\Auth\Adapter as WaslAdapter;

class AdminController extends AbstractActionController {

    private $usertable;
    private $rolestable;
    private $rolespermissionstable;
    private $userrolestable;
    private $permissionstable;

    public function __construct(AclRolesTable $rolestable, 
            AclRolesPermissionsTable $rolespermissionstable, 
            AclUserTable $usertable, 
            AclUserRolesTable $userrolestable, 
            AclPermissionsTable $permissions
    ) {

        $this->rolestable = $rolestable;
        $this->usertable = $usertable;
        $this->rolespermissionstable = $rolespermissionstable;
        $this->userrolestable = $userrolestable;
        $this->permissionstable = $permissions;

        //echo "<script type='text/javascript'>alert('".$ss->login."')</script>";
        //echo "<script type='text/javascript'>alert('".$auth->authenticate()."')</script>";
         //     echo "<script type='text/javascript'>alert('".$this->permissionstable->getRolesPermissions(2)[0]['id']."')</script>";
    }

    public function indexAction() {
   
        
        $users = $this->usertable->fetchAll();
        $role = $this->rolestable->fetchAll();
        //$rolespermission = $this->rolespermissionstable->fetchAll();
        $permissions = $this->permissionstable->fetchAll();

        $sessionobject = new Container('sessionadmin');
        if (is_null($sessionobject->selectedmenu)) {
            $sessionobject->selectedmenu = 'user';
        }


        $view = new ViewModel(['users' => $users,
            'roles' => $role,
            'permissions' => $permissions,
            'selectedmenu' => $sessionobject->selectedmenu,
                //'userroles'=>$this->rolestable->getUserRoles(1)
        ]);
        $this->layout('/layout/layoutnobreadcrumbs');
        return $view;
    }

    public function selectAdminMenuAction() {

        $menu = $this->params()->fromRoute('id');

        $sessionobject = new Container('sessionadmin');
        $sessionobject->selectedmenu = $menu;
        unset($sessionobject->selectedrow);


        //$viewmodel = new ViewModel(['dd'=>$menu)

        return "";
        //    echo "<script type='text/javascript'>alert('".$menu."')</script>";
    }

    public function getselectedmenuAction() {
        $sessionobject = new Container('sessionadmin');
        //$view = new ViewModel(['selectedmenu'=>$sessionobject->selectedmenu]);
        //$view->setTerminal(true);
        //return $view;
        $data = ['menu' => $sessionobject->selectedmenu];
        return new JsonModel($data);
    }

    public function selectRowAction() {
        $data = $this->params()->fromRoute('id', 0);
        $id = explode("_", $data)[1];
        $sessionobject = new Container('sessionadmin');

        switch (explode("_", $data)[0]) {
            case 'user':
                $sessionobject->userrow = $id;
                unset($sessionobject->userrolerow);
                break;
            case 'role':
                $sessionobject->rolerow = $id;
                break;
            case 'userrole':
                $sessionobject->userrolerow = $id;
                break;
            case 'permission':
                $sessionobject->permissionrow = $id;
                break;
            case 'rolepermission':
                $sessionobject->rolepermissionrow = $id;
        }



        return "";
    }

    private function getRowId($objectname) {
        $sessionobject = new Container('sessionadmin');
        if ($sessionobject->offsetExists($objectname)) {
            return $sessionobject->offsetGet($objectname);
        }
        return 0;
    }

    public function waslmethodAction() {
        // echo "ala ma kota";
        //echo $this->params()->fromRoute('login', 0);
        $login = $this->params()->fromQuery('login', 1);
        $pswd = $this->params()->fromQuery('password', 1);

        $auth = new WaslAdapter($login, $pswd, $this->usertable);

        $test = "cos";
        $loginResult = $auth->authenticate();

        $tmpview = new ViewModel(array('nazwa' => $test, 'users' => $loginResult));
        //$tmpview->setTemplate('/layout/layout');
        $layout = $this->layout();
        $layout->setTemplate('/layout/layoutnobreadcrumbs');
        //echo "<script type='text/javascript'>alert('".WaslAdapter::getlogresult()->getCode()."')</script>";
        //            $config = [
        //                        'server1' => [
        //                            'host'                   => 'LDAP://10.121.69.40',
        //                            //'accountDomainName'      => 'mf.gov.pl',
        //                            'accountDomainNameShort' => 'mf\\',
        //                            'accountCanonicalForm'   => 3,
        //                            //'username'               => 'CN=user1,DC=foo,DC=net',
        //                            //'password'               => 'pass1',
        //                            'baseDn'                 => 'OU=UKS-Olsztyn,OU=RESORT,DC=mf,DC=gov,DC=pl',
        //                            'bindRequiresDn'         => true,
        //                        ],                        
        //                    ];
        //        $auth = new AuthenticationService();
        //        $adapter= new LdapAdapter($config, 'cfyl','');
        //        $result = $auth->authenticate($adapter);
        //        foreach ($result->getMessages() as $i => $message) {
        //            if ($i < 2) {
        //                continue;
        //            }
        //echo "<script type='text/javascript'>alert('".$message."')</script>";
        // Potentially log the $message
        //        }
        //$tmpview->setTerminal(true);
        //return $test;
        return $tmpview;
    }

    public function loginAction() {
        $layout = $this->layout();
        $layout->setTemplate('/layout/layoutnobreadcrumbs');

        $form = new LoginForm();
        $form->get('submit')->setValue('Zaloguj');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }



        if ($request->isPost()) {
            $cancel = $request->getPost('submit', 'cancel');
            if ($cancel == 'cancel') {
                return $this->redirect()->toRoute('home');
            }
        }

        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }





        //echo "<script type='text/javascript'>alert(".$form->getData()->login.")</script>";

        return $this->redirect()->toRoute('admin', ['action' => 'waslmethod'], ['query' => ['login' => $request->getPost()->user, 'password' => $request->getPost()->password]]);
    }

    public function logoutAction() {
        WaslAdapter::logout();
        return $this->redirect()->toRoute('application');
    }

//****************************************************************************      USER
    public function adduserAction() {
        $form = new UserForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        if ($request->isPost()) {
            $cancel = $request->getPost('submit', 'cancel');
            if ($cancel == 'cancel') {
                return $this->redirect()->toRoute('admin', ['action' => 'index']);
            }
        }

        $user = new AclUser();
        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $user->exchangeArray($form->getData());
        $this->usertable->saveUser($user);
        return $this->redirect()->toRoute('admin');
    }

    public function deleteuserAction() {
        //$id = (int) $this->params()->fromRoute('id', 0);
        //$sessionobject = new Container('sessionadmin');
        //$id =(int) $sessionobject->selectedrow;  
        $id = (int) $this->getRowId('userrow');

        if (!$id) {
            return $this->redirect()->toRoute('admin');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->usertable->deleteUser($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('admin');
        }

        return [
            'id' => $id,
            'user' => $this->usertable->getUser($id),
        ];
    }

    public function edituserAction() {
        //$id = (int) $this->params()->fromRoute('id', 0);
//        $sessionobject = new Container('sessionadmin');
//        $id = $sessionobject->selectedrow;  
        $id = (int) $this->getRowId('userrow');

        if (0 === $id) {
            return $this->redirect()->toRoute('admin', ['action' => 'adduser']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $user = $this->usertable->getUser($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('admin', ['action' => 'index']);
        }

        $form = new UserForm();
        $form->bind($user);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $cancel = $request->getPost('submit', 'cancel');
            if ($cancel == 'cancel') {
                return $this->redirect()->toRoute('admin', ['action' => 'index']);
            }
        }

        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($user->getInputFilter());
        $form->setData($request->getPost());


        if (!$form->isValid()) {
            return $viewData;
        }

        $this->usertable->saveUser($user);

        // Redirect to album list
        return $this->redirect()->toRoute('admin', ['action' => 'index']);
    }

    public function getuserrolesAction() {
        $role = $this->rolestable->fetchAll();
        $id = (int) $this->params()->fromRoute('id', 0);
        //$this->rolestable->getUserRoles($id)
        $view = new ViewModel(array('userroles' => $this->rolestable->getUserRoles($id), 'role' => $role));
        $view->setTerminal(true);
        return $view;
    }

    public function adduserroleAction() {
        $roles = $this->params()->fromRoute('id', 0);

//            $sessionobject = new Container('sessionadmin');
//            $userid = $sessionobject->selectedrow;
        $userid = (int) $this->getRowId('userrow');

        $role = explode(",", $roles);
        foreach ($role as $rola) {
            $userrole = new AclUserRoles();
            $userrole->user_id = $userid;
            $userrole->role_id = $rola;
            $this->userrolestable->saveUserRoles($userrole);
        }

        $data = ['response' => $userid];
        return new JsonModel($data);
    }

    public function deleteuserroleAction() {

        $id = (int) $this->getRowId('userrolerow');

        $this->userrolestable->deleteUserRoles($id);

        $data = ['response' => (int) $this->getRowId('userrow')];

        return new JsonModel($data);
    }

    //***************************************************************************** ROLE 

    public function addroleAction() {
        $allroles = $this->rolestable->getParentRoles();

        $select = new Element\Select('parent_role');
        $select->setLabel('Rola nadrzędna');
        $parents = array();
        $parents[''] = "";
        foreach ($allroles as $parent) {
            //array_push($parents, $parent->role);
            $parents[$parent->role] = $parent->role;
        }
        $select->setValueOptions($parents);
        //            $select->setValueOptions(array(
        //                    '0' => 'French',
        //                    '1' => 'English',
        //                    '2' => 'Japanese',
        //                    '3' => 'Chinese',
        //            ));
        //$form = new Form('language');




        $form = new RoleForm();
        $form->get('submit')->setValue('Add');
        $form->add($select);
        $request = $this->getRequest();

        if (!$request->isPost()) {


            return ['form' => $form];
        }

        if ($request->isPost()) {
            $cancel = $request->getPost('submit', 'cancel');
            if ($cancel == 'cancel') {
                return $this->redirect()->toRoute('admin', ['action' => 'index']);
            }
        }

        $role = new AclRoles();
        $form->setInputFilter($role->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $role->exchangeArray($form->getData());
        $this->rolestable->saveAclRoles($role);
        return $this->redirect()->toRoute('admin');
    }

    public function deleteroleAction() {
        //$id = (int) $this->params()->fromRoute('id', 0);
//        $sessionobject = new Container('sessionadmin');
//        $id =(int) $sessionobject->selectedrow;  
        $id = (int) $this->getRowId('rolerow');

        if (!$id) {
            return $this->redirect()->toRoute('admin');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->rolestable->deleteAclRoles($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('admin');
        }

        return [
            'id' => $id,
            'value' => $this->rolestable->getAclRoles($id)->role,
        ];
    }

    public function editroleAction() {
        //$id = (int) $this->params()->fromRoute('id', 0);
//        $sessionobject = new Container('sessionadmin');
//        $id = $sessionobject->selectedrow;  

        $id = (int) $this->getRowId('rolerow');

        if (0 === $id) {
            return $this->redirect()->toRoute('admin', ['action' => 'addrole']);
        }

        //$role = null;
        try {
            $role = $this->rolestable->getAclRoles($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('admin', ['action' => 'index']);
        }


        $allroles = $this->rolestable->getParentRoles();

        $select = new Element\Select('parent_role');
        $select->setLabel('Rola nadrzędna');
        $parents = array();
        $parents[''] = "";
        foreach ($allroles as $parent) {
            if ($role->role != $parent->role)
            {$parents[$parent->role] = $parent->role;       }
      
        }
        $select->setValueOptions($parents);
        $select->setValue($role->parent_role);


        $form = new RoleForm();
        $form->add($select);
        $form->bind($role);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $cancel = $request->getPost('submit', 'cancel');
            if ($cancel == 'cancel') {
                return $this->redirect()->toRoute('admin', ['action' => 'index']);
            }
        }

        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($role->getInputFilter());
        $form->setData($request->getPost());


        if (!$form->isValid()) {
            return $viewData;
        }

        $this->rolestable->saveAclRoles($role);

        // Redirect to album list
        return $this->redirect()->toRoute('admin', ['action' => 'index']);
    }
    
    public function getrolespermissionsAction() {
        $permissions = $this->permissionstable->fetchAll();
        $id = (int) $this->params()->fromRoute('id', 0);
        //$this->rolestable->getUserRoles($id)
        $view = new ViewModel(array('rolespermissions' => $this->permissionstable->getRolesPermissions($id), 'permissions' => $permissions));
        $view->setTerminal(true);
        return $view;
    }
    
    public function addrolepermissionAction() {
        $permissions = $this->params()->fromRoute('id', 0);

//            $sessionobject = new Container('sessionadmin');
//            $userid = $sessionobject->selectedrow;
        $roleid = (int) $this->getRowId('rolerow');

        $permissionsList = explode(",", $permissions);
        foreach ($permissionsList as $permission) {
            $rolepermissions = new AclRolesPermissions();
            $rolepermissions->role_id = $roleid;
            $rolepermissions->permission_id = $permission;
            $this->rolespermissionstable->saveAclRolesPermissions($rolepermissions);
        }

        $data = ['response' => $roleid];
        return new JsonModel($data);
    }
    
    public function deleterolepermissionAction() {

        $id = (int) $this->getRowId('rolepermissionrow');

        $this->rolespermissionstable->deleteAclRolesPermissions($id);

        $data = ['response' => (int) $this->getRowId('rolerow')];

        return new JsonModel($data);
    }

//********************************************************************************* PERMISSIONS      
    public function addpermissionAction() {
        $form = new PermissionForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (!$request->isPost()) {
            return ['form' => $form];
        }

        if ($request->isPost()) {
            $cancel = $request->getPost('submit', 'cancel');
            if ($cancel == 'cancel') {
                return $this->redirect()->toRoute('admin', ['action' => 'index']);
            }
        }

        $permissions = new AclPermissions();
        $form->setInputFilter($permissions->getInputFilter());
        $form->setData($request->getPost());

        if (!$form->isValid()) {
            return ['form' => $form];
        }

        $permissions->exchangeArray($form->getData());
        $this->permissionstable->savePermissions($permissions);
        return $this->redirect()->toRoute('admin');
    }
    
    public function editpermissionAction() {
        
          $id = (int) $this->getRowId('permissionrow');

        if (0 === $id) {
            return $this->redirect()->toRoute('admin', ['action' => 'addpermission']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $permission = $this->permissionstable->getPermissions($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('admin', ['action' => 'index']);
        }
        
        
        $form = new PermissionForm();
        $form->bind($permission);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();

        if ($request->isPost()) {
            $cancel = $request->getPost('submit', 'cancel');
            if ($cancel == 'cancel') {
                return $this->redirect()->toRoute('admin', ['action' => 'index']);
            }
        }

        $viewData = ['id' => $id, 'form' => $form];

        if (!$request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($permission->getInputFilter());
        $form->setData($request->getPost());


        if (!$form->isValid()) {
            return $viewData;
        }

        $this->permissionstable->savePermissions($permission);

        // Redirect to album list
        return $this->redirect()->toRoute('admin', ['action' => 'index']);
    }

    public function deletepermissionAction() {
        //$id = (int) $this->params()->fromRoute('id', 0);
//        $sessionobject = new Container('sessionadmin');
//        $id = (int) $sessionobject->selectedrow;  
        $id = (int) $this->getRowId('permissionrow');

        if (!$id) {
            return $this->redirect()->toRoute('admin');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->permissionstable->deletePermission($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('admin');
        }

        return [
            'id' => $id,
            'permission' => $this->permissionstable->getPermissions($id),
        ];
    }

}
