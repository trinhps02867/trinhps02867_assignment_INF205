<?php
namespace app\models\vehicle;

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
//use backend\models\vehicle;

/* @var $this yii\web\View */
/* @var $model app\models\driver\driver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="driver-form">

    <?php $form = ActiveForm::begin();?>

    <?=$form->field($model, 'name')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'birth_date')->textInput()?>

    <?=$form->field($model, 'birth_place')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'email')->textInput(['maxlength' => true])?>

    <?=$form->field($model, 'phone')->textInput(['maxlength' => true])?>

<!--    --><?php //echo $form->field($model, 'avatar')->textInput(['maxlength' => true]) ?>

    <?php echo $form->field($model, 'avatar')->fileInput() ?>

    <?=$form->field($model, 'type')->dropDownList(
	ArrayHelper::map(Vehicle::find()->all(), 'type', 'type'), ['prompt' => 'Select Type']
)?>

    <?=$form->field($model, 'vehicle_id')->dropDownList(
	ArrayHelper::map(vehicle::find()->all(), 'id', 'name'), ['prompt' => 'Select Vehicle']
)?>

    <div class="form-group">
        <?=Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
