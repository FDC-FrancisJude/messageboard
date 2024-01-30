<?php

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Message Board');
$cakeVersion = __d('cake_dev', 'CakePHP %s', Configure::version())
?>
<!DOCTYPE html>
<html>

<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $cakeDescription ?>:
		<?php echo $this->fetch('title'); ?>
	</title>
	<?php
	echo $this->Html->meta('icon');

	echo $this->Html->css('cake.generic');

	echo $this->fetch('meta');
	echo $this->fetch('css');
	echo $this->fetch('script');
	?>
	<style>
        .green-dot {
            width: 10px;
            height: 10px;
            background-color: #28a745;
            border-radius: 50%;
            display: inline-block;
            margin-right: 8px;
        }
    </style>
	<!-- Add these lines to include jQuery and jQuery UI -->
	<?php echo $this->Html->script('https://code.jquery.com/jquery-3.6.4.min.js'); ?>
	<?php echo $this->Html->script('https://code.jquery.com/ui/1.12.1/jquery-ui.js'); ?>
	<?php echo $this->Html->css('https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css'); ?>

	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>

<body>
	<div id="container">
		<div id="header">
			<?php if (isset($is_login) && $is_login) : ?>
				<nav class="navbar navbar-expand-lg navbar-primary bg-primary fixed-top">
					<?php
					echo $this->Html->link(
						'MESSAGE BOARD',
						array('controller' => 'message', 'action' => 'index'),
						array('class' => 'navbar-brand')
					);
					//print_r($login_user) ;
					?>
					<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon"></span>
					</button>

					<div class="collapse navbar-collapse" id="navbarNav">
						<ul class="navbar-nav">
							<li class="nav-item active">
								<?php
								echo $this->Html->link(
									'Message List',
									array('controller' => 'message', 'action' => 'index'),
									array('class' => 'nav-link')
								);
								?>
							</li>
							<li class="nav-item">
								<?php
								echo $this->Html->link(
									'Profile Details',
									array('controller' => 'profile', 'action' => 'index'),
									array('class' => 'nav-link')
								);
								?>
							</li>
						</ul>
					</div>
					<ul class="navbar-nav ml-auto" style="font-size: 20px; font-weight: bold;">
						<li class="nav-item">
							<?php
								// echo $this->Html->link(
								// 	'Welcome, ' . $login_user['name'],
								// 	array('controller' => 'account', 'action' => 'index'),
								// 	array('class' => 'nav-link')
								// );
								echo $this->Html->link(
									'Welcome, ' . $login_user['name'],
									array('controller' => 'account', 'action' => 'index'),
									array(
										'class' => 'nav-link disabled-link',
										'id' => 'disabled-link', 
										'onClick' => 'return false;', 
									)
								);
							?>
						</li>
						<li class="nav-item">
							<?php
								echo $this->Html->link(
									'Logout',
									array('controller' => 'users', 'action' => 'logout'),
									array('class' => 'nav-link')
								);
							?>
						</li>
					</ul>
				</nav>
			<?php endif; ?>
		</div>
		<div id="content" style="margin-top: <?php echo $is_login ? '60px' : '0'; ?>">
			<?php echo $this->Flash->render(); ?>
			<?php
			// $flashMessages = $this->Session->read('Message.flash');
			// if ($flashMessages) {
			// 	foreach ($flashMessages as $flashMessage) {
			// 		echo '<div class="alert alert-' . (isset($flashMessage['params']['class']) ? $flashMessage['params']['class'] : 'info') . '">';
			// 		echo $flashMessage['message'];
			// 		echo '</div>';
			// 	}
			// }
			?>
			<div class="container">
				<div class="row">
					<?php if (isset($is_login) && $is_login) : ?>
					<div class="col-md-3">
						<div class="card">
							<div class="card-header">
								Profile
							</div>
							<div class="card-body text-center">
								<?php
									echo $this->Html->image($users['Profile']['profile_pic'], array(
										'class' => 'img-fluid rounded-circle',
										'alt' => 'User Image',
										'width' => 150,
										'height' => 150,
										'style' => 'width: 150px; height: 150px;',
									));
								?>
								<h2 class="card-title"><?php echo !empty($users['User']['name']) ? $users['User']['name'] : 'Unset'; ?></h2>
								<?php if(empty($users['Profile']['gender']) || empty($users['Profile']['birthday']) || empty($users['Profile']['hubby'])): ?>
								<p class="card-text">Profile not yet completed. Please complete your profile.</p>
								<?php
									echo $this->Html->link(
										'Complete Profile',
										array('controller' => 'profile','action' => 'update'),
										array('class' => 'btn btn-primary btn-sm')
									);
								?>
								<?php else:?>
									<p class="card-text"><?php echo $users['Profile']['hubby'];?></p>
								<?php endif;?>
								
							</div>
							<div class="card-footer text-body-secondary text-center">
								<span class="green-dot"></span>Online
							</div>
						</div>
					</div>
					<?php endif;?>
					<div class="<?php echo $is_login ? 'col-md-9' : 'col-md-12' ?>">
						<?php  echo $this->fetch('content'); ?>
					</div>
					<?php //print_r($login_user) ?>
				</div>
			</div>

		</div>
		<div id="footer">
			<?php //echo $this->Html->link(
			//$this->Html->image('cake.power.gif', array('alt' => $cakeDescription, 'border' => '0')),
			//'https://cakephp.org/',
			//array('target' => '_blank', 'escape' => false, 'id' => 'cake-powered')
			//);
			?>
			<p>
				<?php //echo $cakeVersion; 
				?>
			</p>
		</div>
	</div>
	<?php //echo $this->element('sql_dump'); 
	?>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>

</html>