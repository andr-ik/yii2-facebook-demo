<?php

namespace common\components;

use Yii;
use yii\data\BaseDataProvider;

class FacebookPhotosDataProvider extends BaseDataProvider
{
	public $get =  '/photos/uploaded';
	public $fields = ['images'];

	private $_photos = [];
	private $_user_id = null;

	public function init() {
		$this->_user_id = Yii::$app->user->identity->getId();
		parent::init();
	}

	protected function prepareModels(){
		return $this->getPhotos();
	}

	protected function prepareKeys($models){
		return array_map(function($model){
			return $model['id'];
		}, $models);
	}

	protected function prepareTotalCount(){
		return count($this->getPhotos());
	}

	private function getPhotos(){
		if(!Yii::$app->user->isGuest){
			if(empty($this->_photos)){
				$get = '/'.$this->_user_id.$this->get.'?fields='.implode(',',$this->fields);
				$this->_photos = Yii::$app->facebook->get($get)->getDecodedBody()['data'];
			}
			return $this->_photos;
		}else{
			return null;
		}
	}
}