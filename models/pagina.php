<?php
class Pagina extends AppModel {

	var $name = 'Pagina';
	var $useTable = 'paginas';
	var $primaryKey = 'pagina_id';
	var $validate = array(
		'pagina_id' => array('numeric'),
		'amigo_id' => array('numeric'),
		'version' => array('numeric')
	);

	var $belongsTo = array(
			'Amigo' => array('className' => 'Amigo',
								'foreignKey' => 'amigo_id',
								'conditions' => '',
								'fields' => '',
								'order' => ''
			)
	);

}
?>