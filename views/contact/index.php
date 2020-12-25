<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $contact \app\models\Contact */
/* @var $phones \app\models\ContactPhone */
/* @var $pagination yii\data\Pagination */

$this->title = $contact->firstname . ' ' . $contact->lastname;
?>
<div class="container">

    <h2>
        <?= $this->title, ' <span class="badge">', $contact->getPhonesCount(), '</span>' ?>
        <?= Html::a(Yii::t('app', 'Edit'), ['contact/edit', 'id' => $contact->id], ['class' => 'btn btn-default']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['contact/delete', 'id' => $contact->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]); ?>
    </h2>

    <div class="row">
        <div class="col-xs-3">
            <?= Html::input('text', null, null, ['id' => 'phone-add', 'class' => 'form-control']); ?>
        </div>
        <div class="col-xs-3">
            <?= Html::a(Yii::t('app', 'Add phone number'), ['phone/add'], [
                'id' => 'btn-phone-add',
                'class' => 'btn btn-default',
                'data' => [
                    'contact-id' => $contact->id,
                ]
            ]); ?>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="contact-phones">
            <?php foreach($phones as $k => $phone):?>
                <div class="row">
                    <div class="col-xs-3">
                        <?= $phone->phone?>
                    </div>
                    <div class="col-xs-3">
                        <?= Html::a(Yii::t('app', 'Delete'), ['phone/delete', 'id' => $phone->id], [
                            'class' => 'btn btn-default btn-phone-delete',
                            'data' => [
                                'id' => $phone->id,
                            ],
                        ]); ?>
                    </div>
                </div>
            <?php endforeach ?>
            </div>
        </div>
    </div>

    <?php
    $urlToDelete = Yii::$app->getUrlManager()->createUrl('phone/delete');

    $urlToAdd = Yii::$app->getUrlManager()->createUrl('phone/add');

    $script = <<<JS
        jQuery(document).ready(function () {
            $('.btn-phone-delete').click(function (e) {
                e.preventDefault();
                
                if (!confirm('Are you sure you want to delete this?')) return false;

                var btn = $(this);
                
                $.ajax({
                    type: 'post',
                    url: '$urlToDelete',
                    dataType: 'json',
                    data: {
                        id: btn.data('id')
                    },
                    success: function (response) {
                        if (response.result) {
                            document.location.reload();
                            return false;
                        } else {
                            alert(response.errors[0]);
                        }
                    },
                    error: function (exception) {
                        alert('Error while deleting phone number');
                    }
                })
            });
            
            $('#btn-phone-add').click(function (e) {
                e.preventDefault();

                var btn = $(this), input = $('input#phone-add');
                
                $.ajax({
                    type: 'post',
                    url: '$urlToAdd',
                    dataType: 'json',
                    data: {
                        contact_id: btn.data('contact-id'),
                        phone: input.val()
                    },
                    success: function (response) { 
                        if (response.result) { 
                            document.location.reload();
                            return false;
                        } else {
                            alert(response.errors.phone);
                        }
                    },
                    error: function (exception) {
                        alert('Error while adding phone number');
                    }
                })
            });
        });
JS;

    $this->registerJs($script, yii\web\View::POS_END);
    ?>

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
