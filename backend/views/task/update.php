<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Task */

$this->title = Yii::t('user', 'Update {modelClass}: ', [
    'modelClass' => 'Task',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Tasks'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id_task]];
$this->params['breadcrumbs'][] = Yii::t('user', 'Update');
?>
<div class="task-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
