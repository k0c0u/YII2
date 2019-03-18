<?php
namespace backend\models\search;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;
/**
 * UserSearch represents the model behind the search form of `common\models\User`.
 * @property mixed created_date
 * @property mixed updated_date
 * @property mixed created_date_end
 * @property mixed updated_date_end
 */
class UserSearch extends User
{
    /**
     * {@inheritdoc}
     *
     */
    public function rules() {
        return [
            [['id', 'status', 'created_at', 'updated_at'], 'integer'],
            [['username', 'auth_key', 'password_hash', 'password_reset_token', 'email', 'access_token', 'avatar', 'created_date', 'updated_date', 'created_date_end', 'updated_date_end'], 'safe'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
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
        $query = User::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
        ]);
        $query->andFilterWhere(['>=', 'created_at', $this->created_date ? strtotime($this->created_date . ' 00:00:00') : null]);
        $query->andFilterWhere(['<=', 'created_at', $this->created_date_end ? strtotime($this->created_date_end . ' 23:59:59') : null]);
        $query->andFilterWhere(['>=', 'updated_at', $this->updated_date ? strtotime($this->updated_date . ' 00:00:00') : null]);
        $query->andFilterWhere(['<=', 'updated_at', $this->updated_date_end ? strtotime($this->updated_date_end . ' 23:59:59') : null]);
        $query->andFilterWhere(['like', 'username', $this->username])
            ->andFilterWhere(['like', 'email', $this->email]);
        return $dataProvider;
    }
}