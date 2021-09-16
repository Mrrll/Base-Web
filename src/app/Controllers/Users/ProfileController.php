<?php
namespace App\Controllers\Users;
use App\Controllers\Controller;
use App\Models\Profile;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Respect\Validation\Validator as v;
use Slim\Routing\RouteContext;
use Psr\Http\Message\UploadedFileInterface;
use Doctrine\Common\Collections\ArrayCollection;
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
        // dd($params);
        $routes = RouteContext::fromRequest($request)->getRouteParser();// ?: Obtiene las rutas  y con urlFor indicamos la ruta por nombre ..
        // ! -------------------------------------------------------------------
        $user = $this->auth->user();
        // *: Validamos los datos ...
        $validation = $this->validator->validate($request, [
            'firstname' => v::optional(v::alpha(' ')->notEmpty()),
            'lastname' => v::optional(v::alpha(' ')->notEmpty()),
            'nif' => v::nif()->nifAvailable($this->container)->notEmpty(), // ?: Regla personalizada ...
            'phone' => v::optional(v::Phone()->notEmpty()),
            'mobile' => v::optional(v::Phone()->notEmpty()),
            'gender' => v::optional(v::alpha(' ')->notEmpty()),
            'birthday' => v::optional(v::notEmpty()->Date()),
            'avatar' => v::optional(v::imageValid()->notEmpty()),
        ]);
        if ($validation->failed()) {
            $respuesta = json_encode(
                array(
                    "errors" => $_SESSION['errors'],
                    "old" => $_SESSION['old']
                )
            );
            $response->getBody()->write($respuesta);
            return $response->withStatus(302);
        } //*: Comprobamos si los datos estan validados ...

        if ($user->profile()) {
            $profile = $user->profile();
            $message = "The profile has been updated successfully";
        } else {
            $profile = new Profile();
            $message = "The profile has been saved successfully";
        }
        // $profile = ($user->profile()) ? $user->profile() : new Profile();
        $uploadedFiles = $request->getUploadedFiles();
        if ($uploadedFiles) {
           $uploadedFile = $uploadedFiles['avatar'];
            if ($uploadedFile->getError() === UPLOAD_ERR_OK) {
                $filename = $this->helpers->moveUploadedFile($this->helpers->assets('Img/'), $uploadedFile);
                $profile->setUrl($this->helpers->assets('Img/'.$filename));
            } else {
                $response->getBody()->write('Image could not be uploaded');
                return $response->withStatus(400);
            }
        }
        $profile->setUser($user);
        $profile->setNif($params['nif']);
        ($params['firstname'] != '') ?$profile->setFirstname($params['firstname']) : '';
        ($params['lastname'] != '') ? $profile->setLastname($params['lastname']) : '';
        ($params['phone'] != '') ? $profile->setPhone($params['phone']) : '';
        ($params['mobile'] != '') ? $profile->setMobile($params['mobile']) : '';
        ($params['gender'] != '') ? $profile->setGender($params['gender']) : '';
        $profile->setBirthday(new \DateTime($params['birthday']));
        $this->db->persist($profile);
        $this->db->flush();
        $response->getBody()->write($message);
        return $response;
    }
    public function Ready(Request $request, Response $response)
    {
        $profile = $this->db->getRepository(Profile::class)->findOneby(['user'=> $this->auth->user()->getId()]);
       $response->getBody()->write($profile->json());
       return $response;
    }
}
