<?php

return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
	    'facebook' => [
	    	'class' => 'common\components\Facebook',
		    'app_id' => '1828379237436602',
		    'app_secret' => '5d67ce79ee4f786334e6af9e41a3d41e',
			'default_graph_version' => 'v2.8',
	    ],
    ],
];
