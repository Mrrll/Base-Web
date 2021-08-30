<?php
// TODO: Archivo de configuracion de ejecutables de doctrine ...
// *: Importamos las classes necesarias ...
use Doctrine\ORM\EntityManager;
use Slim\Container;
use Doctrine\DBAL\Tools\Console\Helper\ConnectionHelper;
use Doctrine\ORM\Tools\Console\Helper\EntityManagerHelper;
use Symfony\Component\Console\Helper\HelperSet;
/** @var Container $container */ // ?: Documentar el tipo y función de una propiedad de clase.
// *: Importamos el Archivo de inicializacion y configuracion inicial de la aplicacion ...
require_once __DIR__ . '/../src/app/app.php';
$entityManager = $container->get(EntityManager::class); // ?: Obtenemos el servicio del contenedor ...
return new HelperSet([
    'em' => new EntityManagerHelper($entityManager),
    'db' => new ConnectionHelper($entityManager->getConnection()),
]); // ?: Devolvemos la instancia para los ejecutables de doctrine ...