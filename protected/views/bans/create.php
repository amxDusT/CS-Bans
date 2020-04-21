<?php
/**
 * Вьюшка добавления бана
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */

$this->pageTitle = Yii::app()->name . ' :: Admin Panel - Add Ban';
$this->breadcrumbs = array(
	'Admin Panel' => array('/admin/index'),
	'Add Ban'
);

$this->renderPartial('/admin/mainmenu', array('active' =>'main', 'activebtn' => 'admaddban'));

?>

<h2>Add Ban</h2>

<?php echo $this->renderPartial('_form', array('model'=>$model, 'activebtn' => 'admaddban')); ?>
