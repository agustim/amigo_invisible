<div class="amigos form">
<?php echo $form->create('Amigo');?>
	<fieldset>
 		<legend><?php __('Add Amigo');?></legend>
	<?php
		echo $form->input('nom');
		echo $form->input('email');
/*		echo $form->input('public_key');
		echo $form->input('private_key');
		echo $form->input('sorteo_id');
		echo $form->input('user_id');
		echo $form->input('tu_amigo_id'); 
*/
	?>
	</fieldset>
<?php echo $form->end('Submit');?>
</div>
<div class="actions">
	<ul>
		<li><?php echo $html->link(__('List Amigos', true), array('action'=>'index'));?></li>
		<li><?php echo $html->link(__('List Sorteos', true), array('controller'=> 'sorteos', 'action'=>'index')); ?> </li>
	</ul>
</div>
