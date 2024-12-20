<?php
class Articulo
{
    protected $id;
    protected $nombre;
    protected $descripcion;
    protected $precio;
    protected $stock;
    protected $categoria;
    protected $disponible;
    protected $articulos = array();

    //constructor
    public function __construct($nombre, $descripcion, $precio, $stock, $categoria, $disponible)
    {
        $this->id = $this->generarNuevoId();
        $this->nombre = $nombre;
        $this->descripcion = $descripcion;
        $this->precio = $precio;
        $this->stock = $stock;
        $this->categoria = $categoria;
        $this->disponible = $disponible;
    }
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'descripcion' => $this->getDescripcion(),
            'precio' => $this->getPrecio(),
            'stock' => $this->getStock(),
            'categoria' => $this->getCategoria(),
            'disponible' => $this->getDisponible()
        ];
    }
    public static function new($data)
    {
        $jsonArticulos = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/articulos.json');
        $datos = json_decode($jsonArticulos, true);
        $articulo = new Articulo(
            $data['nombre'],
            $data['descripcion'],
            $data['precio'],
            $data['stock'],
            $data['categoria'],
            $data['disponible']
        );

        // Agregar el nuevo artículo al array de datos
        $datos[] = $articulo->toArray();
        // Guardar los datos en el archivo JSON
        file_put_contents('/xampp/htdocs/apiRest/v1/app/core/data/articulos.json', json_encode($datos,JSON_PRETTY_PRINT| JSON_UNESCAPED_UNICODE));
        return end($datos);
    }
    //getters
    public function getArticulos()
    {
        return $this->articulos;
    }
    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getDescripcion()
    {
        return $this->descripcion;
    }
    public function getPrecio()
    {
        return $this->precio;
    }

    public function getStock()
    {
        return $this->stock;
    }

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function getDisponible()
    {
        return $this->disponible;
    }
    //setters
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    public function setPrecio($precio)
    {
        if ($precio < 0) {
            throw new Exception("El precio no puede ser negativo");
        } else {
            $this->id = $precio;
        }
    }
    public function setStock($stock)
    {
        if ($stock < 0) {
            throw new Exception("El stock no puede ser negativo");
        } else {
            $this->id = $stock;
        }
    }
    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }
    public function setDisponible($disponible)
    {
        $this->disponible = $disponible;
    }
    // Método para generar un nuevo ID
    private function generarNuevoId()
    {
        $archivoJson = '/xampp/htdocs/apiRest/v1/app/core/data/articulos.json';
        if (file_exists($archivoJson)) {
            $contenido = file_get_contents($archivoJson);
            $datos = json_decode($contenido, true);
            if ($datos !== null) {
                $ultimoId = end($datos)['id'];
                return $ultimoId + 1;
            }
        }
        return 1; // Si no hay datos, el primer ID será 1
    }
    public static function mostrarId($id)
    {
        $jsonArticulos = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/articulos.json');
        $datos = json_decode($jsonArticulos, true);

        foreach ($datos as $dato) {
            if ($dato['id'] == $id) {
                return $dato;
            }
        }
    }
    public static function update($id, $data)
    {
        $jsonArticulos = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/articulos.json');
        $datos = json_decode($jsonArticulos, true);
        $articuloEncontrado = false;
        foreach ($datos as &$dato) {
            if ($dato['id'] == $id) {
                //actualizar valores
                $dato['nombre'] = $data['nombre'] ?? $dato['nombre'];
                $dato['descripcion'] = $data['descripcion'] ?? $dato['descripcion'];
                $dato['precio'] = $data['precio'] ?? $dato['precio'];
                $dato['stock'] = $data['stock'] ?? $dato['stock'];
                $dato['categoria'] = $data['categoria'] ?? $dato['categoria'];
                $dato['disponible'] = $data['disponible'] ?? $dato['disponible']; 
                $articuloEncontrado = true;               
                break;
            }
        }       
        if (!$articuloEncontrado) {
            return false;
        }else{
            file_put_contents('/xampp/htdocs/apiRest/v1/app/core/data/articulos.json', json_encode($datos,JSON_PRETTY_PRINT| JSON_UNESCAPED_UNICODE));
            return $data;

        }
    }
    public static function delete($id)
    {
        $jsonArticulos = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/articulos.json');
        $datos = json_decode($jsonArticulos, true);
        foreach ($datos as $key => $dato) {
            if ($dato['id'] == $id) {
                unset($datos[$key]);
                file_put_contents('/xampp/htdocs/apiRest/v1/app/core/data/articulos.json', json_encode($datos,JSON_PRETTY_PRINT| JSON_UNESCAPED_UNICODE));
                return $dato;
            }
        }
        return false;
    }
    public static function cargarArticulosDesdeJson()
    {

        $jsonArticulos = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/articulos.json');
        return json_decode($jsonArticulos);
    }
}
