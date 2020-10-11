<?php


namespace KLevesque\LCGS\Infrastructure\persistence\doctrine;


use Doctrine\DBAL\DBALException;
use Doctrine\ORM\Configuration;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\Mapping\Driver\SimplifiedXmlDriver;
use Doctrine\ORM\ORMException;

class EntityManager
{
    /**
     * @param $dbConfigs
     * @param $proxyDir
     * @return EntityManagerInterface
     * @throws DBALException
     * @throws ORMException
     */
    public static function creer($dbConfigs, $proxyDir) : EntityManagerInterface{




        $driver = new SimplifiedXmlDriver([
            realpath(__DIR__ . "/mapping") => "KLevesque\\LCGS\\Domain"
        ]);
        $config = new Configuration();
        $config->setMetadataDriverImpl($driver);
        $config->setProxyDir($proxyDir);
        $config->setProxyNamespace('Proxies');



        $em = \Doctrine\ORM\EntityManager::create(
            $dbConfigs,
            $config
        );


        return $em;
    }
}