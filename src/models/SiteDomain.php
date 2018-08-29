<?php

namespace ignatenkovnikita\domain\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "site_domain".
 *
 * @property integer $id ID
 * @property integer $site_id Site ID
 * @property string $name Name
 * @property integer $is_primary Is Primary
 *
     * @property Site $site
    */
class SiteDomain extends ActiveRecord
{


    /**
    * @inheritdoc
    */
    public static function tableName()
    {
        return 'site_domain';
    }

    /**
    * @inheritdoc
    */
    public function rules()
    {
        return [
            [['site_id', 'name'], 'required'],
            [['site_id', 'is_primary'], 'integer'],
            [['name'], 'string', 'max' => 255],
            [['site_id'], 'exist', 'skipOnError' => true, 'targetClass' => Site::className(), 'targetAttribute' => ['site_id' => 'id']],
        ];
    }

    /**
    * @inheritdoc
    */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('common', 'ID'),
            'site_id' => Yii::t('common', 'Site ID'),
            'name' => Yii::t('common', 'Name'),
            'is_primary' => Yii::t('common', 'Is Primary'),
            ];
    }


    /**
     * @inheritdoc
     * @return \common\models\generated\query\SiteDomainQuery the active query used by this AR class.
    */
    public static function find()
    {
        return new SiteDomainQuery(get_called_class());
    }
}
