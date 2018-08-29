<?php
namespace ignatenkovnikita\domain;


/**
 * Interface DomainInterface
 * @package common\components\domain
 */
interface DomainInterface
{
    /**
     * @param $id
     * @return mixed
     */
    public static function findIdentity($id);

    /**
     * @param $domain
     * @return mixed
     */
    public static function findIdentityByDomain($domain);

    public static function findIdentityByToken($token);

    /**
     * @return mixed
     */
    public function getId();

}