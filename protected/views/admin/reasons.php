<?php
/**
 * Вьюшка причин банов
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */

$page = 'Reasons of Bans';
$this->pageTitle = Yii::app()->name . ' - ' . $page;

$this->breadcrumbs=array(
	'Admin Panel'=>array('/admin/index'),
	$page
);

$this->renderPartial('/admin/mainmenu', array('active' =>'server', 'activebtn' => 'servreasons'));

$this->menu=array(
	array('label'=>'Add Reason Group','url'=>array('/reasonsSet/create')),
	array('label'=>'Add Reason','url'=>array('/reasons/create')),
);


Yii::app()->clientScript->registerScript('getreasons', '
function getreasons(groupid)
{
	$("#loading").show();
	$.post("", {"groupid": groupid.substr(6), "'.Yii::app()->request->csrfTokenName.'": "'.Yii::app()->request->csrfToken.'"}, function(data){eval(data);});
}
function clearmodal()
{
	$(".modal-header").html("");
	$(".modal-body").html("");
	$(".save").remove();
	$("#reasons-modal").modal("hide");
}
', CClientScript::POS_END);
?>


<h2>Managing Ban Reasons</h2>

<h4>Reasons Group</h4>
<small class="text-success">Click on a group to edit</small>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'type' => 'bordered condensed striped',
	'id'=>'reasonsset-grid',
	'dataProvider'=>$reasonsset,
	//'summaryText' => 'Shown с {start} By {end} Reasons From {count}. Page {page} Of {pages}',
	'template' => '{pager} {items}',
	'pager' => array(
		'class'=>'bootstrap.widgets.TbPager',
		'displayFirstAndLast' => true,
	),
	'rowHtmlOptionsExpression'=>'array(
		"class" => "rgroup",
		"id" => "rgroup" . $data->id,
		"style" => "cursor:pointer;",
	)',
	'enableSorting' => FALSE,
	'columns'=>array(
		array(
			'name' => 'setname',
			'value' => '$data->setname',
			'htmlOptions' => array(
				'onclick' => 'getreasons($(this).closest("tr").attr("id"));'
			)
		),
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{delete}',
			'buttons' => array(
				'delete' => array(
					'url' => 'Yii::app()->createUrl("/reasonsSet/delete", array("id" => $data->id))'
				)
			)
		),
	),
)); ?>


<h4>Reasons</h4>
<?php $this->widget('bootstrap.widgets.TbGridView',array(
	'type' => 'bordered condensed striped',
	'id'=>'reasons-grid',
	'dataProvider'=>$reasons,
	'template' => '{pager} {items}',
	//'summaryText' => 'Shown с {start} By {end} Reasons From {count}. Page {page} Of {pages}',
	'pager' => array(
		'class'=>'bootstrap.widgets.TbPager',
		'displayFirstAndLast' => true,
	),
	'enableSorting' => FALSE,
	'columns'=>array(
		'reason',
		'static_bantime',
		array(
			'class'=>'bootstrap.widgets.TbButtonColumn',
			'template' => '{update} {delete}',
			'buttons' => array(
				'update' => array(
					'url' => 'Yii::app()->createUrl("/reasons/update", array("id" => $data->id))'
				),
				'delete' => array(
					'url' => 'Yii::app()->createUrl("/reasons/delete", array("id" => $data->id))'
				)
			)
		),
	),
)); ?>

<?php $this->beginWidget('bootstrap.widgets.TbModal',
	array(
		'id'=>'reasons-modal',
		'htmlOptions' => array(
			'style' => 'width: 600px; margin-left: -300px'
		)
)); ?>

<div class="modal-header"></div>

<div class="modal-body"></div>

<div class="modal-footer">
    <?php $this->widget('bootstrap.widgets.TbButton', array(
        'label'=>'Close',
        'url'=>'#',
        'htmlOptions'=>array(
			//'data-dismiss'=>'modal',
			'onclick' => 'clearmodal()'
			),
    )); ?>
</div>
<?php $this->endWidget(); ?>