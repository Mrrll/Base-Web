<?php
namespace App\Controllers;


// TODO: Archivo de Controlador de la vista Welcom ...
class IndexController extends Controller
{
    // *: Muestra la peticion get del controlador ...
    public function index($request, $response)
    {
        // *: Referencia al [User::class => (Muchos)] a [Address::class => (uno)] unidireccional ...
            // ?: Primero se crea el (uno) ...
                // $address = $this->db->find(\App\Models\Address::class, 1);
                // $address = new \App\Models\Address();
                // $address->setAddress('Carre mia n21');
                // $this->db->persist($address);
                // $this->db->flush();
            // ?:_______________________________
            // ?: Segundo se crea el (muchos) ...
                // $address = $this->db->find(Address::class, 1); //?: Buscamos el (uno) o accediendo en el momento de la creacion del (uno) ...
                // $user = new \App\Models\User();
                // $user->setName("Edgar");
                // $user->setAddress($address); // ?: Indicamos el (uno) en el (muchos) ...
                // !: Como es (Muchos a uno) podemos crear mas usuarios con la misma direccion ... (Inutil)
                // $user = new \App\Models\User();
                // $user->setName("Edgar2");
                // $user->setAddress($address); // ?: Indicamos el (uno) en el (muchos) ...
                // $this->db->persist($user);
                // $this->db->flush();
            // ?:________________________________
            // ?: Para ver los resultado de (Muchos) a (uno) ...
                // $user = $this->db->find(\App\Models\User::class, 1);
                // dd($user->getAddress());
                // dd($user->getAddress()) o dd($user->getAddress()->getAddress()); // ?: Segun la function getAddress del (Muchos) ...
            // ?:________________________________________________
        // *:----------------------------------------------------------------------
        // *: Referencia al [Product::class => (Uno)] a [Shipment::class => (uno)] unidireccional ...
            // ?: Primero se crea el (uno) ...
                // $shipment = new \App\Models\Shipment();
                // $shipment->setName('Sony');
                // $this->db->persist($shipment);
                // $this->db->flush();
            // ?:_______________________________
            // ?: Segundo se crea el otro (uno) ...
                // $product = new \App\Models\Product();
                // $product->setName("Televisor 2");
                // $product->setShipment($shipment); // ?: Indicamos el (uno) en el (muchos) ...
                // $this->db->persist($product);
                // $this->db->flush();
            // ?:________________________________
            // ?: Para ver los resultado de (Uno) a (uno) ...
                // $product = $this->db->find(\App\Models\Product::class, 1);
                // dd($product, $product->getShipment());
            // ?:________________________________________________
        // *:----------------------------------------------------------------------
        // *: Referencia al [Customer::class => (Uno)] a [Cart::class => (uno)] bidireccional ...
            // ?: Primero se crea el (uno) ...
                // $shipment = new \App\Models\Shipment();
                // $shipment->setName('Sony');
                // $this->db->persist($shipment);
                // $this->db->flush();
            // ?:_______________________________
            // ?: Segundo se crea el otro (uno) ...
                // $product = new \App\Models\Product();
                // $product->setName("Televisor 2");
                // $product->setShipment($shipment); // ?: Indicamos el (uno) en el (muchos) ...
                // $this->db->persist($product);
                // $this->db->flush();
            // ?:________________________________
            // ?: Para ver los resultado de (Uno) a (uno) ...
                // $product = $this->db->find(\App\Models\Product::class, 1);
                // dd($product, $product->getShipment());
            // ?:________________________________________________
        // *:----------------------------------------------------------------------

        return $this->view->render($response, 'welcom.twig'); // ?: Renderizamos la plantilla desde el contenedor view ...
    }
}
