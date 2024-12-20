<?php
include '/xampp/htdocs/apiRest/v1/app/models/usuario.php';
# Lógica de negocio
class UsuarioController{
    protected $json = '../app/core/data/usuario.json';
    function __construct(){

    }
    function mostrar() {
        $result = Usuario::cargarUsuariosDesdeJson();
        if ($result) {
            http_response_code(200);
            return ['Estado consulta' => http_response_code(200), 'message' => 'Usuarios conseguidos', 'data' => $result];
        } else {     
            http_response_code(404);       
            return ['Estado consulta'=> http_response_code( 404),'message' => 'Usuarios no encontrados'];
        }
    }
    function mostrarId($id){
        $result = Usuario::mostrarId($id);
        if (!$result) {
            http_response_code(404);
            return ['Estado consulta' => http_response_code(404), 'message' => 'Usuario no encontrado', 'data' => $result];
        }else{
            http_response_code(200);
            return ['Estado consulta' => http_response_code(200),'message' => 'Usuarios conseguido por id', 'data' => $result];

        }
    }
    function new($data){
        $result = Usuario::new($data);
        
        
        if(is_null($data)){
            http_response_code(400);
            return ['message' => 'Bad Request: Missing data'];
            
        }else{            
            http_response_code(200);
            return ['Estado consulta' => http_response_code(200),'message' => 'Nuevo usuario creado', 'data' => $result];

        }

    }
    function update($id,$data){       
        $result = Usuario::update($id,$data); 
        if ($result) {
            http_response_code(200);
            return ['Estado consulta' => http_response_code(200), 'message' => 'Usuario actualizado', 'data' => $result];
        } else {     
            http_response_code(404);       
            return ['Estado consulta'=> http_response_code( 404),'message' => 'Usuario no encontrado'];
        }

    }
    function delete($id) {
        $result = Usuario::delete($id);
        if ($result) {
            http_response_code(200);
            return ['Estado consulta' => http_response_code(200), 'message' => 'Usuario eliminado', 'data' => $result];
        } else {     
            http_response_code(404);       
            return ['Estado consulta'=> http_response_code( 404),'message' => 'Usuario no encontrado'];
        }
    }





}