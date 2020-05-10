<?php
/**
 * Контррллер банов
 */

/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */
class BansController extends Controller
{
	public $layout='//layouts/column1';

	public function filters()
	{
		return array(
			'accessControl',
			'postOnly + delete',
			'ajaxOnly + bandetail, unban'
		);
	}

	public function actions(){
        return array(
            'captcha'=>array(
                'class'=>'CCaptchaAction',
            ),
        );
    }

	public function actionUnban($id)
	{
		$model = $this->loadModel($id);

		// Проверка прав
		if (!Webadmins::checkAccess('bans_unban', $model->admin_nick)) {
            throw new CHttpException(403, "You do not have enough rights");
        }

        $model->ban_length = '-1';
		$model->expired = 1;

		if ($model->save(FALSE)) {
            Yii::app()->end('Player is Unbanned');
        }

        Yii::app ()->end(CHtml::errorSummary($model));
	}

	/**
	 * Вывод инфы о бане
	 * @param integer $id ID бана
	 */
	public function actionView($id)
	{

		// Подгружаем баны
		$model=Bans::model()->findByPk($id);
		if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
		$geo = false;
		// Проверка прав на просмотр IP
		$ipaccess = Webadmins::checkAccess('ip_view');
		if($ipaccess) {
            $geo = array(
                'city' => 'N/А',
                'region' => 'Undefined',
                'country' => 'Undefined',
                'lat' => 0,
                'lng' => 0,
            );
			$get = @file_get_contents('http://ipgeobase.ru:7020/geo?ip=' . $model->player_ip);
            if($get) {
                $xml = @simplexml_load_string($get);
                if(!empty($xml->ip)) {
                    $geo['city'] = $xml->ip->city;
                    $geo['region'] = $xml->ip->region;
                    $geo['country'] = $xml->ip->country;
                    $geo['lat'] = $xml->ip->lat;
                    $geo['lng'] = $xml->ip->lng;
                }
            }
		}
		// История банов
		$history = new CActiveDataProvider('Bans', array(
			'criteria' => array(
				'condition' => '`bid` <> :hbid AND ((`player_ip` = :hip AND `player_ip` <> \'IP_LAN\') OR (`player_id` = :hid AND `player_id` <> \'STEAM_ID_LAN\'))',
				'params' => array(
					':hbid' => $id,
					':hip' => $model->player_ip,
					':hid' => $model->player_id
				),
			),
			'pagination' => array(
				'pageSize' => 5
			)
		));

		// Вывод всего на вьюху
		$this->render('view',array(
			'geo' => $geo,
			'ipaccess' => $ipaccess,
			'model'=>$model,
			'history' => $history
		));
	}

	/**
	 * Добавить бан
	 */
	public function actionCreate()
	{
		// Проверка прав
		if (!Webadmins::checkAccess('bans_add')) {
            throw new CHttpException(403, "You do not have enough rights");
        }
		
        $model=new Bans;

		// Аякс проверка формы
		$this->performAjaxValidation($model);

		if(isset($_POST['Bans'])) {
			$model->attributes=$_POST['Bans'];
			$model->admin_nick = Webadmins::GetName();
			$model->server_name = 'WEBSITE';
			if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->bid));
            }
        }

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Редактировать бан
	 * @param integer $id ID бана
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Проверка прав
		if (!Webadmins::checkAccess('bans_edit', $model->admin_nick)) {
            throw new CHttpException(403, "You do not have enough rights");
        }

        // Аякс проверка формы
		// $this->performAjaxValidation($model);

		// Сохраняем форму
		if(isset($_POST['Bans'])) {
			$model->attributes=$_POST['Bans'];
			if ($model->save()) {
                $this->redirect(array('view', 'id' => $model->bid));
            }
        }

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Удаление бана
	 * @param integer $id ID бана
	 */
	public function actionDelete($id)
	{
		$model = $this->loadModel($id);

		// Проверка прав
		if (!Webadmins::checkAccess('bans_delete', $model->admin_nick)) {
            throw new CHttpException(403, "You do not have enough rights");
        }

        $model->delete();
		// Если не аякс запрос, то редиректим
		if (!isset($_GET['ajax'])) {
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : '');
        }
    }

	/**
	 * Вывод всех банов
	 */
	public function actionIndex()
	{
		$model=new Bans('search');
		$model->unsetAttributes();
		if (isset($_GET['Bans'])) {
            $model->attributes = $_GET['Bans'];
        }

        $select = "((ban_created+(ban_length*60)) > UNIX_TIMESTAMP() OR ban_length = 0) AND `expired` = 0";

		$dataProvider=new CActiveDataProvider('Bans', array(
			'criteria'=>array(
				'condition' => Yii::app()->config->auto_prune
					?
				$select
					:
				null,
				'order' => '`ban_created` DESC',
            ),
			'pagination' => array(
				'pageSize' =>  Yii::app()->config->bans_per_page,

			),)
		 );

		// Проверяем IP посетителя, есть ли он в активных банах
		$check = Bans::model()->count(
			"`player_ip` = :ip AND " . $select,
			array(
				':ip'=> Prefs::getRealIp(),
			)
		);
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'model'=>$model,
			'check' => $check > 0 ? true : false,
		));

	}

	/**
	 * Управление банами (Хз, буду ли использовать)
	 */
	public function actionAdmin()
	{
		if (Yii::app()->user->isGuest) {
            throw new CHttpException(403, "You do not have enough rights");
        }

        $model=new Bans('search');
		$model->unsetAttributes();
		if (isset($_GET['Bans'])) {
            $model->attributes = $_GET['Bans'];
        }

        $this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Вывод данных о бане в модальке
	 */
	public function actionBandetail()
	{
		if(is_numeric($_POST['bid']))
		{
			$model = Bans::model()->findByPk($_POST['bid']);
			if($model === null)
			{
				Yii::app()->end('alert("Error!")');
			}
			
			$js = "$('#bandetail-nick').html('" .  CHtml::encode($model->player_nick) . "');";
			$js .= "$('#bandetail-steam').html('" . $model->player_id . "');";
			$js .= "$('#bandetail-steamcommynity').html('" . Prefs::steam_convert($model->player_id, true) . "');";
			$js .= "$('#bandetail-ip').html('" . (Webadmins::checkAccess('ip_view') ? $model->player_ip : 'Hidden') . "');";
			$js .= "$('#bandetail-type').html('" . Prefs::getBanType($model->ban_type) . "');";
			$js .= "$('#bandetail-reason').html('" . $model->ban_reason . "');";
			$js .= "$('#bandetail-datetime').html('" . date('d.m.y - H:i:s',$model->ban_created) . "');";
			$js .= "$('#bandetail-expired').html('" . ($model->ban_length == '-1'
					?
				'Unban'
					:
				Prefs::date2word($model->ban_length) .
				($model->expired == 1 ? ' (Expired)' : '')) . "');";
			$js .= "$('#bandetail-admin').html('" . $model->admin_nick . "');";
			$js .= "$('#bandetail-server').html('" . CHtml::encode($model->server_name) . "');";
			if( Yii::app()->config->show_kick_count || Webadmins::checkAccess('ip_view'))
				$js .= "$('#bandetail-kicks').html('" . $model->ban_kicks . "');";
			else
			$js .= "$('#bandetail-kicks').html('Hidden');";
			$js .= "$('#loading').hide();";
			$js .= "$('#viewban').attr({'href': '".Yii::app()->urlManager->createUrl('/bans/view', array('id' => $_POST['bid']))."'});";
			$js .= "$('#BanDetail').modal('show');";
			echo $js;
		}
		Yii::app()->end();
	}

	/**
	 * Загрузка модели по ID
	 * @param integer ID бана
	 */
	public function loadModel($id)
	{
		$model=Bans::model()->findByPk($id);
		if ($model === null) {
            throw new CHttpException(404, 'The requested page does not exist.');
        }
        return $model;
	}

	/**
	 * Аякс проверка формы
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='bans-form') {
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
}
