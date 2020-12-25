<?php namespace backend\models;

use common\models\Content;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "image_type".
 *
 * @property int $id
 * @property string $name
 * @property int $multiple
 * @property string $folder
 * @property string $template
 * @property string $alt
 * @property string $title
 */
class ImageType extends ActiveRecord {

    public static function tableName() { return 'image_type'; }

    public function rules() {
        return [
            [['name', 'multiple', 'folder', 'template'], 'required'],
            [['multiple'], 'integer'],
            [['name', 'folder', 'template'], 'string', 'max' => 255],
        ];
    }

    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'multiple' => 'Multiple',
            'folder' => 'Folder',
            'template' => 'Template',
        ];
    }

    const IS_MULTIPLE = 1;

    public static $counter = [];

//    public static $buildingMaterials;
//    public static $photo;
//    public static $photoCherkassy;
//    public static $buildingMaterialsTeam;

    public static function getMinWidth($typeID) {
        return ImageTypeOption::find()->select(['width'])->where([
            'type_id' => $typeID
        ])->orderBy(['width' => SORT_DESC])->limit(1)->scalar();
    }

    public static function getImageMetadata($image) {
        $alt = $title = [];
        if ($imageType = self::findOne($image->type)) {
//            self::$buildingMaterials = Yii::t('app', 'строительные материалы');
//            self::$photo = Yii::t('app', 'фото');
//            self::$photoCherkassy = Yii::t('app', 'фото Черкассы');
//            self::$buildingMaterialsTeam = Yii::t('app', 'Команда базы строительных материалов Вилла Терра');
            isset(self::$counter[$imageType->id]) ? self::$counter[$imageType->id]++ : self::$counter[$imageType->id] = 1;
            if ($altTemplate = json_decode($imageType->alt)) {
                foreach ($altTemplate as $item) {
                    switch ($item) {
//                        case '{buildingMaterials}': $alt[] = self::$buildingMaterials; break;
//                        case '{photo}': $alt[] = self::$photo; break;
//                        case '{photoCherkassy}': $alt[] = self::$photoCherkassy; break;
//                        case '{buildingMaterialsTeam}': $alt[] = self::$buildingMaterialsTeam; break;
                        case '{n}': $alt[] = self::$counter[$imageType->id]; break;
                        default: if (strpos($item, 'content') !== false) {
                            list($model, $field, $contentTypeID) = explode('|', str_replace(['{', '}'], '', $item));
                            $alt[] = Content::get($contentTypeID, $image->$field);
                        }
                            break;
                    }
                }
            }
            if ($titleTemplate = json_decode($imageType->title)) {
                foreach ($titleTemplate as $item) {
                    switch ($item) {
                        default: if (strpos($item, 'content') !== false) {
                            list($model, $field, $contentTypeID) = explode('|', str_replace(['{', '}'], '', $item));
                            $title[] = Content::get($contentTypeID, $image->$field);
                        }
                            break;
                    }
                }
            }
        }
        return [count($alt) ? implode(' ', $alt) : false, count($title) ? implode(' ', $title) : false];
    }
}
