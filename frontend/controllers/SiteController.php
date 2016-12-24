<?php
namespace frontend\controllers;

use common\components\FacebookPhotosDataProvider;
use common\models\User;
use Yii;
use yii\bootstrap\Html;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index', [
        	'facebookPhotosDataProvider' => new FacebookPhotosDataProvider([
        		'pagination' => [
			        'pageSize' => 2,
		        ],
	        ])
        ]);
    }

    public function actionLogin()
    {
	    Yii::$app->session->open();

	    $redirect_url = Url::home(true).'site/login';
	    $facebookRedirectLoginHelper = Yii::$app->facebook->getRedirectLoginHelper();

        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        if($accessToken = $facebookRedirectLoginHelper->getAccessToken($redirect_url)){
	        $me = Yii::$app->facebook->get('/me', $accessToken)->getGraphUser();

	        /** @var User $user */
	        $user = new User();
	        $user->id = $me->getId();
	        $user->name = $me->getName();
	        $user->accessToken = $accessToken->getValue();

	        Yii::$app->user->login($user, 3600 * 24 * 30);
	        Yii::$app->session->set('access_token', $user->accessToken);

	        return $this->goHome();
        }

	    return Html::a('Войти с facebook', $facebookRedirectLoginHelper->getLoginUrl($redirect_url, [
		    'email',
		    'user_photos'
	    ]));
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();
        return $this->goHome();
    }
}
