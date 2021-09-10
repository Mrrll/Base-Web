<?php
namespace App\Controllers\Users;
use App\Controllers\Controller;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
use Slim\Routing\RouteContext;
use Psr\Http\Message\UploadedFileInterface;
// TODO: Archivo de Controlador de la vista About ...
class ProfileController extends Controller
{
    // *: Muestra la peticion get del controlador ...
    public function index($request, $response)
    {
        return $this->view->render($response, 'Users/profile.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
    public function Save(Request $request, Response $response)
    {
         // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $params = (array)$request->getParsedBody(); // ?: Obtenemos Parametros del formulario ...
        $routes = RouteContext::fromRequest($request)->getRouteParser();// ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------
        $uploadedFiles = $request->getUploadedFiles();
        $uploadedFile = $uploadedFiles['avatar'];
        if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
            $filename = $this->helpers->moveUploadedFile($this->helpers->assets('Img/'), $uploadedFile);
            $response->getBody()->write('uploaded ' . $filename . '<br/>');
        }
        // dd($uploadedFiles, $this->helpers->assets());
        // $response->getBody()->write('Usuario registrado con exito ...');
        return $response;
    }
}
