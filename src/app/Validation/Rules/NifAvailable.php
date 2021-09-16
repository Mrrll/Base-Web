<?php
namespace App\Validation\Rules;
// TODO: Archivo de Regla Personalizada para el Nif ...
// *: Importamos las classes necesarias ...

use App\Models\Profile;
use Respect\Validation\Rules\AbstractRule;
final class NifAvailable extends AbstractRule
{
    // !: Esta parte ya esta metida en Controllers pero para poder acceder a ella ( Me visto obligado a duplicarla ) ...
    // *: Metodo get del objeto container ...
    public function __construct($container)
    {
        $this->container = $container;
    }
    // *: Metodo get del objeto container ...
    public function __get($property)
    {
        // ?: Devuelve la propiedad del objeto container solicitada ...
        if ($this->container->get($property)) {
            return $this->container->get($property);
        }
    }
    // ! -------------------------------------------------------------------
    public function validate($input): bool
    {
        // ?: Valida si el nif ya esta registrado ...
        if ($this->db->getRepository(Profile::class)->findBy(['nif' => $input, 'user' => $this->auth->user()->getId()])){
            return true;
        }
        return count(
            $this->db->getRepository(Profile::class)->findBy(['nif' => $input])
        ) === 0;
    }
}
