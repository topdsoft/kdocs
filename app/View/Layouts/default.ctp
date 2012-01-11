<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

$cakeDescription = __d('kDocs', 'Kdocs');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $title_for_layout; ?>
	</title>
	<?php
		echo $this->Html->meta('icon');

		echo $this->Html->css('cake.generic');

		echo $scripts_for_layout;
	?>
</head>
<body>
	<div id="container">
		<div id="header">
			<div id="tname"><?php echo $this->Html->link($cakeDescription, '/'); ?></div>
			<div id="usernav">
				<?php
				if($this->Session->read('Auth.User.username')) {
					//user is logged in
					echo 'Welcome '.$this->Session->read('Auth.User.username').'<br>';
					echo $this->Html->link('Logout', array('controller'=>'users','action'=>'logout'));
				} else {
					//no user logged in
					echo $this->Html->link('Login', array('controller'=>'users','action'=>'login')).'<br>';
//					echo $this->Html->link('Register', array('controller'=>'users','action'=>'register'));
				}//endif
				?>
			</div>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>
			<?php echo $this->Session->flash('auth'); ?>

			<?php echo $content_for_layout; ?>

		</div>
		<div id="footer">
			<?php echo $this->Html->link(
					$this->Html->image('cake.power.gif', array('alt'=> $cakeDescription, 'border' => '0')),
					'http://www.cakephp.org/',
					array('target' => '_blank', 'escape' => false)
				);
			?>
		</div>
<div id="footer2">
Copyright &copy; <?php echo date('Y');?> <a href="http://topDsoft.com" style="color:#fff">Top Drawer Software</a> | 
Proprietary Data of Top Drawer Software LLC
</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>

</html>