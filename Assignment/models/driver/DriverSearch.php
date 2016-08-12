<?php

namespace app\models\driver;

use app\models\driver\driver;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DriverSearch represents the model behind the search form about `app\models\driver\driver`.
 */
class DriverSearch extends driver {
	/**
	 * @inheritdoc
	 */
	public function rules() {
		return [
			[['id', 'vehicle_id'], 'integer'],
			[['name', 'birth_date', 'birth_place', 'email', 'phone', 'avatar', 'type'], 'safe'],
		];
	}

	/**
	 * @inheritdoc
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
		$query = driver::find();

		// add conditions that should always apply here

		$dataProvider = new ActiveDataProvider([
			'query' => $query,
			'pagination' => [
				'pageSize' => 10,
			],
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
			'birth_date' => $this->birth_date,
			'vehicle_id' => $this->vehicle_id,
		]);

		$query->andFilterWhere(['like', 'name', $this->name])
			->andFilterWhere(['like', 'birth_place', $this->birth_place])
			->andFilterWhere(['like', 'email', $this->email])
			->andFilterWhere(['like', 'phone', $this->phone])
			->andFilterWhere(['like', 'avatar', $this->avatar])
			->andFilterWhere(['like', 'type', $this->type]);

		return $dataProvider;
	}
}
