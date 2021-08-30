<?php
namespace App\Controllers\Auth;
// TODO: Archivo que comprueba las credenciales del usurario ...
// *: Importamos las classes necesarias ...
use App\Models\User;
use App\Controllers\Controller;
class Auth extends Controller
{
    // *: Devuelve el usuario ...
    public function user()
    {
        if (isset($_SESSION['user'])) {
            return $this->db
                ->getRepository(User::class)
                ->find($_SESSION['user']);
        } // ?: Buscamos el usurio ....
        return false;
    } // ?: Buscamos si la sesion coicide con algun usuario de la tabla ...
    // *: Comprueba la sesion del usuario ...
    public function check()
    {
        return isset($_SESSION['user']); // ?: Miramos que la sesion exista ...
    } // ?: Comprobamos si hay sesion de usuraio ....
    // *: Logea al usuario ...
    public function attempt($email, $password, $remember = null)
    {
        $user = $this->db
            ->getRepository(User::class)
            ->findBy(['email' => $email]); // ?: Buscamo el usuario por correo electrónico ...
        if (!$user) {
            return false;
        } // ?: Si el usuario no se encuentra devolvemos false ...
        if (password_verify($password, $user[0]->getPassword())) {
            $this->session->create([
                'name' => 'user',
                'value' => $user[0]->getId(),
            ]); // ?: Crear session de usuario ...
            if ($remember) {
                $cookie = $this->cookies->create([
                    'name' => 'remember_user_session',
                    'value' => $email,
                ]);
                $rep = $this->db->getRepository(User::class); // ?: Instanciamos la Clase ...
                $usuario = $rep->findBy(['email' => $email])[0];
                $usuario->setRemember($cookie['value']); // ?: Añadimos la nueva password ...
                try {
                    $this->db->persist($usuario);
                    $this->db->flush(); // ?: Subir datos a la db ...
                } catch (\Doctrine\DBAL\Exception $exception) {
                    // !: Esto hay que cambiarlo por un mensaje ...
                    echo $exception->getMessage();
                    // !: ------------------------------------------
                }
            }
            return true;
        } // ?: Verificar contraseña para ese usuario ...
        return false;
    } // ?: Metodo que se encarga de verificar passwords ...
    // *: Cierra la conexion del usuario ...
    public function logout()
    {
        if (isset($_COOKIE['remember_user_session'])) {
            $this->cookies->DeleteCookie('remember_user_session');
        }
        session_unset();
        session_destroy();
    }
    // *: Verifica si el email esta validado ...
    public function verification()
    {
        if (isset($_SESSION['user'])) {
            $rep = $this->db->getRepository(User::class); // ?: Instanciamos la Clase ...
            $usu = $rep->findBy(['email' => $this->auth->user()->getEmail()]); // ?: Buscamos el usuario con inicio de sesion ...
            if ($usu[0]->getEmailVerifiedAt()) {
                return true;
            } // ? Si es verdadero devolvemos true ...
        } // ?: Buscamos el usurio ....
        return false;
    }
    // *: Logea al usuario mediante la cookie remember me ...
    public function attemptRemember()
    {
        $user = $this->db
            ->getRepository(User::class)
            ->findBy(['remember_me' => $_COOKIE['remember_user_session']]); // ?: Buscamo el usuario por correo electrónico ...
        if (!$user) {
            return false;
        } // ?: Si el usuario no se encuentra devolvemos false ...
        // *: Verificamos la cookie ...
        if (
            password_verify(
                $user[0]->getEmail(),
                $_COOKIE['remember_user_session']
            )
        ) {
            $this->session->create([
                'name' => 'user',
                'value' => $user[0]->getId(),
            ]); // ?: Crear session de usuario ...
            return true;
        } // ?: Verificar la cookie para ese usuario ...
        return false;
    } // ?: Metodo que se encarga de verificar cookies ...
}
