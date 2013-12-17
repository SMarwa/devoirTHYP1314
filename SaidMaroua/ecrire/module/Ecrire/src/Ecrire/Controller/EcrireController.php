<?php 
namespace Ecrire\Controller;

 use Zend\Mvc\Controller\AbstractActionController;
 use Zend\View\Model\ViewModel;
 use Ecrire\Model\Ecrire;
 use Ecrire\Form\EcrireForm;
 use Zend\View\Model\JsonModel;
 
 class EcrireController extends AbstractActionController
 {
     protected $ecrireTable;
     
  
     //
     public function indexAction()
     {
         return new ViewModel(array(
         		'ecrires' => $this->getEcrireTable()->fetchAll(),
         ));
     }

     public function addAction()
     {
         $form = new EcrireForm();
         $form->get('submit')->setValue('Add');
         
         $request = $this->getRequest();
         if ($request->isPost()) {
         	$ecrire = new Ecrire();
         	$form->setInputFilter($ecrire->getInputFilter());
         	$form->setData($request->getPost());
         
         	if ($form->isValid()) {
         		$ecrire->exchangeArray($form->getData());
         		$this->getEcrireTable()->saveEcrire($ecrire);
         
         		// Redirect to list ecrire
         		return $this->redirect()->toRoute('ecrire');
         	}
         }
         return array('form' => $form);
     }

     public function editAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
         	return $this->redirect()->toRoute('ecrire', array(
         			'action' => 'add'
         	));
         }
         
         // Get the Album with the specified id.  An exception is thrown
         // if it cannot be found, in which case go to the index page.
         try {
         	$ecrire = $this->getEcrireTable()->getEcrire($id);
         }
         catch (\Exception $ex) {
         	return $this->redirect()->toRoute('ecrire', array(
         			'action' => 'index'
         	));
         }
         
         $form  = new EcrireForm();
         $form->bind($ecrire);
         $form->get('submit')->setAttribute('value', 'Edit');
         
         $request = $this->getRequest();
         if ($request->isPost()) {
         	$form->setInputFilter($ecrire->getInputFilter());
         	$form->setData($request->getPost());
         
         	if ($form->isValid()) {
         		$this->getEcrireTable()->saveEcrire($ecrire);
         
         		// Redirect to list of albums
         		return $this->redirect()->toRoute('ecrire');
         	}
         }
         
         return array(
         		'id' => $id,
         		'form' => $form,
         );
     }

     public function deleteAction()
     {
         $id = (int) $this->params()->fromRoute('id', 0);
         if (!$id) {
         	return $this->redirect()->toRoute('ecrire');
         }
         
         $request = $this->getRequest();
         if ($request->isPost()) {
         	$del = $request->getPost('del', 'No');
         
         	if ($del == 'Yes') {
         		$id = (int) $request->getPost('id');
         		$this->getEcrireTable()->deleteEcrire($id);
         	}
         
         	// Redirect to list of albums
         	return $this->redirect()->toRoute('ecrire');
         }
         
         return array(
         		'id'    => $id,
         		'ecrire' => $this->getEcrireTable()->getEcrire($id)
         );
     }
     public function getEcrireTable()
     {
         
     	if (!$this->ecrireTable) {
     		$sm = $this->getServiceLocator();
     		$this->ecrireTable = $sm->get('Ecrire\Model\EcrireTable');
     	}
     	return $this->ecrireTable;
     }
 }
 
 ?>