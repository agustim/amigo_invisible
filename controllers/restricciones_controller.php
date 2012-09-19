<?php
class RestriccionesController extends AppController {

	var $name = 'Restricciones';
	var $helpers = array('Html', 'Form');
	
	function isAuthorized(){
		return ( ($this->Auth->user('group_id') == 'admin') ||
				 (($this->Auth->user('group_id') == 'user') && ( in_array($this->action,array('amigo')) ))
				);
	}
	function amigo($id = null) {
		if($id && $this->Session->check('Sorteo.sorteo_id')) {
			$id_sorteo = $this->Session->read('Sorteo.sorteo_id');
			if($this->Restriccione->Amigo->Sorteo->findCount(
				array('Sorteo.user_id' => $this->Auth->user('user_id'),'Sorteo.sorteo_id' => $id_sorteo,
			          'Sorteo.Estat' => 'no sortejat'),0) > 0) 
			{ 
				if (!empty($this->data)){
					foreach($this->data['Restriccione'] as $k=>$v){
						$invisible = substr($k,8);
						$contador = $this->Restriccione->findCount(array('Restriccione.amigo_id' => $id,
																		 'Restriccione.user_id' => $this->Auth->user('user_id'),
																		 'Restriccione.amigo_invisible_id' => $invisible));
						if($v == 1 && $contador == 0){
							$_data['Restriccione']['amigo_id'] = $id;
							$_data['Restriccione']['user_id'] = $this->Auth->user('user_id');
							$_data['Restriccione']['amigo_invisible_id'] = $invisible;
							$this->Restriccione->create();
							$this->Restriccione->save($_data);
						}
						if($v == 0 && $contador == 1){
							$this->Restriccione->deleteAll(array('Restriccione.amigo_id' => $id,
																 'Restriccione.user_id' => $this->Auth->user('user_id'),
																 'Restriccione.amigo_invisible_id' => $invisible));
						}
					}
					$this->redirect(array('controller'=>'amigos','action'=>'index',$id_sorteo));
				}
				$this->Restriccione->Amigo->recursive=0;
				$this->set('amigos', $this->Restriccione->Amigo->findAll(array('Amigo.sorteo_id' => $id_sorteo)));
				$datos = $this->Restriccione->findAll(array('Restriccione.amigo_id' => $id));
				foreach($datos as $dato){
					$this->data['Restriccione']['user_id_'.$dato['Restriccione']['amigo_invisible_id']] = 1;
				}
				$this->set('amigo_id', $id);
			} else {
				$this->Session->setFlash(__('Sorteig ja Sortejat, no es poden tocar les restriccions.',true));
				$this->redirect(array('controller'=>'sorteos','action'=>'index'));
			}
		} else {
			$this->redirect(array('controller'=>'sorteos','action'=>'index'));
		}
	}
}
?>