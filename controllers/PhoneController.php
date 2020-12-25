<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\Url;
use app\models\Contact;
use app\models\ContactPhone;

class PhoneController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ]
        ];
    }

    /**
     * Add new phone.
     */
    public function actionAdd()
    {
        $response['result'] = false;

        if (Yii::$app->request->isPost)
        {
            $phone = new ContactPhone();

            $phone->phone = Yii::$app->request->post('phone', '');
            $phone->contact_id = Yii::$app->request->post('contact_id', '');

            if ($phone->validate()) {
                $phone->save();

                $response['result'] = true;
            }
            else
            {
                $response['errors'] = $phone->errors;
            }
        }

        return \yii\helpers\Json::encode($response);
    }

    /**
     * Delete phone.
     */
    public function actionDelete()
    {
        $errors = [];

        if (Yii::$app->request->isPost)
        {
            $phone = ContactPhone::findOne(Yii::$app->request->post('id', 0));

            if  (!$phone)
            {
                $errors[] = 'Error phone number id';
            }

            if (empty($errors) && ContactPhone::find()->where(['contact_id' => $phone->contact_id])->count() > 1)
            {
                $phone->delete();

                $response['result'] = true;
            }
            else
            {
                $errors[] = 'Contact must have at least one phone number';
            }
        }
        else
        {
            $errors[] = 'Wrong request';
        }

        if (!empty($errors))
        {
            $response['errors'] = $errors;
        }

        return \yii\helpers\Json::encode($response);
    }
}
