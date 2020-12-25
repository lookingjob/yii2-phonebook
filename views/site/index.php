<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $search \app\models\SearchForm */
/* @var $contacts \app\models\Contact */
/* @var $phoneQuery yii\data\ActiveDataProvider */
/* @var $phoneProvider yii\data\ActiveDataProvider */
/* @var $pagination yii\data\Pagination */

$this->title = 'Phonebook';
?>
<div class="container">

    <?= $this->render('searchForm', ['search' => $search]) ?>

    <div class="row">
        <div class="col-xs-12">
            <ul class="list-group">
                <?php foreach($contacts as $k => $contact):?>
                <li class="list-group-item contact">
                    <span class="badge"><?= $contact->getPhonesCount() ?></span>
                    <?= Html::a("{$contact->firstname} {$contact->lastname}", ['contact/view', 'id' => $contact->id]) ?>
                </li>
                <?php endforeach?>
            </ul>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <?= Html::a(Yii::t('app', 'New contact'), ['contact/create'], ['class' => 'btn btn-primary']) ?>
        </div>
    </div>

    <?php if( LinkPager::widget(['pagination' => $pagination]) ): ?>
        <div class="row">
            <div class="col-xs-12">

                <?= LinkPager::widget([
                    'pagination' => $pagination,
                    'prevPageLabel' => false,
                    'nextPageLabel' => false,
                    'options' => [
                        'class' => 'pagination'
                    ],
                    'pageCssClass'       => 'button button-positive',
                    'activePageCssClass' => 'button button-disabled',
                ]); ?>
            </div>
        </div>
    <?php endif ?>

</div>