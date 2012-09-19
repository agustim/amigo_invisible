<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<title>
		<?php __('Amigo Invisible'); ?>
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $html->charset();
		echo $html->meta('icon');

		echo $html->css('cake.generic');

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<h1><?php echo $html->link(__('Amigo Invisible: Gestionando ilusiones', true), 'http://biruji.org'); ?></h1>
		</div>
		<div id="menu">
		<ul>
		<?php 
		if(isset($userObject)){
			echo '<li id="user">';
			echo $userObject['User']['username'];
			if($userObject['User']['group_id'] === 'admin') echo ' ('.$userObject['User']['group_id'].')';
			echo '</li>';
			echo '<li>';
			echo $html->link(__('Mis Sorteos',true),array('admin' => 0,'controller'=>'sorteos','action'=>'index'));
			echo '</li>';

			if(($userObject['User']['group_id'] === 'admin') && (Configure::read('Routing.admin') == 'admin')) {
				echo '<li>';
				echo $html->link(__('Añadir Usuario',true),array('admin' => 1, 'controller'=>'users','action'=>'add'));
				echo '</li>';
				echo '<li>';
				echo $html->link(__('Lista de Usuarios',true),array('admin' => 1, 'controller'=>'users','action'=>'index'));
				echo '</li>';
				
			}
			echo '<li>';
			echo $html->link(__('Salir',true),array('admin' => 0,'controller'=>'users','action'=>'logout'));
			echo '</li>';
		} else {
			echo '<li>';
			echo $html->link(__('Iniciar Sessión',true),array('controller'=>'users','action'=>'login'));
			echo '</li>';
			echo '<li>';
			echo $html->link(__('Register',true),array('controller'=>'users','action'=>'register'));
			echo '</li>';
		}
		?>
		</ul>
		</div>

		<div id="content">
			<?php
				if ($session->check('Message.flash')):
						$session->flash();
				endif;
			?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php echo $html->link(
							$html->image('cake.power.gif', array('alt'=> __("CakePHP: the rapid development php framework", true), 'border'=>"0")),
							'http://www.cakephp.org/',
							array('target'=>'_new'), null, false
						);
			?>
			<?php echo $html->link(
							$html->image('biruji.power.gif', array('alt'=> __("Biruji.dev: A way of life", true), 'border'=>"0")),
							'http://biruji.org/',
							array('target'=>'_new'), null, false
						);
			?>

		</div>
	</div>
	<?php echo $cakeDebug; ?>
</body>
</html>
