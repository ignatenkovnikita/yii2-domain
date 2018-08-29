<?php

namespace ignatenkovnikita\domain\models;

use yii\db\ActiveQuery;

/**
 * This is the ActiveQuery class for [[\common\models\generated\models\SiteDomain]].
 *
 * @see \common\models\generated\models\SiteDomain
 */
class SiteDomainQuery extends ActiveQuery
{
    /*public function active()
    {
    return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\generated\models\SiteDomain[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\generated\models\SiteDomain|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    public function byName($name){
        return $this->andWhere(['name' => $name]);
    }
    public function bySiteId($id){
        return $this->andWhere(['site_id' => $id]);
    }
    public function isPrimary(){
        return $this->andWhere(['is_primary' => true]);
    }
}
