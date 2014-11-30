<?php
class AmigosController extends AppController {

	var $name = 'Amigos';
	var $helpers = array('Html', 'Form');
	var $components = array('Auth','Email','SwiftMailer'); 
	var $wordSeparator = "-";

	function beforeFilter(){
		parent::beforeFilter();		
		$this->Auth->allow(array('pages'));
		$this->Auth->deny('*');
	}
	function isAuthorized(){
		return ( ($this->Auth->user('group_id') == 'admin') ||
				 (($this->Auth->user('group_id') == 'user') && ( in_array($this->action,array('view','index','add','edit','sendKey','delete')) ))
				);
	}

	function pages($id = null, $fn = null) {
 		if (!$id || !$fn) {
                        $this->redirect(array('controller'=>'sorteos','action'=>'index'));
                }
		$amics = $this->paginate(array('Amigo.sorteo_id'=>$id,'Sorteo.friendly_name'=>$fn));
		if (count($amics) <= 0 ) {
			$this->redirect(array('controller'=>'sorteos','action'=>'index'));
                }
                $this->set('amigos', $amics);
	}
	function index($id = null) {
		if (!$this->_checkSorteo($id)){
			$this->redirect(array('controller'=>'sorteos','action'=>'index'));
		} 
		$this->set('amigos', $this->paginate(array('Sorteo.user_id'=>$this->Auth->user('user_id'),'Amigo.sorteo_id'=>$id)));
	}

	function view($id = null) {
		if (!$id || !$this->_checkSorteo()) {
			$this->Session->setFlash(__('Invalid Amigo.', true));
			$this->redirect(array('controller'=>'sorteos','action'=>'index'));
		}
		$this->set('amigo', $this->Amigo->read(null, $id));
	}

	function add() {
		if ($this->_checkSorteo()){
			if (!empty($this->data)) {
				$this->Amigo->create();
				$this->data['Amigo']['sorteo_id'] = $this->Session->read('Sorteo.sorteo_id');	
				$this->data['Amigo']['user_id'] = $this->Auth->user('user_id');
				$this->data['Amigo']['public_key'] = $this->_randNumber(32);
				$this->data['Amigo']['private_key'] = $this->_randNumber(32);
				if ($this->Amigo->save($this->data)) {
					$this->Session->setFlash(__('The Amigo has been saved', true));
					$this->redirect(array('action'=>'index',$this->data['Amigo']['sorteo_id']));
				} else {
					$this->Session->setFlash(__('The Amigo could not be saved. Please, try again.', true));
				}
			}
			$sorteos = $this->Amigo->Sorteo->find('list');
			$tuAmigos = $this->Amigo->TuAmigo->find('list');
			$this->set(compact('sorteos', 'tuAmigos'));
		} else {
			$this->redirect(array('controller'=>'sorteos','action'=>'index'));
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid Amigo', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data)) {
			if ($this->Amigo->save($this->data)) {
				$this->Session->setFlash(__('The Amigo has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else {
				$this->Session->setFlash(__('The Amigo could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Amigo->read(null, $id);
		}
		$sorteos = $this->Amigo->Sorteo->find('list');
		$tuAmigos = $this->Amigo->TuAmigo->find('list');
		$this->set(compact('sorteos','tuAmigos'));
	}

	function delete($id = null) {
		if (!$id && !$this->_checkSorteo()) 
		{
			$this->Session->setFlash(__('Invalid id for Amigo', true));
			$this->redirect(array('action'=>'index'));
		}
		$amigo = $this->Amigo->read(null, $id);
		if(($amigo['Amigo']['user_id'] == $this->Auth->user('user_id')) 
		  && ($amigo['Amigo']['sorteo_id'] == $this->Session->read('Sorteo.sorteo_id'))) 
		{
			if ($this->Amigo->del($id)) 
			{
				$this->Session->setFlash(__('Amigo deleted', true));
				$this->redirect(array('action'=>'index',$amigo['Amigo']['sorteo_id']));
			}
		}
	}
	function sendKey($id = null){
		if($this->_checkSorteo()){
			$user_actual = $this->Amigo->read(null,$id);
			$this->_sendEmailInformation($user_actual['Amigo']['email'],$user_actual['Sorteo']['sorteo_id'],
				$user_actual['Sorteo']['nom'],
				$user_actual['TuAmigo']['nom'],$user_actual['TuAmigo']['amigo_id'],
				$user_actual['TuAmigo']['public_key'],$user_actual['Amigo']['amigo_id'],
				$user_actual['Amigo']['private_key'],$user_actual['Amigo']['nom']);
			$this->Session->setFlash(__('The Amigo has been send information', true));	
			$this->redirect(array('action'=>'index',$user_actual['Amigo']['sorteo_id']));
		}
	}
	function _checkSorteo($id_sorteo = null){
		if ($id_sorteo || $this->Session->check('Sorteo.sorteo_id')) {
			$id_sorteo = ($id_sorteo) ? $id_sorteo : $this->Session->read('Sorteo.sorteo_id');
 			if($this->Amigo->Sorteo->findCount(array('Sorteo.user_id'=>$this->Auth->user('user_id'),'Sorteo.sorteo_id'=>$id_sorteo),0) > 0) { 
				$this->Session->write('Sorteo.sorteo_id',$id_sorteo);
				return true;
			} 				
		}
		return false;
	}
	function _randNumber($items){
		$val = '';
		for($index=0; $index < $items; $index++){
			$val .= dechex(mt_rand(0,15	));
		}
		return($val);
	}
	function _sendEmailInformation($send_to,$sorteo_id, $sorteo_name,$ai_name,$ai_id,$ai_pagina,$your_id,$your_private_page,$your_name)
	{
		$this->Email->smtpOptions = array(	'port' => Configure::read('Mail.port'),
											'host' => Configure::read('Mail.host'),
											'timeout' => Configure::read('Mail.timeout'),
											'username'=> Configure::read('Mail.username'),
											'password' => Configure::read('Mail.password'));
		//$this->Email->delivery = 'smtpAuthTLS';
		$this->Email->to = $send_to;
        	$this->Email->subject = '[Amigo Invisible] Resultado del Sorteo';
        	$this->Email->from = Configure::read('Mail.from');
		$this->Email->template = 'resend_info_sorteo';
		$this->Email->sendAs = 'text';
		$this->set('sorteo_id',$sorteo_id);
		$this->set('sorteo_name',$sorteo_name);
		$this->set('sorteo_friendly_name',$this->_getStringAsNiceName($sorteo_name));
		$this->set('ai_name',$ai_name);
		$this->set('ai_id',$ai_id);
		$this->set('ai_pagina',$ai_pagina);
		$this->set('your_id',$your_id);
		$this->set('your_private_page',$your_private_page);
		$this->set('your_name',$your_name);
        	$datos = $this->Email->send();
		return true;	
	}
        function _getStringAsNiceName($string)
        {
                //strip tags, trim, and lowercase
                $string = strtolower(trim(strip_tags($string)));
                //replace single quotes and double quotes first
                $string = preg_replace('/[\']/i', '', $string);
                $string = preg_replace('/["]/i', '', $string);

                $string = preg_replace('/&/', 'and', $string);

                //remove non-valid characters
                $string = preg_replace('/[^-a-z0-9]/i', $this->wordSeparator, $string);
                $string = preg_replace('/-[-]*/i', $this->wordSeparator, $string);

                //remove from beginning and end
                $string = preg_replace('/' . $this->wordSeparator . '$/i', '', $string);
                $string = preg_replace('/^' . $this->wordSeparator . '/i', '', $string);

                return $string;
        }

}
?>
