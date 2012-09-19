<?php echo $form->create('Restriccione',array('action'=>'amigo/'.$amigo_id)); ?>
<h2><? __('Restricciones') ?></h2>
<div>
<?php 
foreach($amigos as $amigo){ 
	if ($amigo['Amigo']['amigo_id'] == $amigo_id) {
		echo __('Usuarios que no pueden ser amigo invisible de ',true);
		echo $amigo['Amigo']['nom']."(".$amigo['Amigo']['email'].")";
	}
}
?>
</div>
<?php 
foreach($amigos as $amigo){ 
	if ($amigo['Amigo']['amigo_id'] != $amigo_id) {	
		echo $form->input('user_id_'.$amigo['Amigo']['amigo_id'], 
			array('type'=>'checkbox','label'=> $amigo['Amigo']['nom']."(".$amigo['Amigo']['email'].")")); 
	} 
}
?>
<?php	echo $form->end('Submit'); ?>
