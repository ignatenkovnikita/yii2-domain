<?php

namespace ignatenkovnikita\domain;


use common\models\Site;
use Yii;
use yii\base\Component;
use yii\base\ErrorException;
use yii\base\InvalidConfigException;
use yii\base\InvalidValueException;
use yii\web\NotFoundHttpException;

class CurrentDomain extends Component
{

    /**
     * @var string domain name, которым мы по умолчанию инициализируем
     */
    public $forceInitName = 'base';

    /**
     * @var bool|Site
     */
    private $_identity = false;

    /**
     * @var bool/string Имя которым необходимо инициализировать компонент независимо от доменного имени
     */
    public $identityClass = false;

    /**
     * Initializes the application component.
     * @throws \yii\base\InvalidConfigException
     * @throws \yii\web\NotFoundHttpException
     * @throws \yii\base\InvalidValueException
     */
    public function init()
    {
        parent::init();

        if ($this->identityClass === null) {
            throw new InvalidConfigException(__CLASS__ . '::identityClass must be set.');
        }

        if (is_a(Yii::$app, 'yii\web\Application')) { // && count($hostParts) == 3) {
            $this->initByDomain(Yii::$app->request->hostName);
        }
        if (is_string($this->forceInitName)) {
            $this->initByDomain($this->forceInitName);
        }
    }

    /**
     * Returns the identity object associated with the currently logged tenant.
     * @return Site the identity object associated with the currently logged tenant.
     * `null` is returned if the tenant is not logged in (not authenticated).
     */
    public function getIdentity()
    {
        return $this->_identity;
    }

    /**
     * Sets the tenant identity object.
     *
     * @param DomainInterface|null $identity the identity object associated with the currently logged user.
     * If null, it means the current user will be a guest without any associated identity.
     * @throws \yii\base\InvalidValueException
     */
    public function setIdentity($identity)
    {
        if ($identity instanceof DomainInterface) {
            $this->_identity = $identity;
        } elseif ($identity === null) {
            $this->_identity = null;
        } else {
            throw new InvalidValueException('The identity object must implement IdentityTenantInterface.');
        }
    }

    /**
     * @param string $name Имя предприятия
     * @param bool $force
     * @throws ErrorException
     */
    public function initByDomain($name, $force = false)
    {
        if ($force === false && $this->getIdentity()) {
            return;
        }

        /**
         * @var DomainInterface $identityClass
         */
        $identityClass = $this->identityClass;
        /** @var Site $identity */
        $identity = call_user_func(array($this->identityClass, 'findIdentityByDomain'), $name);
//        $identity = $identityClass::findIdentityByDomain($name);


        if ($identity) {
            $this->isPrimaryDomain($identity, $name);
            $this->setIdentity($identity);
        } else {
            if (is_a(Yii::$app, 'yii\web\Application')) {
                \Yii::$app->user->logout();
            }
//            throw new ErrorException('Current site not set. Current name ' . $name);
        }
    }


    public function getId()
    {
        return $this->_identity->id;
    }



    public function isPrimaryDomain(Site $site, $domainName)
    {
        $primaryDomain = $site->getPrimaryDomain();
        if ($primaryDomain) {
            if ($primaryDomain->domain != $domainName) {
                return Yii::$app->response->redirect('http://' . $primaryDomain->domain);
            }
        }
    }
}