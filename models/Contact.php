<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;

class Contact extends ActiveRecord
{
    private $_phonesCount;
    private $_phone;

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
    public function rules()
    {
        $birthdayMax = new \DateTime();
        $birthdayMax->sub(new \DateInterval('P18Y'));

        return [
            [['firstname', 'birthday'], 'required'],
            ['email', 'email'],
            ['birthday', 'date', 'format' => 'Y-m-d', 'max' => $birthdayMax->format('Y-m-d')],
            ['phone', 'required', 'when' => function ($model, $attribute) {
                if (!$model->id) return true;
            }, 'whenClient' => "function (attribute, value) { console.log(value,/^(\+38)?[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}$/g.test(value));
                return $('#phone').length;
            }"],
            ['phone', 'match', 'pattern' => '/^(\+38)?[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}$/', 'message' => 'Wrong phone number', 'when' => function ($model, $attribute) {
                if (!$model->id) return true;
            }, 'whenClient' => "function (attribute, value) { console.log(value,/^(\+38)?[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}$/g.test(value));
                return $('#phone').length;
            }"],
        ];
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

    /**
     * Set phones count.
     */
    public function setPhonesCount($value)
    {
        $this->_phonesCount = $value;
    }

    /**
     * Get phones count.
     * @return integer
     */
    public function getPhonesCount()
    {
        if ($this->_phonesCount === null) {
            $this->_phonesCount = ContactPhone::find()->where(['contact_id' => $this->id])->count();
        }
        return $this->_phonesCount;
    }

    /**
     * Set phone.
     */
    public function setPhone($value)
    {
        $this->_phone = $value;
    }

    /**
     * Get phone.
     * @return string
     */
    public function getPhone()
    {
        return $this->_phone;
    }

    /**
     * Phone validation.
     */
    public function phoneValidation($attribute, $params)
    {
        if (!$this->id && !preg_match('/^(\+38)?[0-9]{3}[0-9]{3}[0-9]{2}[0-9]{2}$/', $this->$attribute)) {
            $this->addError($attribute, 'Phone number must not be empty');
        }
    }
}