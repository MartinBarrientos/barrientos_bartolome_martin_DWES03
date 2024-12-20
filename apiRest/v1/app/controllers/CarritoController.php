<?php
include '/xampp/htdocs/apiRest/v1/app/models/carrito.php';
# Lógica de negocio
class CarritoController{
    protected $json = '../app/core/data/carrito.json';
    function __construct(){

    }
    function mostrar() {
        $result = Carrito::cargarCarritosDesdeJson();
        if (!$result) {
            http_response_code(404);
            return ['Estado consulta'=> http_response_code( 404),'message' => 'Carritos no encontrados'];
        }else{
            http_response_code(200);
            return ['Estado consulta' => http_response_code(200),'message' => 'Carritos conseguidos', 'data' => $result];
        }
    }
    function mostrarId($id){
        $result = Carrito::mostrarId($id);
        if (!$result) {
            http_response_code(404);
            return ['Estado consulta' => http_response_code(404), 'message' => 'Carrito no encontrado', 'data' => $result];
        }else{
            http_response_code(200);
            return ['Estado consulta' => http_response_code(200),'message' => 'Carritos conseguido por id', 'data' => $result];
        }
    }
    function new($data){
        $result = Carrito::new($data);
        if(is_null($data)){
            http_response_code(400);
            return ['message' => 'Bad Request: Missing data'];            
        }else{
            if($result){
                http_response_code(200);
                return ['Estado consulta' => http_response_code(200),'message' => 'Nuevo Carrito creado', 'data' => $result];
            }else{
                http_response_code(404);
                return ['Estado consulta' => http_response_code(404),'message' => 'Carrito no encontrado', 'data' => $result];
            }

        }

    }
    function update($id,$data){
        $result = Carrito::update($id, $data);
        if(!$result){
            http_response_code(404);
            return ['Estado consulta' => http_response_code(404),'message' => 'Carrito no encontrado', 'data' => $result];
        }else{
            http_response_code(200);
            return ['Estado consulta' => http_response_code(200),'message' => 'Carrito actualizado', 'data' => $result];
        }       

    }
    function delete($id){
        $result = Carrito::delete($id);
        if($result){
            http_response_code(200);
            return ['Estado consulta' => http_response_code(200),'message' => 'Carrito eliminado', 'data' => $result];
        }else{
            http_response_code(404);
            return ['Estado consulta' => http_response_code(404),'message' => 'Carrito no encontrado', 'data' => $result];
        }    
    }





}