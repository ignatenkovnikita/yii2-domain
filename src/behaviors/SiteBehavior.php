<?php

namespace ignatenkovnikita\domain\behaviors;

use common\models\Site;
use ignatenkovnikita\domain\DomainInterface;
use yii\base\Behavior;
use yii\db\ActiveRecord;

class SiteBehavior extends Behavior
{
    public $attribute = 'site_id';

    /**
     * {@inheritDoc}
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_BEFORE_VALIDATE => 'beforeCreate',
            ActiveRecord::EVENT_INIT => 'beforeCreate',
        ];
    }

    /**
     *
     */
    public function beforeCreate()
    {
        if (empty($this->owner->{$this->attribute}))
            $this->owner->{$this->attribute} = $this->getCurrentSiteId();
    }

    /**
     * @return int|string
     */
    public function getCurrentSiteId()
    {
        $site = \Yii::$app->site;
        if ($site) {
            return $site->getIdentity() instanceof DomainInterface ? $site->getIdentity()->getId() : null;

        }
    }

}