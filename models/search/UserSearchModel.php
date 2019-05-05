<?php

namespace app\models\search;

use app\models\activeRecord\User;
use yii\data\ActiveDataProvider;

/**
 * Class UserSearchModel
 * @package app\models\search
 */
class UserSearchModel extends User
{
    public function getDataProvider(): ActiveDataProvider
    {
        $query = self::find()->orderBy(['score' => SORT_DESC]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->pagination->pageSize = 10;

        return $dataProvider;
    }

    public static function tableName()
    {
        return 'user';
    }


}