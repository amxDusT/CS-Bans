<?php
/**
 * Вьюшка управления уровнями веб админов
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
	'Web Levels',
);

$this->menu=array(
	array('label'=>'Admin Panel', 'url'=>array('/admin/index')),
	array('label'=>'Add Level', 'url'=>array('create')),
);
$this->renderPartial('/admin/mainmenu', array('active' =>'site', 'activebtn' => 'webadmlevel'));
?>

<h2>Web Admin Level Management</h2>

<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'id'=>'levels-grid',
	'dataProvider'=>$model->search(),
	'enableSorting' => FALSE,
	'columns'=>array(
		'level',

		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{update} {delete}'
		),
	),
)); ?>
