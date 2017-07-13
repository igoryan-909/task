<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Task;

/**
 * TaskSearch represents the model behind the search form about `common\models\Task`.
 */
class TaskSearch extends Task
{
    const SCENARIO_API = 'scenarionApi';


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_task', 'created_at', 'updated_at', 'deadline', 'fk_status'], 'integer'],
            [['name', 'description', 'fkStatus.name'], 'safe'],
        ];
    }

    public function attributes()
    {
        return array_merge(parent::attributes(), ['fkStatus.name']);
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return array_merge(Model::scenarios(), [
            self::SCENARIO_API => ['id_task', 'name', 'created_at', 'updated_at', 'deadline', 'fkStatus.name'],
        ]);
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Task::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->joinWith(['fkStatus']);
        $dataProvider->sort->attributes['fkStatus.name'] = [
            'asc' => ['status.name' => SORT_ASC],
            'desc' => ['status.name' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id_task' => $this->id_task,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deadline' => $this->deadline,
            'fk_status' => $this->fk_status,
        ]);

        $query->andFilterWhere(['like', 'task.name', $this->name])
            ->andFilterWhere(['like', 'description', $this->description]);

        $query->andFilterWhere(['ILIKE', 'status.name', $this->getAttribute('fkStatus.name')]);

        return $dataProvider;
    }
}
