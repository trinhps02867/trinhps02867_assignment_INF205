<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\driver\DriverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Drivers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="driver-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Driver', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

//            'id',
            'name',
            'birth_date',
            'birth_place',
            'email:email',
            // 'phone',
             'avatar',
//            [
//                'label' => 'avatar',
//                'value' => 'public/images/upload/avatar/' . $model->avatar,
//                'format' => ['image',['width' => '100', 'height' => '100']],
//            ],
             'type',
             'vehicle_id',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
