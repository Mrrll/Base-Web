<?php
namespace App\Validation\Rules;
// TODO: Archivo de Regla Personalizada para el Nif ...
// *: Importamos las classes necesarias ...

use App\Models\Profile;
use Respect\Validation\Rules\AbstractRule;
final class ImageValid extends AbstractRule
{
    public function validate($input) : bool
    {
        $info = new \SplFileInfo($input);
        $formatos = ['bmp','gif','jpg','jpeg','svg','png']; // ! : Podriamos ponerlo en una variable de entorno ...
        return (array_search($info->getExtension(), $formatos) > 0) ? true : false;
    }
}
