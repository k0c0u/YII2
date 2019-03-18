<?php
namespace common\models\search;
use common\models\Project;
use common\models\User;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Task;
/**
 * TaskSearch represents the model behind the search form of `common\models\Task`.
 */
class TaskSearch extends Task
{
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'project_id', 'executor_id', 'started_at', 'completed_at', 'creator_id', 'updater_id', 'created_at', 'updated_at'], 'integer'],
            [['title', 'description'], 'safe'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function scenarios() {

        return Model::scenarios();
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params) {
        $query = Task::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {

            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'project_id' => $this->project_id,
            'executor_id' => $this->executor_id,
            'started_at' => $this->started_at,
            'completed_at' => $this->completed_at,
            'creator_id' => $this->creator_id,
            'updater_id' => $this->updater_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);
        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description]);
        return $dataProvider;
    }
}