<?php
/**
 * Вьюшка настроек системы
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */

$page = 'System Settings';
$this->pageTitle = Yii::app()->name . ' :: Admin Panel - ' . $page;

$this->breadcrumbs=array(
	'Admin Panel' => array('/admin/index'),
	$page,
);

$this->renderPartial('/admin/mainmenu', array('active' =>'site', 'activebtn' => 'websettings'));
?>
<h2>System Settings</h2>
<?php
$form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'settings-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>true,
));
?>
<p class="note">Fields marked <span class="required">*</span> are required.</p>
<fieldset>
	<legend>System</legend>
	<?php echo $form->errorSummary($model); ?>
	<?php //echo $form->dropDownListRow($model, 'default_lang', array('ru' => 'Русский', 'en' => 'English')); ?>
	<?php echo $form->checkBoxRow($model, 'use_capture', array('1' => 'Yes', '0' => 'No')); ?>
	<?php echo $form->checkBoxRow($model, 'auto_prune'); ?>
	<?php echo $form->textFieldRow($model, 'cookie'); ?>
	<legend>View</legend>
	<?php echo $form->dropDownListRow($model, 'banner', array('---' => '---', 'amxbans.png' => 'amxbans.png')); ?>
	<?php echo $form->textFieldRow($model, 'banner_url'); ?>
	<?php echo $form->dropDownListRow($model, 'design', $themes); ?>
	<?php echo $form->dropDownListRow($model, 'start_page', array(
		'/bans/index' => 'Banlist'
	));
	?>
	<legend>Banlist</legend>
	<?php echo $form->textFieldRow($model, 'bans_per_page'); ?>
	<?php echo $form->checkBoxRow($model, 'show_kick_count'); ?>
</fieldset>
<div class="form-actions">
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'submit', 'type'=>'primary', 'label'=>'Save')); ?>
    <?php $this->widget('bootstrap.widgets.TbButton', array('buttonType'=>'reset', 'label'=>'Reset')); ?>
</div>

<?php $this->endWidget(); ?>
