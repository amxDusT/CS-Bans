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
 * Модель для таблицы "{{webconfig}}".
 *
 * Доступные поля таблицы '{{webconfig}}':
 * @property integer $id
 * @property string $cookie
 * @property integer $bans_per_page
 * @property string $design
 * @property string $banner
 * @property string $banner_url
 * @property string $default_lang
 * @property string $start_page
 * @property integer $show_comment_count
 * @property integer $show_demo_count
 * @property integer $show_kick_count
 * @property integer $demo_all
 * @property integer $comment_all
 * @property integer $use_capture
 * @property integer $max_file_size
 * @property string $file_type
 * @property integer $auto_prune
 * @property integer $max_offences
 * @property string $max_offences_reason
 * @property integer $use_demo
 * @property integer $use_comment
 */
class Webconfig extends CActiveRecord
{
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	public function tableName()
	{
		return '{{webconfig}}';
	}

	public function rules()
	{
		return array(
			array('cookie, bans_per_page', 'required'),
			array('bans_per_page, show_kick_count, auto_prune, use_capture', 'numerical', 'integerOnly'=>true),
			array('cookie, design, default_lang', 'length', 'max'=>32),
			array('banner, start_page', 'length', 'max'=>64),
			array('banner_url', 'length', 'max'=>128),
			array('bans_per_page, design, banner, banner_url, default_lang, start_page, show_kick_count, auto_prune, use_capture', 'safe', 'on'=>'search'),
		);
	}

	public function relations()
	{
		return array(
		);
	}

	public static function getCfg() {

		$cache = Yii::app()->cache->get('web_cfg');

		if($cache === FALSE) {

			$cache = self::model()->find();
			Yii::app()->cache->set('web_cfg', $cache, 21600);
		}

		return $cache;
	}

	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'cookie' => 'reason for the ban from the site',
			'bans_per_page' => 'bans per page',
			'design' => 'Template',
			'banner' => 'Banner',
			'banner_url' => 'Banner link',
			'default_lang' => 'Language',
			'start_page' => 'Start Page',
			'show_kick_count' => 'Show Kicks',
			'use_capture' => 'Display city',
			'auto_prune' => 'Hide expired bans'
		);
	}

	public function search()
	{
		$criteria=new CDbCriteria;

		$criteria->compare('bans_per_page',$this->bans_per_page);
		$criteria->compare('design',$this->design,true);
		$criteria->compare('banner',$this->banner,true);
		$criteria->compare('banner_url',$this->banner_url,true);
		$criteria->compare('default_lang',$this->default_lang,true);
		$criteria->compare('start_page',$this->start_page,true);
		$criteria->compare('use_capture',$this->use_capture);
		$criteria->compare('auto_prune',$this->auto_prune);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function afterSave() {
		if(!$this->isNewRecord) {
			Syslog::add(Logs::LOG_EDITED, 'Site settings changed');
		}

		Yii::app()->cache->delete('web_cfg');

		return parent::afterSave();
	}
}