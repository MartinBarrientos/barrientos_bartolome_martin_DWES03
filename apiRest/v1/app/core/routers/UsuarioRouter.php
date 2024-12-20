<?php
//Definimos las rutas de la API para articulo
class UsuarioRouter{
    protected $routers = array();
    protected $params = array();
    public function __construct() {
        $this->add('/usuario/mostrar', array(
            'controller' => 'UsuarioController',
            'action' => 'mostrar'
        ));
        $this->add('/usuario/mostrarId/{id}', array(
            'controller' => 'UsuarioController',
            'action' => 'getUsuarioById'
        ));
        $this->add('/usuario/new', array(
            'controller' => 'UsuarioController',
            'action' => 'new'
        ));
        $this->add('/usuario/update/{id}', array(
            'controller' => 'UsuarioController',
            'action' => 'update'
        ));
        $this->add('/usuario/delete/{id}', array(
            'controller' => 'UsuarioController',
            'action' => 'delete'
        ));
    }
    public function add($route, $params){
        //Agregamos la ruta y sus parametros al array 
        $this->routers[$route] = $params;
    }
    public function getRouters(){
        return $this->routers;
    }
    public function route($urlArray) {
        $controllerName = ucfirst($urlArray['controller']).'Controller';
        $controllerFile = '../app/controllers/'.$controllerName.'.php';
        if (!file_exists($controllerFile)) {
            http_response_code(404);
            return ['message' => 'Controller not found'];
        }

        require $controllerFile;
        $controlador = new $controllerName();

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
            $params[] = json_decode($json, true);
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