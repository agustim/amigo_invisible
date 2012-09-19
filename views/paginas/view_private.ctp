<div class="pagina view">
	<h2><?php echo __('Pagina de',true).' '.$pagina['Amigo']['nom'].' v.'.$pagina['Pagina']['version'];?></h2>
	<?php echo $html->link('Edit','edit/'.$pagina['Pagina']['amigo_id'].'/'.$pagina['Amigo']['private_key']); ?>
	<div>
		<?php echo $pagina['Pagina']['contenido']; ?>
	</div>
</div>
<div class="actions">
</div>
