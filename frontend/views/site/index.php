<?php

/* @var $this yii\web\View */
/* @var $facebookPhotosDataProvider \common\components\FacebookPhotosDataProvider */

$this->title = 'My Yii Application';
?>
<div class="site-index">
    <?php echo \yii\widgets\ListView::widget([
        'dataProvider' => $facebookPhotosDataProvider,
        'itemView' => function($model, $key, $index, $widget){
            $image = array_pop($model['images']);
            return \yii\bootstrap\Html::img($image['source'], [
                'alt' => 'photo-id'.$key,
                'width' => $image['width'],
                'height' => $image['height']
            ]);
        }
    ]); ?>
</div>
