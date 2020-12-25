<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class ContactPhone extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact_phone';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $birthdayMax = new \DateTime();
        $birthdayMax->sub(new \DateInterval('P18Y'));

        return [
            [['contact_id', 'phone'], 'required'],
            ['phone', 'match', 'pattern' => '/^(\+38)?[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}$/', 'message' => 'Wrong phone number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'phone' => 'Phone',
        ];
    }
}