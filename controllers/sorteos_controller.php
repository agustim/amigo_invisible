<?php
/* Classe de Sortegi */
/*                   */
/* SELECT a.amigo_id,a.nom,a.tu_amigo_id,a2.nom FROM ai_amigos a inner join ai_amigos a2 on a.tu_amigo_id = a2.amigo_id WHERE a.sorteo_id=N */

class SorteosController extends AppController {

	var $name = 'Sorteos';
	var $helpers = array('Html', 'Form', 'Javascript', 'Session');
	var $components = array('Auth','Email','SwiftMailer'); 
	var $wordSeparator = '-';
	var $solucions;

	function isAuthorized()
	{
		return ( ($this->Auth->user('group_id') == 'admin') ||
				 (($this->Auth->user('group_id') == 'user') && ( in_array($this->action,array('view','index','add','edit','todo')) ))
				);
	}
	function index()
	{
		$this->Sorteo->recursive = 0;
		$this->set('sorteos', $this->paginate(array('Sorteo.user_id'=>$this->Auth->user('user_id'))));
	}

	function view($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Invalid Sorteo.', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->set('sorteo', $this->Sorteo->find(array('Sorteo.sorteo_id' => $id,'Sorteo.user_id'=>$this->Auth->user('user_id'))));
		//$this->set('sorteo', $this->Sorteo->read(null, $id));
	}

	function add()
	{
		if (!empty($this->data))
		{
			$this->data['Sorteo']['user_id'] = $this->Auth->user('user_id');
			$this->data['Sorteo']['friendly_name'] = $this -> _getStringAsNiceName($this->data['Sorteo']['nom']);
			$this->Sorteo->create();
			if ($this->Sorteo->save($this->data))
			{
				$this->Session->setFlash(__('The Sorteo has been saved', true));
				$this->redirect(array('action'=>'index'));
			} else 
			{
				$this->Session->setFlash(__('The Sorteo could not be saved. Please, try again.', true));
			}
		} 
		else 
		{
			$this->set('estat',$this->Sorteo->getEstatList());
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data))
		{
			$this->Session->setFlash(__('Invalid Sorteo', true));
			$this->redirect(array('action'=>'index'));
		}
		if (!empty($this->data))
		{
			//Verificar que registre actual 'sorteo_id' el 'user_id' sigui l'Autentificat!
			$this->data['Sorteo']['user_id'] = $this->Auth->user('user_id');
			$this->data['Sorteo']['friendly_name'] = $this -> _getStringAsNiceName($this->data['Sorteo']['nom']);
			if ($this->Sorteo->save($this->data))
			{
				$this->Session->setFlash(__('The Sorteo has been saved', true));
				$this->redirect(array('action'=>'index'));
			} 
			else 
			{
				$this->Session->setFlash(__('The Sorteo could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data))
		{
			$this->data = $this->Sorteo->find(array('Sorteo.sorteo_id' => $id,'Sorteo.user_id'=>$this->Auth->user('user_id')));
		}
		$usuarios = $this->Sorteo->User->find('list');
		$this->set(compact('users'));
	}

	function delete($id = null) 
	{
		if (!$id) 
		{
			$this->Session->setFlash(__('Invalid id for Sorteo', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Sorteo->del($id)) 
		{
			$this->Session->setFlash(__('Sorteo deleted', true));
			$this->redirect(array('action'=>'index'));
		}
	}
	function todo($id = null)
	{
		if (!$id)
		{
			$this->Session->setFlash(__('Invalid id for Sorteo', true));
			$this->redirect(array('action'=>'index'));
		}
		$llistat = array();
		$restriccions = array();
		$this->Sorteo->recursive = 2;
		$sorteo = $this->Sorteo->findAll(array('Sorteo.sorteo_id' => $id,'Sorteo.user_id'=>$this->Auth->user('user_id'),'Estat' => 'no sortejat'));
		if (count($sorteo) > 0 && count($sorteo[0]['Amigo']) > 0)
		{		
			foreach($sorteo[0]['Amigo'] as $amigo)
			{
				$llistat[] = $amigo['amigo_id'];
				$restriccions[$amigo['amigo_id']] = array();
				foreach($amigo['Restriccione'] as $restric)
				{
					$restriccions[$amigo['amigo_id']][] = $restric['amigo_invisible_id'];
				}
			}
			set_time_limit(0);
			$this->solucions = array();
			// Fem un rand dels usuaris, i busquem la primera solució.
			$llistat = $this->_rand_array($llistat);
			$this->_recursiveFunction($llistat,$restriccions,$llistat,array());
      //print_r($this->solucions);
      //exit();
			if (count($this->solucions) > 0) 
			{
				$resolucio = $this->solucions[0];
				foreach($resolucio as $amigo=>$invisible)
				{
					// assigna amic invisible a cada amic...
					$this->Sorteo->Amigo->id = $amigo;
					$this->Sorteo->Amigo->saveField('tu_amigo_id',$invisible);
					// Enviar correus!!! :-) 
					/*$user_actual = $this->Sorteo->Amigo->read(null,$amigo);
					$this->_sendEmailInformation($user_actual['Amigo']['email'],$user_actual['Sorteo']['sorteo_id'],
						$user_actual['Sorteo']['nom'],
						$user_actual['TuAmigo']['nom'],$user_actual['TuAmigo']['amigo_id'],
						$user_actual['TuAmigo']['public_key'],$user_actual['Amigo']['amigo_id'],
						$user_actual['Amigo']['private_key'],$user_actual['Amigo']['nom']);
				*/	
				}
				// Canvia l'estat del sorteig...
				$this->Sorteo->id = $id;
				$this->Sorteo->saveField('Estat','sortejat');
			}
			else 
			{
				$this->Session->setFlash(__('No hi ha posibles solucions amb les restriccions donades.',true));	
				$this->redirect(array('action'=>'index'));
			}
		}
		else 
		{
			$this->Session->setFlash(__('Sorteig ja sortejat o no hi ha "Amics" a aquest sorteig.',true));
			$this->redirect(array('action'=>'index'));
		}
	}
	function _recursiveFunction($llista,$restriccions,$elements_actuals,$relacions)
	{
		if(count($this->solucions) == 0)
		{
		if(count($elements_actuals) == 0)
		{
				$this->solucions[] = $relacions;
		} 
		else 
		{
			$posicio = count($llista) - count($elements_actuals); //Quina element de la llista
			$elements_actuals_rand = $this->_rand_array2($elements_actuals);
			foreach($elements_actuals_rand as $elem)
			{
				if(($llista[$posicio] != $elem) && (!in_array($elem,$restriccions[$llista[$posicio]]))) 
				// No és el mateix element      ii  No Té una restricció
				{
					$relacions[$llista[$posicio]] = $elem;
					$this->_recursiveFunction($llista,$restriccions,$this->_sub_array($elements_actuals, $elem),$relacions);
				}
			}
		}
		}
	}
  function _rand_array2($elems){
    $val=rand(1,count($elems));
    for($x=0;$x<$val;$x++){
      array_push($elems,array_shift($elems));
    }
    return($elems);
  }
	function _rand_array($elems){
		return(array_rand(array_flip($elems), count($elems)));
	}
	function _sub_array($arr,$ele)
	{
		$arrReturn = array();
		foreach($arr as $k=>$e)
		{
			if($ele != $e)
			{
				$arrReturn[$k] = $e;
			} 
		}
		return $arrReturn;
	}
	function _treu_una_solucio()
	{
	$esborrar = mt_rand(0,count($this->solucions)-1);	
	unset($this->solucions[$esborrar]);
	}

	function _sendEmailInformation($send_to,$sorteo_id,$sorteo_name,$ai_name,$ai_id,$ai_pagina,$your_id,$your_private_page,$your_name)
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
		$this->Email->template = 'send_info_sorteo';
		$this->Email->sendAs = 'text';
		$this->set('sorteo_id', $sorteo_id);
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
