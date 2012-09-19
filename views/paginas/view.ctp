<?php if (isset($amigo) && isset($pagina)) { ?>
<div class="pagina view">
	<h2><?php echo __('Pagina de',true).' '.$amigo['Amigo']['nom'];?></h2>
	<?php echo $pagina['Pagina']['contenido']; ?>
</div>
<div class="actions">
</div>
<? } ?> 