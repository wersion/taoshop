<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "{{%article}}".
 *
 * @property integer $id
 * @property integer $cat_id
 * @property string $title
 * @property string $content
 * @property string $author
 * @property string $author_email
 * @property string $keywords
 * @property integer $article_type
 * @property integer $is_open
 * @property string $file_url
 * @property integer $open_type
 * @property string $link
 * @property string $description
 * @property integer $create_time
 */
class Article extends \common\component\ActiveRecordD
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%article}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cat_id', 'article_type', 'is_open', 'open_type', 'create_time'], 'integer'],
            [['title', 'content', 'keywords', 'is_open'], 'required'],
            [['content'], 'string'],
            [['title'], 'string', 'max' => 150],
            [['author'], 'string', 'max' => 30],
            [['author_email'], 'string', 'max' => 60],
            [['keywords', 'file_url', 'link', 'description'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cat_id' => Yii::t('app', 'Cat ID'),
            'title' => Yii::t('app', 'Title'),
            'content' => Yii::t('app', 'Content'),
            'author' => Yii::t('app', 'Author'),
            'author_email' => Yii::t('app', 'Author Email'),
            'keywords' => Yii::t('app', 'Keywords'),
            'article_type' => Yii::t('app', 'Article Type'),
            'is_open' => Yii::t('app', 'Is Open'),
            'file_url' => Yii::t('app', 'File Url'),
            'open_type' => Yii::t('app', 'Open Type'),
            'link' => Yii::t('app', 'Link'),
            'description' => Yii::t('app', 'Description'),
            'create_time' => Yii::t('app', 'Create Time'),
        ];
    }
}
