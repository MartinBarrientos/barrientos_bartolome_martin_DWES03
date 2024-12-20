<?php
include '/xampp/htdocs/apiRest/v1/app/models/articulo.php';
# Lógica de negocio
class ArticuloController{
    protected $json = '../app/core/data/articulos.json';
    function __construct(){

    }
    function mostrar() {
        $result = Articulo::cargarArticulosDesdeJson();
        if($result){
            http_response_code(200);
            return ['Estado consulta' => http_response_code(200), 'message' => 'Articulos conseguidos', 'data' => $result];

        }else{
            http_response_code(404);
            return ['Estado consulta'=> http_response_code( 404),'message' => 'Articulos no encontrados'];
        }
    }
    function mostrarId($id){
        $result = Articulo::mostrarId($id);
        if (!$result) {
            http_response_code(404);
            return ['Estado consulta' => http_response_code(404), 'message' => 'Articulo no encontrado', 'data' => $result];
        }else{
            return ['Estado consulta' => http_response_code(200),'message' => 'Articulo conseguido por id', 'data' => $result];

        }
    }
    function new($data){
        $result = Articulo::new($data);
        if(is_null($data)){
            http_response_code(400);
            return ['Estado consulta' => http_response_code(400),'message' => 'Bad Request: Missing data'];
            
        }else{
            http_response_code(200);
            return ['Estado consulta' => http_response_code(200),'message' => 'Nuevo articulo creado', 'data' => $result];

        }

    }
    function update($id,$data){        
        $result = Articulo::update($id,$data);
        if($result){
            http_response_code(200);
            return ['Estado consulta' => http_response_code(200),'message' => 'Articulo actualizado', 'data' => $result];
        }else{
            http_response_code(404);
            return ['Estado consulta'=> http_response_code( 404),'message' => 'Articulo no encontrado'];
        }

    }
    function delete($id){
        $result = Articulo::delete($id);
        if($result !== false){
            http_response_code(200);
            return ['Estado consulta' => http_response_code(200), 'message' => 'Articulo eliminado', 'data' => $result];
        }else {
            http_response_code(404);
            return ['Estado consulta'=> http_response_code( 404),'message' => 'Articulo no encontrado'];
        }
    }





}