<?php
/**
 * Форма добавления и редактирования бана
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */


?>

<div class="form">

<?php $form=$this->beginWidget('bootstrap.widgets.TbActiveForm', array(
	'id'=>'bans-form',
	'type'=>'horizontal',
	'enableAjaxValidation'=>TRUE,
));

?>

<p class="note">Fields marked <span class="required">*</span> are required.</p>
<fieldset>
	<?php echo $form->errorSummary($model); ?>

	<?php echo $form->textFieldRow($model, 'player_nick', array('size'=>60,'maxlength'=>100)); ?>

	<?php echo $form->textFieldRow($model, 'player_id', array('size'=>35,'maxlength'=>35)); ?>
	<?php echo $form->textFieldRow($model, 'player_ip', array('size'=>32,'maxlength'=>32)); ?>

	<?php echo $form->dropDownListRow($model, 'ban_type', array('I' => 'IP', 'S' => 'SteamID', 'SI' => 'SteamID + IP')); ?>

	<?php //echo $form->dropDownListRow($model, 'ban_reason', Reasons::getList()); ?>
	
	<?php echo $form->textFieldRow($model, 'ban_reason', array('size'=>32,'maxlength'=>32)); ?>

	<?php echo $form->error($model,'ban_reason'); ?>
	
	<?php echo $form->dropDownListRow($model, 'ban_length', Bans::getBanLenght()); ?>
	
	<?php echo $form->dropDownListRow($model, 'update_ban', array('0' => 'Don\'t Update', '1' => 'Update All', '2' => 'Start Ban on join')); ?>

	<?php echo $form->dropDownListRow($model, 'expired', array('0' => 'No', '1' => 'Yes')); ?>
</fieldset>
	<div class="form-actions">
		<?php $this->widget('bootstrap.widgets.TbButton', array(
			'buttonType'=>'submit',
			'type'=>'primary',
			'label'=>$model->isNewRecord ? 'Create' : 'Refresh'));
		?>
		<?php echo CHtml::link(
				'Cancel',
				Yii::app()->createUrl('/admin/index'),
				array(
					'class' => 'btn btn-danger'
				)
			);
		?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->
