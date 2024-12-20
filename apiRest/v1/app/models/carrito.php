<?php

class Carrito{
    protected $id;
    protected $usuario_id;
    protected array $articulos;
    public function __construct($usuario_id, $articulos=[]) {
        $this->id = $this->generarNuevoId();
        $this->usuario_id = $usuario_id;
        $this->articulos = $articulos;    
        
    }
    //getters
    public function getId(){
        return $this->id;
    }
    public function getUsuario_id(){
        return $this->usuario_id;
    }
    public function getArticulos(){
        return $this->articulos;
    }

    //funciones del carrito
    private function generarNuevoId() {
        $jsonCarritos = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/carritos.json');
        $datos = json_decode($jsonCarritos, true);
        if (!is_array($datos) || empty($datos)) {
            return 1; // Si no hay datos, el primer ID será 1
        }
        $ultimoId = max(array_column($datos, 'id'));
        return $ultimoId + 1;
    }
    public function toArray(){
        return [
            'id' => $this->getId(),
            'usuario_id' => $this->getUsuario_id(),
            'articulos' => $this->getArticulos()
        ];
    }
    //añadir un carrito
    public static function new($data){
        $jsonCarritos = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/carritos.json');
        $datos = json_decode($jsonCarritos, true);
        $carrito = new Carrito(             
            $data['usuario_id'],
            $data['articulos']
        );
        // Agregar el nuevo carrito al array de datos
        $datos[] = $carrito->toArray();
        // Guardar los datos en el archivo JSON
        file_put_contents('/xampp/htdocs/apiRest/v1/app/core/data/carritos.json', json_encode($datos,JSON_PRETTY_PRINT));
        return end($datos);
    }

    //eliminar un producto
    public static function delete($id){
        $jsonCarritos = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/carritos.json');
        $datos = json_decode($jsonCarritos, true);
        $index = array_search($id, array_column($datos, 'id'));
        if($index !== false){
            unset($datos[$index]);
            file_put_contents('/xampp/htdocs/apiRest/v1/app/core/data/carritos.json', json_encode($datos,JSON_PRETTY_PRINT));
            return $datos;
        }
    }
    //mostrar todos los carritos
    public static function cargarCarritosDesdeJson(){
        $jsonCarritos = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/carritos.json');
        $datos = json_decode($jsonCarritos, true);
        return $datos;
    }
    //mostrar un carrito por id
    public static function mostrarId($id){
        $jsonCarritos = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/carritos.json');
        $datos = json_decode($jsonCarritos, true);
        $index = array_search($id, array_column($datos, 'id'));
        if($index !== false){
            return $datos[$index];
        }
    }
    //actualizar un carrito
    public static function update($id,$data){
        $jsonCarritos = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/carritos.json');
        $datos = json_decode($jsonCarritos, true);
        $index = array_search($id, array_column($datos, 'id'));
        if($index !== false){
            $datos[$index] = $data;
            file_put_contents('/xampp/htdocs/apiRest/v1/app/core/data/carritos.json', json_encode($datos,JSON_PRETTY_PRINT));
            return $data;
        }
    }

}