<?php
namespace App\Controllers\Users;
use App\Controllers\Controller;
// TODO: Archivo de Controlador de la vista About ...
class ProfileController extends Controller
{
    // *: Muestra la peticion get del controlador ...
    public function index($request, $response)
    {
        return $this->view->render($response, 'Users/profile.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
}
