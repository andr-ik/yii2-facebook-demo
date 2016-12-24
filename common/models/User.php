<?php
namespace common\models;

use Yii;
use yii\base\Model;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property string|integer $id
 * @property string $name
 * @property string $accessToken
 */
class User extends Model implements IdentityInterface {
	public $id;
	public $name;
	public $accessToken;

	public function rules() {
		return [
			[ [ 'accessToken' ], 'require' ],
		];
	}

	public static function findIdentity($id){
		$access_token = Yii::$app->session->get('access_token');
		if(!$access_token){
			return null;
		}

		$me = Yii::$app->facebook->get('/me', $access_token)->getGraphUser();

		$user = new self;
		$user->id = $me->getId();
		$user->name = $me->getName();
		$user->accessToken = $access_token;

		return $user;
	}

	public static function findIdentityByAccessToken($token, $type = null){
		$me = Yii::$app->facebook->get( '/me', $token )->getGraphUser();

		$user = new self;
		$user->id = $me->getId();
		$user->name = $me->getName();
		$user->accessToken = $token;

		return $user;
	}

	public function getId(){
		return $this->id;
	}

	public function getAuthKey(){
		return false;
	}

	public function validateAuthKey( $authKey ){
		return false;
	}
}
