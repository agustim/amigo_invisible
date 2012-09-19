<?php
if(isset($javascript)){
    echo $javascript->link('tiny_mce/tiny_mce.js');
	echo $javascript->link('tiny_init.js');
}
if(isset($this->data)){
?>
<div class="paginas form">
<?php echo $form->create('Pagina',array('action'=>'edit'.'/'.$id.'/'.$private_key));?>
	<fieldset>
 		<legend><?php
 				if (empty($pagina)) {
					echo __('Editar Pagina',true);
				} else {
					echo __('Editar Pagina de',true).' '.$pagina['Amigo']['nom'].' v.'.$pagina['Pagina']['version'];
				}	
			?></legend>
	<?php
		echo $form->input('contenido');
		echo $form->input('version',array('type'=>'hidden'));
	?>
	</fieldset>
<?php echo $form->end(__('Grabar',true));?>
</div>
<? } ?>