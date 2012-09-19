<?php
class PaginasController extends AppController {

	var $name = 'Paginas';
	var $helpers = array('Html', 'Form', 'Javascript');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow(array('viewPrivate','edit','view','index'));	
		$this->Auth->deny('*');
	}
	
	function isAuthorized(){
		return ( ($this->Auth->user('group_id') == 'admin') 
				);
	}
	function index(){
		
	}
	function viewPrivate ($id = null, $private_key = null) {
		if (!$id || !$private_key) {
			$this->Session->setFlash(__('Parametors incorrectos!',true));
			$this->redirect(array('action'=>'index'));
		}
		if (!is_numeric($id) || !$private_key || 
				!$this->Pagina->Amigo->findCount(array('Amigo.amigo_id' => $id,'Amigo.private_key' => $private_key),0)){
			$this->Session->setFlash(__('Error en llave privada o usuario incorrecto!',true));
			$this->redirect(array('action'=>'index'));
		}
		$pagina = $this->Pagina->find("Pagina.amigo_id = {$id}",null,'version DESC');
		if(empty($pagina)){
			$this->Session->setFlash(__('Todavía no has escrito nada, ahora puedes hacerlo.',true));
			$this->redirect(array('action'=>'edit',$id,$private_key));
		} else {
			$this->set('pagina',$pagina);
		}
		
	}
	function edit ($id = null, $private_key = null){
		if (!$id || !$private_key) {
			$this->Session->setFlash(__('Parametors incorrectos!',true));
			$this->redirect(array('action'=>'index'));
		}
		if (!is_numeric($id) || !$private_key || 
				!$this->Pagina->Amigo->findCount(array('Amigo.amigo_id' => $id,'Amigo.private_key' => $private_key),0)){
			$this->Session->setFlash(__('Error en llave privada!',true));
			$this->redirect(array('action'=>'index'));
		}
		if(empty($this->data)){
			$this->data = $this->Pagina->find("Pagina.amigo_id = {$id}",null,'version DESC');
			$this->set('pagina',$this->data);
			$this->set('id',$id);
			$this->set('private_key',$private_key);
		} else {
			//Comprovar que contingut ha canviat
			$contingut = $this->Pagina->find("Pagina.amigo_id = {$id}",'contenido','version DESC');
			if($contingut['Pagina']['contenido'] != $this->data['Pagina']['contenido']) {
				//Save
				++$this->data['Pagina']['version'];
				$this->data['Pagina']['amigo_id'] = $id;
				$this->Pagina->create();
				if ($this->Pagina->save($this->data)) {
				//	$this->Session->setFlash(__('Grabada correctamente', true));
					$this->redirect(array('action'=>'viewPrivate/'.$id."/".$private_key));
				} else {
					$this->Session->setFlash(__('Problemas guardando los datos. Por favor intentalo de nuevo.', true));
				}
			} else {
				//$this->Session->setFlash(__('Contenido sin cambiar. No es necesario crear versión.',true));
				$this->redirect(array('action'=>'viewPrivate',$id,$private_key));
			}
		}
	}
	function view ($id = null, $public_key = null){
		if (!$id || !$public_key) {
			$this->Session->setFlash(__('Parametors incorrectos!',true));
			$this->redirect(array('action'=>'index'));
		}
		if (!is_numeric($id) || !$public_key || !$this->Pagina->Amigo->findCount(array("Amigo.amigo_id" => $id,"Amigo.public_key"=>$public_key),0)){
			$this->Session->setFlash(__('Usuario Invalido!',true));
			$this->redirect(array('action'=>'index'));
		}
		if(!($datos = $this->Pagina->find("Pagina.amigo_id = {$id}",'version,contenido','version DESC'))){
			$this->Session->setFlash(__('El usuario no ha editado su pagina todavía.', true));
		} else {
			$this->set('amigo',$this->Pagina->Amigo->find("Amigo.amigo_id = {$id}",'nom,email',null,0));
			$this->set('pagina',$datos);
			$this->layout = 'default';
		}
	}

}
?>