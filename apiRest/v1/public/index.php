<?php
require '../app/core/routers/ArticuloRouter.php';
require '../app/core/routers/CarritoRouter.php';
require '../app/core/routers/UsuarioRouter.php';




// Obtener la URL solicitada
$url = $_SERVER['REQUEST_URI'];
$url = str_replace('/apiRest/v1/public', '', $url);
$url = trim($url, '/');
$urlParams = explode('/', $url);


// Inicializar el array de la URL
$urlArray = array(
    'HTTP'=> $_SERVER['REQUEST_METHOD'],
    'controller'=> $urlParams[0],
    'action'=> $urlParams[1],
    'params'=> $urlParams[2] ?? null,
    'path'=> $url
);
//echo json_encode($urlParams);
error_log(print_r($urlArray, true));

// Validación de la URL
if(empty($urlParams[0]) || empty($urlParams[1])){
    http_response_code(400);
    echo json_encode(['message' => 'Bad Request: Missing controller or action']);
    exit;
}

// Delegar la lógica de enrutamiento al enrutador correspondiente
switch ($urlArray['controller']) {
    case 'articulo':
        $articuloRouter = new ArticuloRouter();
        $response = $articuloRouter->route($urlArray);
        break;
    case 'carrito':
        $carritoRouter = new CarritoRouter();
        $response = $carritoRouter->route($urlArray);
        break;
    case 'usuario':
        $usuarioRouter = new UsuarioRouter();
        $response = $usuarioRouter->route($urlArray);
        break;
    default:
        http_response_code(404);
        echo json_encode(['message' => 'Controller not found']);
        exit;
}
// Enviar la respuesta
echo json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);