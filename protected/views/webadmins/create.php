<?php
/**
 * Вьюшка добавления веб админа
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */

$this->pageTitle = Yii::app()->name .' :: Admin Panel - Add Web Admin';
$this->breadcrumbs=array(
	'Admin Panel'=>array('/admin/index'),
	'Web Admins'=>array('admin'),
	'Create a new web Admin',
);

$this->menu=array(
	array('label'=>'Admin Panel', 'url'=>array('/admin/index')),
	array('label'=>'Web Admins', 'url'=>array('admin')),
);
$this->renderPartial('/admin/mainmenu', array('active' =>'site', 'activebtn' => 'webadmins'));
?>

<h2>Add Web Admin</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>