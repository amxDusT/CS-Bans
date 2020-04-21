<?php
/**
 * Вьюшка просмотра деталей ссылки главного меню
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */

$this->pageTitle = Yii::app()->name .' :: Admin Panel - Main Menu';
$this->breadcrumbs=array(
	'Admin Panel'=> array('/admin/index'),
	'Main Menu'=>array('admin'),
	'Reference # '.$model->id,
);

$this->menu=array(
	array('label'=>'Delete','url'=>'#','linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Delete link?')),
	array('label'=>'Edit','url'=>array('update','id'=>$model->id)),
	array('label'=>'Add Link','url'=>array('create')),
	array('label'=>'Link Management','url'=>array('admin')),
);
$this->renderPartial('/admin/mainmenu', array('active' =>'site', 'activebtn' => 'webmainmenu'));
?>

<h2>Reference Details #<?php echo $model->id; ?></h2>

<?php $this->widget('bootstrap.widgets.TbDetailView',array(
	'data'=>$model,
	'attributes'=>array(
		'pos',
		array(
			'name' => 'activ',
			'value' => $model->activ == 1 ? 'Yes' : 'Not'
		),
		'lang_key',
		'url',
		'lang_key2',
		'url2',
	),
)); ?>
