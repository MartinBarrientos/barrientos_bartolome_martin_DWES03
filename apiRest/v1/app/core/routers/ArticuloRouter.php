<?php
//Definimos las rutas de la API para articulo
class ArticuloRouter{
    protected $routers = array();
    protected $params = array();
    
    public function __construct() {
        $this->add('/articulo/mostrar', array(
            'controller' => 'ArticuloController',
            'action' => 'mostrar'
        ));
        $this->add('/articulo/mostrarId/{id}', array(
            'controller' => 'ArticuloController',
            'action' => 'mostrarId'
        ));
        $this->add('/articulo/new', array(
            'controller' => 'ArticuloController',
            'action' => 'new'
        ));
        $this->add('/articulo/update/{id}', array(
            'controller' => 'ArticuloController',
            'action' => 'update'
        ));
        $this->add('/articulo/delete/{id}', array(
            'controller' => 'ArticuloController',
            'action' => 'delete'
        ));
    }
    public function add($route, $params){
        //Agregamos la ruta y sus parametros al array 
        $this->routers[$route] = $params;
    }
    public function route($urlArray) {
        //Obtenemos la ruta solicitada
        require '/xampp/htdocs/apiRest/v1/app/controllers/ArticuloController.php';
        $controlador = new ArticuloController();

        if (!method_exists($controlador, $urlArray['action'])) {
            http_response_code(404);
            return ['message' => 'Action not found'];
        }

        $method = $urlArray['HTTP'];
        
        $params = [];

        if ($method == 'GET') {
            $params[] = intval($urlArray['params']) ?? null;
        } else if ($method == 'POST') {
            $json = file_get_contents('php://input');
            $data = json_decode($json, true);
            $params[] = $data;
        } else if ($method == 'PUT') {
            $id = intval($urlArray['params']);
            $json = file_get_contents('php://input');
            $params[] = $id;
            $params[] = json_decode($json, true);
        } else if ($method == 'DELETE') {
            $params[] = intval($urlArray['params']);
        }

        return call_user_func_array([$controlador, $urlArray['action']], $params);
    }
    
    
}