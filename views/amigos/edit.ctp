<div class="amigos form">
<?php echo $form->create('Amigo');?>
	<fieldset>
 		<legend><?php __('Edit Amigo');?></legend>
	<?php
		echo $form->input('amigo_id');
		echo $form->input('nom');
		echo $form->input('email');
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
