<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;
use app\models\ContactForm;
use kartik\datecontrol\DateControl;
use kartik\date\DatePicker;

/* @var $this yii\web\View */
/* @var $contact \app\models\Contact */

?>

<div class="row">
    <div class="col-xs-12">
        <?php $form = ActiveForm::begin([
            'id' => 'contact-form',
            'action' => ['contact/save', 'id' => $contact->id],
            'method' => 'post',
            'fieldConfig' => [
                'template' => '{label}{input}<div>{error}</div>',
                'labelOptions' => ['class' => 'control-label'],
            ],
            'options' => [
                'class' => 'search',
            ]
        ]); ?>

        <?= $form->field($contact, 'id')
            ->hiddenInput(['value'=> $contact->id])
            ->label(false); ?>

        <?= $form->field($contact, 'firstname')
            ->textInput(['id' => 'firstname', 'autofocus' => true])
            ->label(Yii::t('app', 'Firstname:')); ?>

        <?= $form->field($contact, 'lastname')
            ->textInput(['id' => 'lastname'])
            ->label(Yii::t('app', 'Lastname:')); ?>

        <?= $form->field($contact, 'email')
            ->textInput(['id' => 'email'])
            ->label(Yii::t('app', 'Email:')); ?>

        <?= $form->field($contact, 'birthday')
            ->widget(DateControl::classname(), [
                'displayFormat' => 'php:Y-m-d',
                'saveFormat' => 'php:Y-m-d',
                'type' => DateControl::FORMAT_DATE,
                'pluginOptions' => [
                    'autoclose' => true
                ]]); ?>

        <?php if (!$contact->id): ?>
        <?= $form->field($contact, 'phone')
            ->textInput(['id' => 'phone'])
            ->label(Yii::t('app', 'Phone number:')); ?>
        <?php endif ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Save'), ['class' => 'btn btn-primary']); ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>