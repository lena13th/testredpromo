<?php

namespace app\models;

use app\components\CityWidget;
use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $date
 * @property string $text
 * @property int $public
 * @property int $favorites
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'text'], 'required'],
            [['date'], 'safe'],
            [['public', 'favorites'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['description'], 'string', 'max' => 1024],
            [['text'], 'string', 'max' => 9999],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'description' => 'Description',
            'date' => 'Date',
            'text' => 'Text',
            'public' => 'Public',
            'favorites' => 'Favorites',
        ];
    }
    public function getRelatedNews()
    {
        $city_id = CityWidget::widget(['object'=>'id']);

        return $this->hasMany(News::className(), ['id' => 'id_related_news'])
            ->viaTable('related_news', ['id_news' => 'id'])
            ->innerJoinWith('cities')
            ->where(['cities.id' => $city_id])
            ->limit(3);
    }
    public function getCities()
    {
        return $this->hasMany(Cities::className(), ['id' => 'id_city'])
            ->viaTable('city_news', ['id_news' => 'id']);
    }

}
