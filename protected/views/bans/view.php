<?php
/**
 * Вьюшка просмотра деталей бана
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */

$page = 'Banlist';
$this->pageTitle = Yii::app()->name . ' - ' . $page . ' - Ban Details ' . $model->player_nick;
$this->breadcrumbs=array(
	$page=>array('index'),
	$model->player_nick,
);
if($geo) {
	Yii::app()->clientScript->registerScriptFile('//api-maps.yandex.ru/2.0/?load=package.full&lang=en-US',CClientScript::POS_END);
	Yii::app()->clientScript->registerScript('yandexmap', "
		ymaps.ready(inityamaps);
		function inityamaps () {
			var myMap = new ymaps.Map('map', {center: [{$geo['lat']}, {$geo['lng']}], zoom: 10});
		}
	",CClientScript::POS_END);
}

if($model->ban_length == '-1') {
    $length = 'Unban';
} else {
    $length = Prefs::date2word($model->ban_length);
    if($model->unbanned) {
        $length .= '(Expired)';
    } elseif(Yii::app()->hasModule('billing')) {
        $length .= CHtml::link(
            'Buy Unban',
			array('/billing/unban', 'id' => $model->primaryKey),
			array('class' => 'btn btn-mini btn-success pull-right')
        );
    }
}
?>

<h2>Ban Details <i><?php echo CHtml::encode($model->player_nick); ?></i></h2>
<div style="float: right">
	<?php
	if(Webadmins::checkAccess('bans_edit', $model->admin_nick)):
	echo CHtml::link(
		'<i class="icon-edit"></i>',
		$this->createUrl('/bans/update', array('id' => $model->bid)),
		array(
			'rel' => 'tooltip',
			'title' => 'Edit',
		)
	);
	endif;
	?>
	&nbsp;
	<?php
	if(Webadmins::checkAccess('bans_unban', $model->admin_nick) && !$model->unbanned):
	echo CHtml::ajaxLink(
		'<i class="icon-remove"></i>',
		$this->createUrl('/bans/unban', array('id' => $model->bid)),
		array(
			'type' => 'post',
			'beforeSend' => 'function() {if(!confirm("Unban '.$model->player_nick.'?")) {return false;} }',
			'success' => 'function(data) {alert(data); document.location.href="'.$this->createUrl('/bans/index').'";}'
		),
		array(
			'rel' => 'tooltip',
			'title' => 'Unban',
		)
	);
	endif;
	?>
	&nbsp;
	<?php
	if(Webadmins::checkAccess('bans_delete', $model->admin_nick)):
	echo CHtml::ajaxLink(
		'<i class="icon-trash"></i>',
		$this->createUrl('/bans/delete', array('id' => $model->bid, 'ajax' => 1)),
		array(
			'type' => 'post',
			'beforeSend' => 'function() {if(!confirm("Are you sure you want to Delete the ban?")) {return false;} }',
			'success' => 'function() {alert("Ban Deleted"); document.location.href="'.$this->createUrl('/bans/index').'"}'
		),
		array(
			'rel' => 'tooltip',
			'title' => 'Delete Ban',
		)
	);
	endif;
	?>
</div>

<?php $this->widget('bootstrap.widgets.TbDetailView', array(
	'data'=>$model,
	'type' => array('condensed', 'bordered'),
	'htmlOptions' => array('style'=>'text-align: left'),
	'attributes'=>array(
		array(
			'name' => 'player_ip',
			'type' => 'raw',
			'value' => $geo['city'] ? CHtml::link(
					$model->player_ip,
					'#',
					array(
						'onclick' => '$("#modal-map").modal("show");',
						'rel' => 'tooltip',
						'title' => 'IP Details'
					)
				) : $model->player_ip,
			'visible' => ($ipaccess)
		),
		array(
			'name' => 'player_id',
			'type' => 'raw',
			'value' => Prefs::steam_convert($model->player_id, TRUE)
				? CHtml::link($model->player_id, 'http://steamcommunity.com/profiles/'
						. Prefs::steam_convert($model->player_id), array('target' => '_blank'))
				: $model->player_id,
		),
		'player_nick',
		'adminName:html',
		'ban_reason',
		array(
			'name' => 'ban_created',
			'value' => date('d.m.Y - H:i:s', $model->ban_created),
		),
		array(
			'name' => 'ban_length',
			'type' => 'raw',
			'value' => $length
		),
		'expiredTime',
		'server_name',
		'ban_kicks',
	),
)); ?>

<hr>
<p class="text-success">
	<i class="icon-calendar"></i>
	Ban History
</p>
<?php
$this->widget('bootstrap.widgets.TbGridView',array(
	'type' => 'bordered stripped',
	'id'=>'ban-history-grid',
	'dataProvider'=>$history,
	'enableSorting' => FALSE,
	'template' => '{items} {pager}',
	'columns'=>array(
		array(
			'name' => 'player_nick',
			'type' => 'html',
			'value' => 'Chtml::link($data->player_nick, Yii::app()->createUrl("/bans/view", array("id" => $data->bid)))'
		),
		array(
			'name' => 'player_id',
			'type' => 'raw',
			'value' => 'Prefs::steam_convert($data->player_id, TRUE)
				? CHtml::link($data->player_id, "http://steamcommunity.com/profiles/"
						. Prefs::steam_convert($data->player_id), array("target" => "_blank"))
				: $data->player_id',
		),
		array(
			'name' => 'player_ip',
			'value' => '$data->player_ip',
			'visible' => $ipaccess
		),
		array(
			'name' => 'ban_created',
			'value' => 'date("d.m.Y - H:i:s", $data->ban_created)',
		),
		'ban_reason',
		
		array(
			'name' => 'ban_length',
			'type' => 'raw',
			'value' =>
				'$data->ban_length == "-1"
					?
				"Unbanned"
					:
				Prefs::date2word($data->ban_length) .
				($data->expired == 1 ? " (Expired)" : "")'
		),
	),
));
?>

