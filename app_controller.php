<?php
uses('L10n');
class AppController extends Controller {

	var $helpers = array('Html', 'Form','Javascript','Session');
	var $components = array('Auth');

	function beforeFilter(){
		$this->Auth->loginAction = array('admin' => 0, 'controller' => 'users', 'action' => 'login');
		$this->Auth->allow('register','activeAccount','sendEmail');
		// DELETE NEXT LINE WHEN CHANGE PASSWORD 
		$this->Auth->allow('register','activeAccount','sendEmail','admin_edit','admin_view','admin_index');
		// 
		$this->Auth->authorize = 'controller';
		$this->Auth->userScope = array('User.active' => 1); 
		$this->set('userObject',$this->Auth->user());
	}

	function isAuthorized() {
		if (isset($this->params[Configure::read('Routing.admin')])) {
			if ($this->Auth->user('group_id') != 'admin') {
				return false;
			}
		}
		return true;
	}
	
	function setIdioma( $idioma = null, $change = false ){
		$this->L10n = new L10n();

		if ($idioma == null) {
			if ($this->Session->check('Config.language')) {
				$this->Session->write('Config.language', Configure::read('Config.language'));
			}
			$this->L10n->get($this->Session->read('Config.language'));
		} else {
			$this->L10n->get($idioma);
			if($change) $this->Session->write('Config.language', $idioma);
		}
		//$this->L10n->get($this->Session->language));
	}
}
?>
