<?php
/**
 * Вьюшка редактирования уровня веб админов
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */

$this->pageTitle = Yii::app()->name .' :: Admin Panel - Web Levels';

$this->breadcrumbs=array(
	'Admin Panel'=>array('/admin/index'),
	'Web Levels'=>array('admin'),
	'Edit Level #' . $model->level
);

$this->menu=array(
	array('label'=>'Admin Panel','url'=>array('index')),
	array('label'=>'Levels','url'=>array('admin')),
);

$this->renderPartial('/admin/mainmenu', array('active' =>'site', 'activebtn' => 'webadmlevel'));
?>

<h2>Edit Level #<?php echo $model->level; ?></h2>

<?php echo $this->renderPartial('_form',array('model'=>$model)); ?>