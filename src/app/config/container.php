<?php
// TODO: Archivo de Configuracion de los Servicios del contenedor Slim ...
// *: Importamos las classes necesarias ...
use DI\Container;
use Slim\Views\Twig;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Setup;
use Slim\Psr7\Factory\ResponseFactory;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Routing\RouteContext;
// *: Agregar servicio de Doctrine a su contenedor ...
$container->set(EntityManager::class, static function (
    Container $container
): EntityManager {
    $settings = $container->get('settings'); // ?: obtener parametros de configuracion ...
    // *: Parametros de configuracion AnnotationMetadata ...
    $paths = [realpath(__DIR__ . '/../Models')];
    $isDevMode = true;
    $proxyDir = null;
    $cache = null;
    $useSimpleAnnotationReader = false;
    $config = Setup::createAnnotationMetadataConfiguration(
        $paths,
        $isDevMode,
        $proxyDir,
        $cache,
        $useSimpleAnnotationReader
    ); // ?: Metodo de configuracion de doctrine ...
    return EntityManager::create($settings['doctrine']['connection'], $config); // ?: Creamos y devolvemos la instancia ...
});
// *: Agregar servicio puente de Doctrine db ...
$container->set('db', function ($container) {
    return $container->get(EntityManager::class);
});
// *: Agregar servicio de la Autentificacion a su contenedor ...
$container->set('auth', function ($container) {
    return new \App\Controllers\Auth\Auth($container);
});
// *: Agregar servicio de mesanjes a su contenedor ...
$container->set('flash', function ($container) {
    return new \Slim\Flash\Messages();
});
// *: Agregar servicio de funciones de ayuda a su contenedor ...
$container->set('helpers', function ($container) {
    return new \App\Helpers\Helper();
});
// *: Agregar servicio de vista a su contenedor ...
$container->set('view', function ($container) {
    // *: Motor de Plantilla Twig ...
    $view = Twig::create(__DIR__ . '/../../resources/Views', [
        'cache' => false,
    ]);
    $view->getEnvironment()->addGlobal('auth', [
        'check' => $container->get('auth')->check(),
        'user' => $container->get('auth')->user(),
    ]); // ?: Pasamos datos a la vista o el componente del container o creamos un objeto con las funciones del componente auth del container ...
    $view->getEnvironment()->addGlobal('flash', $container->get('flash')); // ?: Pasamos datos a la vista o el componente del container o creamos un objeto con las funciones del componente flash del container ...
    $view->getEnvironment()->addGlobal('base_url', $_ENV['BASE_URL']); // ?: Pasamos la contante a las vistas ...
    $view->getEnvironment()->addGlobal('app_name', $_ENV['APP_NAME']); // ?: Pasamos la contante a las vistas ...
    $view->getEnvironment()->addGlobal('help', $container->get('helpers')); // ?: Pasamos la contante a las vistas ...
    return $view;
});
// *: Agregar servicio del validador a su contenedor ...
$container->set('validator', function ($container) {
    // *: Validacion de datos ...
    return new \App\Validation\Validator();
});
// *: Agregar servicio del csrf a su contenedor ...
$container->set('csrf', function ($container) {
    $responseFactory = new ResponseFactory();
    $csrf = new \Slim\Csrf\Guard($responseFactory);
    $csrf->setPersistentTokenMode(true); // !: Para poder trabajar con Axios ...
    $csrf->setFailureHandler(function (
        Request $request,
        RequestHandler $handler
    ) {
        $request = $request->withAttribute('csrf_status', false);
        return $handler->handle($request);
    });
    return $csrf;
});
// *: Agregar servicio del mailer a su contenedor ...
$container->set('mailer', function ($container) {
    $settings = $container->get('settings');
    $view = $container->get('view');
    $mailer = new \Semhoun\Mailer\Mailer($view, $settings['mailer']);
    // ?: Establecer los detalles del remitente predeterminado ....
    $mailer->setDefaultFrom($_ENV['SMTP_FROM'], $_ENV['APP_NAME']);
    return $mailer;
});
// *: Agregar servicio de sesiones a su contenedor ...
$container->set('session', function ($container) {
    return new \App\Services\Session($container);
});
// *: Agregar servicio de cookies a su contenedor ...
$container->set('cookies', function ($container) {
    return new \App\Services\Cookie($container);
});
require_once __DIR__ . './controllers.php';
