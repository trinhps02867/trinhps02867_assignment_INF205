<?php

namespace app\models\line;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\vehicle\Vehicle */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="vehicle-form">

    <?php $form = ActiveForm::begin();?>

    <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'capacity')->textInput()?>

    <?=$form->field($model, 'type')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'line_id')->dropDownList(
	ArrayHelper::map(Line::find()->all(), 'id', 'code'), ['prompt' => 'Select Vehicle']
)?>

    <div class="form-group">
        <?=Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
