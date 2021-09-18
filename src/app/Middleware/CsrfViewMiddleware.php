<?php
namespace App\Middleware;
// TODO: Archivo que gestiona el Token Csrf ...
// *: Importamos las classes necesarias ...
use App\Controllers\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Factory\ResponseFactory;
class CsrfViewMiddleware extends Controller
{
    public function __invoke(Request $request, RequestHandler $handler)
    {
        $this->view->getEnvironment()->addGlobal('csrf', [
            'field' =>
                '
                <input type="hidden" name="' .
                $this->csrf->getTokenNameKey() .
                '" value="' .
                $this->csrf->getTokenName() .
                '">
                <input type="hidden" name="' .
                $this->csrf->getTokenValueKey() .
                '" value="' .
                $this->csrf->getTokenValue() .
                '">
            ',
            'values' => [
                'csrf_name' => $this->csrf->getTokenName(),
                'csrf_value' => $this->csrf->getTokenValue(),
            ],
        ]); // ?: Enviamos a la vista los imputs con los tokens generados ...
        if (false === $request->getAttribute('csrf_status')) {
            $responseFactory = new ResponseFactory();
            $response = $responseFactory->createResponse();
            $response->getBody()->write('Token check failed! ... update your browser.');
            return $response->withStatus(400);
        } // ?: Proceso de respuesta cuando Failed CSRF ...
        $response = $handler->handle($request);
        return $response;
    }
}
