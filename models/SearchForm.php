<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * SearchForm is the model behind the search form.
 *
 */
class SearchForm extends Model
{
    public $search;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            ['search', 'string', 'min' => 3, 'max' => 128],
        ];
    }
}
