<?php

namespace app\models\vehicle;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\line\Line */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="line-form">

    <?php $form = ActiveForm::begin();?>

    <?=$form->field($model, 'code')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'start_time_operation')->textInput()?>

    <?=$form->field($model, 'end_time_operation')->textInput()?>

    <?=$form->field($model, 'type')->dropDownList(
	ArrayHelper::map(Vehicle::find()->all(), 'type', 'type'), ['prompt' => 'Select Type']
)?>

    <?=$form->field($model, 'map')->textInput(['maxlength' => true])?>

    <div class="form-group">
        <?=Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
