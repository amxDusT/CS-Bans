<?php
/**
 * Вьюшка редактирования веб админа
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */

$this->pageTitle = Yii::app()->name .' :: Admin Panel - Edit Web Admin' . $model->username;
$this->breadcrumbs=array(
	'Admin Panel'=>array('/admin/index'),
	'Web Admins'=>array('admin'),
	'Edit Web Admins ' . $model->username,
);

$this->menu=array(
	array('label'=>'Admin Panel', 'url'=>array('/admin/index')),
	array('label'=>'Web Admin Management', 'url'=>array('admin')),
	array('label'=>'Delete', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to Delete?')),
);
$this->renderPartial('/admin/mainmenu', array('active' =>'site', 'activebtn' => 'webadmins'));
?>

<h2>Edit Web Admin "<?php echo $model->username; ?>"</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>