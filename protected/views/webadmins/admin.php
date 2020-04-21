<?php
/**
 * Вьюшка управления веб админами
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */

$this->pageTitle = Yii::app()->name .' :: Admin Panel - Web Admins';
$this->breadcrumbs=array(
	'Admin Panel'=>array('/admin/index'),
	'Web Admins Management',
);

$this->menu=array(
	array('label'=>'Admin Panel', 'url'=>array('/admin/index')),
	array('label'=>'Add Admin', 'url'=>array('create')),
);

$this->renderPartial('/admin/mainmenu', array('active' =>'site', 'activebtn' => 'webadmins'));
?>

<h2>Web Administration</h2>

<?php $this->widget('bootstrap.widgets.TbGridView', array(
	'id'=>'webadmins-grid',
	'type'=>'striped bordered condensed',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'username',
		'email',
		'level',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
		),
	),
)); ?>
