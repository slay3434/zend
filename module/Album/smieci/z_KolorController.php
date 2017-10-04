<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Album\Controller;

use Album\Model\AlbumTable;
use Album\Model\KolorTable;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

use Album\Form\AlbumForm;
use Album\Form\KolorForm;
use Album\Model\Album;

class KolorController extends AbstractActionController
{
    private $table;
    private $kolortable;
    
      public function __construct(AlbumTable $table, KolorTable $kolortable)
    {
        $this->table = $table;
        $this->kolortable = $kolortable;
    }
    
    public function indexAction()
    {
          return new ViewModel([
            'albums' => $this->table->fetchAll(),
            'kolors' => $this->kolortable->fetchAll(),
        ]);
    }
    
    public function getkolorgridAction()
    {
        //$this->_helper->layout->disableLayout();
        
        $id = (int) $this->params()->fromRoute('id', 0);
        $viewmodel = new ViewModel([       
            'kolors' => $this->kolortable->getKolorByAlbum($id),
        ]);  
        
        $viewmodel->setTerminal(true);
        
        return $viewmodel;
    }

    public function addAction()
    {
        $form = new AlbumForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }
        
         if ($request->isPost()) {
            $cancel = $request->getPost('submit', 'cancel');
            if($cancel=='cancel')
            { 
                return $this->redirect()->toRoute('album', ['action' => 'index']);
            }
         }

        $album = new Album();
        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $album->exchangeArray($form->getData());
        $this->table->saveAlbum($album);
        return $this->redirect()->toRoute('album');
    }

    public function editAction()
    {
          $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('album', ['action' => 'add']);
        }

        // Retrieve the album with the specified id. Doing so raises
        // an exception if the album is not found, which should result
        // in redirecting to the landing page.
        try {
            $album = $this->table->getAlbum($id);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');

        $request = $this->getRequest();
        
        if ($request->isPost()) {
            $cancel = $request->getPost('submit', 'cancel');
            if($cancel=='cancel')
            { 
                return $this->redirect()->toRoute('album', ['action' => 'index']);
            }
         }
        
        $viewData = ['id' => $id, 'form' => $form];

        if (! $request->isPost()) {
            return $viewData;
        }

        $form->setInputFilter($album->getInputFilter());
        $form->setData($request->getPost());
        
        
        if (! $form->isValid()) {
            return $viewData;
        }

        $this->table->saveAlbum($album);

        // Redirect to album list
        return $this->redirect()->toRoute('album', ['action' => 'index']);
    }

    public function deleteAction()
    {
         
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            return $this->redirect()->toRoute('album');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost('del', 'No');

            if ($del == 'Yes') {
                $id = (int) $request->getPost('id');
                $this->table->deleteAlbum($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album');
        }

        return [
            'id'    => $id,
            'album' => $this->table->getAlbum($id),
        ];
    
    }
    
    
    
     public function addKolorAction()
    {
        $form = new KolorForm();
        $form->get('submit')->setValue('Add');

        $request = $this->getRequest();

        if (! $request->isPost()) {
            return ['form' => $form];
        }
        
         if ($request->isPost()) {
            $cancel = $request->getPost('submit', 'cancel');
            if($cancel=='cancel')
            { 
                return $this->redirect()->toRoute('album', ['action' => 'index']);
            }
         }

        $kolor = new Kolor();
        //$form->setInputFilter($kolor->getInputFilter());
        $form->setData($request->getPost());

        if (! $form->isValid()) {
            return ['form' => $form];
        }

        $kolor->exchangeArray($form->getData());
        $this->table->saveKolor($kolor);
        return $this->redirect()->toRoute('album');
    }
}