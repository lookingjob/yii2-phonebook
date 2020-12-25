<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $firstname;
    public $lastname;
    public $email;
    public $birthday;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $birthdayMax = new \DateTime();
        $birthdayMax->sub(new \DateInterval('P18Y'));

        return [
            [['firstname', 'birthday'], 'required'],
            ['email', 'email'],
            ['birthday', 'date', 'format' => 'Y-m-d', 'max' => $birthdayMax->format('Y-m-d')],
            ['phone', 'phoneValidation']
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
            'email' => 'Email',
            'birthday' => 'Birthday',
        ];
    }

    /**
     * Phone validation.
     */
    public function phoneValidation()
    {
        //if (!$this->id && )
    }
}
