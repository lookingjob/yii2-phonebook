<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Contact extends ActiveRecord
{
    private $_phonesCount;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'contact';
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'birthday' => 'Birthday',
            'email' => 'Email',
            'contact_phones_count' => 'Phones count',
        ];
    }

    public function setPhonesCount($value)
    {
        $this->_phonesCount = $value;
    }

    public function getPhonesCount()
    {
        if ($this->_phonesCount === null) {
            $this->_phonesCount = ContactPhone::find()->where(['contact_id' => $this->id])->count();
        }
        return $this->_phonesCount;
    }

    /**
     * Adds "contact_phones_count" field to records if applicable.
     */
    /*public static function populateRecord($record, $row)
    {
        $columns = static::getTableSchema()->columns;

        foreach ($row as $name => $value)
        {
            if (isset($columns[$name]))
            {
                $row[$name] = $columns[$name]->phpTypecast($value);
            }
        }
        parent::populateRecord($record, $row);

        if (isset($row['contact_phones_count']))
        {
            $record->setAttribute('contact_phones_count', $row['contact_phones_count']);
        }
    }*/
}