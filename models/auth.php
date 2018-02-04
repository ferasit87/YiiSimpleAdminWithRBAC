<?php
namespace app\models;

use yii\db\ActiveRecord;

class Auth extends ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'auth';
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'source', 'source_id'], 'required'],
            [['user_id'], 'integer'],
            [['source', 'source_id'], 'string', 'max' => 255]
        ];
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

}
