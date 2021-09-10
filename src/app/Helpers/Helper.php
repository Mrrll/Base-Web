<?php
namespace App\Helpers;
use Psr\Http\Message\UploadedFileInterface;
// TODO: Archivo de funciones de ayuda ...
class Helper
{
    // *: Ayuda de la direccion de los assets ...
    public function assets($path = null)
    {
        return './' . $path;
    }
    // *: Ayuda a subir archivos ...
    public function moveUploadedFile(
        string $directory,
        UploadedFileInterface $uploadedFile
    ) {
        $extension = pathinfo(
            $uploadedFile->getClientFilename(),
            PATHINFO_EXTENSION
        );

        // see http://php.net/manual/en/function.random-bytes.php
        $basename = bin2hex(random_bytes(8));
        $filename = sprintf('%s.%0.8s', $basename, $extension);

        $uploadedFile->moveTo($directory . DIRECTORY_SEPARATOR . $filename);

        return $filename;
    }
}
