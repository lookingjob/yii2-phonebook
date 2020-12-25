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
            <?php foreach($contacts as $k => $contact):?>
            <div class="contact">
                <h2><?php echo $contact->firstname, ' ', $contact->lastname, ' <span class="badge">', $contact->getPhonesCount()'</span>' : '' ?> <?= Html::a(Yii::t('app', 'Edit'), ['contact/edit', 'id' => $contact->id], ['class' => 'btn btn-default']) ?></h2>
                <ul class="list-group contact-phones">
                <?php $phoneQuery->andFilterWhere(['contact_id' => $contact->id])->andFilterWhere(['like', 'phone', $search->search]); ?>
                <?php if ($phoneQuery->count()):?>
                    <?php foreach($phoneProvider->getModels() as $k => $phone):?>
                    <li class="list-group-item contact-phone"><?= $phone->phone?></li>
                    <?php if ($k >= 3):?>
                    <li class="list-group-item">...</li>
                    <?php endif ?>
                    <?php endforeach ?>
                <?php endif ?>
                </ul>
            </div>
            <?php endforeach?>
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
