<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use app\models\Contact;
use app\models\ContactPhone;
use app\models\ContactForm;

class ContactController extends Controller
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
     * Displays homepage.
     *
     * @return string
     */
    public function actionView()
    {
        // contact
        $query = \app\models\Contact::find()
            ->select('contact.id, contact.lastname, contact.firstname, contact_phone.phone, COUNT(contact_phone.phone) AS contact_phones_count')
            ->join('LEFT JOIN', 'contact_phone', 'contact_phone.contact_id = contact.id')
            ->where(['contact.id' => Yii::$app->request->get('id', 0)]);

        $contact = $query->one();

        if  (!$query->count())
        {
            throw new NotFoundHttpException;
        }

        // phones
        $query = ContactPhone::find()
            ->select('id, phone')
            ->where(['contact_id' => $contact->id]);

        $pagination = new Pagination([
            'totalCount'      => $query->count(),
            'defaultPageSize' => 10,
            'forcePageParam'  => false,
            'pageSizeLimit'   => 4,
        ]);

        $phones = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();



        return $this->render('index', [
            'contact'   => $contact,
            'phones' => $phones,
            'pagination' => $pagination
        ]);
    }

    /**
     * Displays edit page.
     */
    public function actionEdit()
    {
        // contact
        $contact = Contact::findOne(['id' => Yii::$app->request->get('id', 'integer')]);

        if  (!$contact)
        {
            throw new NotFoundHttpException;
        }

        // phones
        $query = ContactPhone::find()
            ->select('id, phone')
            ->where(['contact_id' => $contact->id]);

        $pagination = new Pagination([
            'totalCount'      => $query->count(),
            'defaultPageSize' => 1,
            'forcePageParam'  => false,
            'pageSizeLimit'   => 4,
        ]);

        $phones = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        return $this->render('edit', [
            'contact'   => $contact,
            'phones' => $phones,
            'pagination' => $pagination,
        ]);
    }

    /**
     * Save contact.
     */
    public function actionSave()
    {
        if (Yii::$app->request->isPost)
        {
            $formData = Yii::$app->request->post('Contact');

            $contact = $formData['id'] ? Contact::findOne(['id' => $formData['id']]) : new Contact();

            if ($contact->load(Yii::$app->request->post()) && $contact->validate())
            {
                foreach ($formData as $key => $value) {
                    $contact->$key = $value;
                }

                $contact->save();

                if (!$formData['id'])
                {
                    $contact->refresh();

                    $phone = new ContactPhone();

                    $phone->phone = $formData['phone'];
                    $phone->contact_id = $contact->id;

                    $phone->save();
                }

                return $this->redirect(['site/index']);
            }
            else
            {
                return $this->render('edit', [
                    'contact'   => $contact,
                ]);
            }
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }

    /**
     * Create contact.
     */
    public function actionCreate()
    {
        $contact = new Contact();

        return $this->render('edit', [
            'contact'   => $contact,
        ]);
    }

    /**
     * Delete contact.
     */
    public function actionDelete()
    {
        if (Yii::$app->request->isPost)
        {
            $contact = Contact::findOne(Yii::$app->request->get('id', 0));

            if  (!$contact)
            {
                throw new NotFoundHttpException;
            }

            ContactPhone::deleteAll(['contact_id' => $contact->id]);

            $contact->delete();

            return $this->redirect(['site/index']);
        }
        else
        {
            throw new NotFoundHttpException;
        }
    }
}
