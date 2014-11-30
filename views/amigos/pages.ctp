<?php
//print_r($amigos);
?>
<div class="amigos index">
<h2><?php __('List of presents');?></h2>
<p>
<?php
echo $paginator->counter(array(
'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
));
?></p>
<table cellpadding="0" cellspacing="0">
<tr>
	<th><?php echo $paginator->sort('nom');?></th>
</tr>
<?php
$i = 0;
foreach ($amigos as $amigo):
	$class = null;
	if ($i++ % 2 == 0) {
		$class = ' class="altrow"';
	}
?>
	<tr<?php echo $class;?>>
		<td>
			<?php 
			echo $html->link(__($amigo['Amigo']['nom'], true), array('controller'=>'paginas','action'=>'view', $amigo['Amigo']['amigo_id'],$amigo['Amigo']['public_key']));
			if (count($amigo['Pagina']) == 0) {
			echo "<span style='color:#f00;'> - Todav&iacute;a NO ha apuntado ning&uacute;n regalo!!!</span>";
			}
			 ?>
		</td>
	</tr>
<?php endforeach; ?>
</table>
</div>
