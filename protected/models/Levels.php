<?php
/**
 * @author Craft-Soft Team
 * @package CS:Bans
 * @version 1.0 beta
 * @copyright (C)2013 Craft-Soft.ru.  Все права защищены.
 * @link http://craft-soft.ru/
 * @license http://creativecommons.org/licenses/by-nc-sa/4.0/deed.ru  «Attribution-NonCommercial-ShareAlike»
 */

/**
 * Модель для таблицы "{{levels}}".
 *
 * Доступные поля таблицы '{{levels}}':
 * @property integer $level ID уровня (он же название)
 * @property string $bans_add
 * @property string $bans_edit
 * @property string $bans_delete
 * @property string $bans_unban
 * @property string $bans_import
 * @property string $bans_export
 * @property string $webadmins_view
 * @property string $webadmins_edit
 * @property string $websettings_view
 * @property string $websettings_edit
 * @property string $permissions_edit
 * @property string $prune_db
 * @property string $ip_view
 */
class Levels extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{levels}}';
	}

	public function rules()
	{
		return array(
			array('level', 'numerical', 'integerOnly'=>true),
			array('bans_add, bans_edit, bans_delete, bans_unban, bans_import, bans_export, webadmins_view, webadmins_edit, websettings_view, websettings_edit, permissions_edit, prune_db, ip_view', 'in', 'range' => array('yes', 'no', 'own')),
			array('level, bans_add, bans_edit, bans_delete, bans_unban, bans_import, bans_export, webadmins_view, webadmins_edit, websettings_view, websettings_edit, permissions_edit, prune_db, ip_view', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public function attributeLabels()
	{
		return array(
			'level' => 'Level',
			'bans_add' => 'Add Ban',
			'bans_edit' => 'Edit Ban',
			'bans_delete' => 'Delete Ban',
			'bans_unban' => 'Unban',
			'bans_import' => 'Import Ban',
			'bans_export' => 'Export Ban',
			'webadmins_view' => 'View WEB admins',
			'webadmins_edit' => 'Editing WEB admins',
			'websettings_view' => 'View Settings',
			'websettings_edit' => 'Editing Settings',
			'permissions_edit' => 'Editing WEB rights',
			'prune_db' => 'DB optimization',
			'ip_view' => 'IP viewing',
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('level',$this->level);
		$criteria->compare('bans_add',$this->bans_add,true);
		$criteria->compare('bans_edit',$this->bans_edit,true);
		$criteria->compare('bans_delete',$this->bans_delete,true);
		$criteria->compare('bans_unban',$this->bans_unban,true);
		$criteria->compare('bans_import',$this->bans_import,true);
		$criteria->compare('bans_export',$this->bans_export,true);
		$criteria->compare('webadmins_view',$this->webadmins_view,true);
		$criteria->compare('webadmins_edit',$this->webadmins_edit,true);
		$criteria->compare('websettings_view',$this->websettings_view,true);
		$criteria->compare('websettings_edit',$this->websettings_edit,true);
		$criteria->compare('permissions_edit',$this->permissions_edit,true);
		$criteria->compare('prune_db',$this->prune_db,true);
		$criteria->compare('ip_view',$this->ip_view,true);
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public static function getList() {
		$model = self::model()->findAll();

		$list = CHtml::listData($model, 'level', 'level');

		return $list;
	}

	public static function getValues($ban = FALSE)
	{
		$return = array(
			'yes' => 'Yes',
			'no' => 'No',
		);

		if($ban)
		{
			$return['own'] = 'Their';
		}

		return $return;
	}

	public function beforeSave() {
		parent::beforeSave();

		if($this->isNewRecord)
		{
			$oldlevel = $this->model()->findBySql("SELECT MAX(`level`) AS `level` FROM {{levels}}");
			$this->level =  $oldlevel->level + 1;
		}

		return TRUE;
	}

	public function afterSave() {
		if($this->isNewRecord)
			Syslog::add(Logs::LOG_ADDED, 'Added a new level of web admins');
		else
			Syslog::add(Logs::LOG_EDITED, 'Changed Web Admins Level # <strong>' . $this->level . '</strong>');
		return parent::afterSave();
	}

	public function afterDelete() {
		Syslog::add(Logs::LOG_DELETED, 'Removed Web Admin Level # <strong>' . $this->level . '</strong>');
		return parent::afterDelete();
	}
}