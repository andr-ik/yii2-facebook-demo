<?php

namespace common\components;

use Yii;
use yii\base\BootstrapInterface;
use yii\base\Configurable;

class Facebook extends \Facebook\Facebook implements Configurable, BootstrapInterface
{
	public function bootstrap($app){
		if($access_token = Yii::$app->session->get('access_token')){
			$this->setDefaultAccessToken($access_token);
		}
	}
}