<?php
/**
 * Вьюшка редактирования бана
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */

$this->pageTitle = Yii::app()->name .' :: Admin Panel - Edit Player Ban ' . $model->player_nick;
$this->breadcrumbs=array(
	'Banlist'=>array('index'),
	'Ban #'.$model->bid=>array('view','id'=>$model->bid),
	'Edit',
);

?>

<h2>Edit Ban #<?php echo $model->bid; ?></h2>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>