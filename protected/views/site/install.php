<?php
/**
 * Вьюшка инсталлера
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */

$this->pageTitle=Yii::app()->name . ' - Installation';
$this->breadcrumbs=array(
	'Installation',
);
?>

<h2>Installation</h2>

<?php if(count($error)): ?>

	<div class="alert alert-error">
	<b>Installation is not possible. Fix the following issues:</b><br>
	<ul><?php foreach($error AS $er): ?>
		<li><?php echo $er; ?></li>
	<?php endforeach; ?>
	</ul></div>

	<?php echo CHtml::link('Check again', array('site/install'), array('class' => 'btn')); ?>

<?php elseif($success): ?>

	<div class="alert alert-success">Installation was successful!</div>

<?php else: ?>

	<?php echo CHtml::form(); ?>

	<?php echo CHtml::errorSummary($form); ?>

	<fieldset>
		<legend>Data for connecting to the database</legend>
		<?php echo CHtml::activeTextField($form, 'db_host', array('placeholder' => 'Host')); ?><br>
		<?php echo CHtml::activeTextField($form, 'db_user', array('placeholder' => 'User')); ?><br>
		<?php echo CHtml::activePasswordField($form, 'db_pass', array('placeholder' => 'Password')); ?><br>
		<?php echo CHtml::activeTextField($form, 'db_db', array('placeholder' => 'Database')); ?><br>
		<?php echo CHtml::activeTextField($form, 'db_prefix', array('placeholder' => 'Table Prefix (optional)')); ?><br>
		<?php echo CHtml::ajaxButton('Check connection', '', array('type' => 'post',
			'update' =>'#db-status'), array('class' => 'btn btn-small')); ?><br><br>
		<span id="db-status"></span>
	</fieldset>
	<br>
	<fieldset>
		<legend>Admin Data</legend>
		<?php echo CHtml::activeTextField($form, 'login', array('placeholder' => 'Login')); ?><br>
		<?php echo CHtml::activePasswordField($form, 'password', array('placeholder' => 'Password')); ?><br>
		<?php echo CHtml::activeEmailField($form, 'email', array('placeholder' => 'E-mail')); ?><br>
	</fieldset>
	<br>
	<label class="checkbox"><?php echo CHtml::activeCheckBox($form, 'license'); ?> I accept the terms <?php
		echo CHtml::link('license agreement', array('/site/license'), array('target' => '_blank')) ?></label><br>
	<br>
	<?php echo CHtml::submitButton('Install', array('class' => 'btn btn-primary')); ?><br>

	<?php echo CHtml::endForm(); ?>

<?php endif; ?>