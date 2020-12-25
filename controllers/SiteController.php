<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use yii\data\Pagination;
use yii\data\ActiveDataProvider;
use app\models\SearchForm;
use app\models\ContactPhone;

class SiteController extends Controller
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
    public function actionIndex()
    {
        $search = new SearchForm();
        $search->load(Yii::$app->request->get());

        // contacts
        $query = \app\models\Contact::find()
            ->select('contact.id, contact.lastname, contact.firstname, contact_phone.phone, COUNT(contact_phone.phone) AS contact_phones_count')
            ->join('LEFT JOIN', 'contact_phone', 'contact_phone.contact_id = contact.id');

        if (!$search->hasErrors())
        {
            $query->where(['or', "firstname LIKE '%{$search->search}%'", "lastname LIKE '%{$search->search}%'", "phone LIKE '%{$search->search}%'"]);
        }

        $query->groupBy('lastname, firstname')
            ->orderBy(['lastname' => SORT_ASC, 'firstname' => SORT_ASC]);

        $pagination = new Pagination([
            'totalCount'      => $query->count(),
            'defaultPageSize' => 10,
            'forcePageParam'  => false,
            'pageSizeLimit'   => 4,
        ]);

        $contacts = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();

        // phones
        $phoneQuery = ContactPhone::find();

        $phoneProvider = new ActiveDataProvider([
            'query' => $phoneQuery,
        ]);

        return $this->render('index', [
            'search'     => $search,
            'contacts'   => $contacts,
            'phoneQuery' => $phoneQuery,
            'phoneProvider' => $phoneProvider,
            'pagination' => $pagination
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }
}
