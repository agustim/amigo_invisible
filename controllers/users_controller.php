<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Form', 'Session','Text' );
	var $components = array('Auth','Email','SwiftMailer'); 

	function index(){
		$this->redirect('/');
	}
	function admin_index() {
		$this->User->recursive = 0;
		$this->set('users', $this->paginate());
	}

	function admin_view($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid User.');
			$this->redirect(array('action'=>'index'), null, true);
		}
		$this->set('user', $this->User->read(null, $id));
	}

	function admin_edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash('Invalid User');
			$this->redirect(array('action'=>'index'), null, true);
		}
		if (!empty($this->data)) {
			if ($this->data['User']['first_password'] == $this->data['User']['confirm_password']){
				$this->data['User']['password'] = $this->Auth->password($this->data['User']['first_password']);
				unset($this->data['User']['confirm_password']);
				unset($this->data['User']['first_password']);
				if($this->User->save($this->data)) {
					$this->Session->setFlash(__('El usuario ha sido actualizado.',true));
					//$this->redirect(array('action'=>'index'), null, true);
				}
			} else {
				$this->data['User']['confirm_password'] = "";
				$this->data['User']['first_password'] = "";				
				$this->Session->setFlash(__('La contraseña y su confirmación tiene que ser iguales.',true ));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
		}
	}

	function admin_delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for User');
			$this->redirect(array('action'=>'index'), null, true);
		}
		if ($this->User->del($id)) {
			$this->Session->setFlash('User #'.$id.' deleted');
			$this->redirect(array('action'=>'index'), null, true);
		}
	}

	function admin_add() {
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data))
			{
				$this->Session->setFlash('The User has been saved');
				$this->redirect(array('action'=>'index'), null, true);
		} else 
			{
				$this->Session->setFlash('The User could not be saved. Please, try again.');
			}
		}
	}

	function login()
	{
	}

	function logout(){
		$this->Session->del('Sorteo.sorteo_id');
		$this->Session->del('Sorteo');
        $this->Session->setFlash('Logout');
	    $this->redirect($this->Auth->logout());
    }
	function register(){
		if(!empty($this->data)){
			if ($this->data['User']['first_password'] == $this->data['User']['confirm_password']){
				$this->data['User']['password'] = $this->Auth->password($this->data['User']['first_password']);
				$this->data['User']['active'] = 0;
				$this->data['User']['group_id'] = 'user';
				unset($this->data['User']['confirm_password']);
				unset($this->data['User']['first_password']);
				$this->User->create();
				if($this->User->save($this->data)) {
					$this->_sendRegister($this->data);
					$this->Session->setFlash(__('Ahora recibirás un correo para activar tu cuenta.',true));
					$this->redirect('/');
				}
			} else {
				$this->data['User']['confirm_password'] = "";
				$this->data['User']['first_password'] = "";				
				$this->Session->setFlash(__('La contraseña y su confirmación tiene que ser iguales.',true ));
			}
 		} 
	}
	function _sendRegister($data){
		$this->Email->smtpOptions = array(	'port' => Configure::read('Mail.port'),
											'host' => Configure::read('Mail.host'),
											'timeout' => Configure::read('Mail.timeout'),
											'username'=> Configure::read('Mail.username'),
											'password' => Configure::read('Mail.password'));
		$this->Email->delivery = 'smtpAuthTLS';
		$this->Email->to = $data['User']['email'];
        $this->Email->subject = '[Amigo Invisible] Activar Cuenta (Registro)';
        $this->Email->from = Configure::read('Mail.from');
		$this->Email->template = 'send_email';
		$this->Email->sendAs = 'text';
		$this->set('user',$data['User']['username']);
		$this->set('hash',$this->Auth->password($this->data['User']['password']));
        $datos = $this->Email->send();
		$this->Session->setFlash('Email sent');
		return true;
	}

/*	function ____sendEmail___($data){
		$this->Email->smtpOptions = array(	'port' => Configure::read('Mail.port'),
											'host' => Configure::read('Mail.host'),
											'timeout' => Configure::read('Mail.timeout'),
											'username'=> Configure::read('Mail.username'),
											'password' => Configure::read('Mail.password'));
		$this->Email->to = $data['User']['email'];
        $this->Email->subject = 'Test cake email(Debug - Sin SSL - sin delivery - i tres)... :-)';
        $this->Email->from = Configure::read('Mail.from');
        $datos = $this->Email->send('Here is the body of the email');
		$this->Session->setFlash('Simple email sent');
		return true;
	//	$this->redirect(array('action'=>'index'), null, true);
	}
	function ____sendEmail($data){
		$this->SwiftMailer->connection  = 'smtp'; 
		$this->SwiftMailer->smtp_host   = Configure::read('Mail.host');
		$this->SwiftMailer->smtp_type   = 'tls'; 
		$this->SwiftMailer->username  = Configure::read('Mail.username');
		$this->SwiftMailer->password  = Configure::read('Mail.password');

		if($this->SwiftMailer->connect())
		{
			$this->SwiftMailer->addTo('from',Configure::read('Mail.from'));
			$this->SwiftMailer->addTo('to',$data['User']['email']);
			$this->SwiftMailer->mailer->addPart("Plain Body");
			$this->SwiftMailer->mailer->addPart("Html Body", 'text/html');
			$this->SwiftMailer->send("Titulito");
		} 
	}

	function _sendEmail($data, $subject, $body){
		vendor('Swift');
		vendor('Swift/Connection/SMTP');
		
		$smtp = new Swift_Connection_SMTP("smtp.gmail.com", Swift_Connection_SMTP::PORT_SECURE, Swift_Connection_SMTP::ENC_TLS);
		$smtp->setUsername(Configure::read('Mail.username'));
		$smtp->setPassword(Configure::read('Mail.password'));

		$swift = new Swift($smtp); 

		$message = new Swift_Message($subject, $body);

		if ($swift->send($message, $data['User']['email'], Configure::read('Mail.username'))) {
			$this->Session->setFlash('Simple email sent');
			return true;
		} else { 
			$this->Session->setFlash('Simple email don\'t sent');
			return false;
		}
	} */
	function activeAccount($username = null, $hashConfirm = null){
		if (!$username || !$hashConfirm){
			$this->Session->setFlash('Invalid id for User');
			$this->redirect(array('action'=>'index'), null, true);			
		}
		$this->data = $this->User->find(array('User.username'=>$username));
		if (($this->Auth->password($this->data['User']['password']) == $hashConfirm) && ($this->data['User']['active'] == 0)) {
			$this->data['User']['active'] = 1;
			if ($this->User->save($this->data))
			{
				$this->Session->setFlash('The User has been actived');
			}
			else
			{
				$this->Session->setFlash('The User could not be actived. Please, try again.');
			}
		} else {
			$this->Session->setFlash(__('Hash erroneo o cuenta ya activada.',true));
		}
		$this->redirect(array('action'=>'index'), null, true);
	}
}
?>
