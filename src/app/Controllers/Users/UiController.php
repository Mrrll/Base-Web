<?php
namespace App\Controllers\Users;
use App\Controllers\Controller;
use App\Models\Profile;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
use Slim\Routing\RouteContext;
// TODO: Archivo de Controlador de la vista About ...
class UiController extends Controller
{
    public function UI(Request $request, Response $response)
    {
        // !: Esta parte habria que meterla en algun sito para poder acceder a ella ( Podria ir en Controller ) ...
        $params = (array) $request->getParsedBody(); // ?: Obtenemos Parametros del formulario ...
        $routes = RouteContext::fromRequest($request)->getRouteParser(); // ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------

        $datos = [
            'auth' => $this->auth->check(),
        ];
        if ($this->auth->check()) {
            $profile = $this->db
                ->getRepository(Profile::class)
                ->findOneby(['user' => $this->auth->user()->getId()]);
            $datos = [
                'auth' => $this->auth->check(),
                'user' => ($profile) ? $profile->getFirstname()." ".$profile->getLastname() : $this->auth->user()->getName()
            ];
        }
        $response->getBody()->write( json_encode($datos));
        return $response->withHeader('Content-Type', 'application/json');
    }
}
