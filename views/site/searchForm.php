<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $search \app\models\SearchForm */

?>

<div class="row">
    <div class="col-xs-12">
        <?php $form = ActiveForm::begin([
            'id' => 'search-form',
            'action' => ['index'],
            'method' => 'get',
            'fieldConfig' => [
                'template' => '{label}{input}<div>{error}</div>',
                'labelOptions' => ['class' => 'control-label'],
            ],
            'options' => [
                'class' => 'search',
            ]
        ]); ?>

        <?= $form->field($search, 'search')
            ->textInput(['id' => 'search', 'autofocus' => true, 'value' => $search->search])
            ->label(Yii::t('app', 'Search:'));
        ?>

        <div class="form-group">
            <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']); ?>
            <?= Html::a(Yii::t('app', 'Reset'), ['index'], ['class' => 'btn btn-default']) ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>