<?php
/**
 * Created by Ivanoff.
 * User: Ivanoff
 * Date: 13.07.2017
 * Time: 19:18
 */

namespace api\controllers;


use common\models\Task;
use common\models\TaskSearch;
use yii\rest\ActiveController;
use Yii;

class TaskController extends ActiveController
{
    /**
     * @var string
     */
    public $updateScenario = Task::SCENARIO_CHANGE_STATUS;
    /**
     * @var string
     */
    public $modelClass = 'common\models\Task';


    /**
     * @inheritdoc
     */
    public function actions()
    {
        $parent = parent::actions();
        unset($parent['create'], $parent['delete']);
        return array_merge($parent, [
            'index' => [
                'class' => 'yii\rest\IndexAction',
                'modelClass' => $this->modelClass,
                'checkAccess' => [$this, 'checkAccess'],
                'prepareDataProvider' =>  function ($action) {
                    $this->modelClass = TaskSearch::className();
                    $searchModel = new TaskSearch([
                        'scenario' => TaskSearch::SCENARIO_API,
                    ]);

                    return $searchModel->search(['TaskSearch' => Yii::$app->request->queryParams]);
                }
            ],
        ]);
    }
}
