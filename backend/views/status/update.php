<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Status */

$this->title = Yii::t('user', 'Update {modelClass}: ', [
    'modelClass' => 'Status',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Statuses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id_status]];
$this->params['breadcrumbs'][] = Yii::t('user', 'Update');
?>
<div class="status-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
