<?php

class usuario
{
    protected $id;
    protected $nombre;
    protected $email;
    protected $password;
    protected $telefono;
    protected $direccion;
    public function __construct($nombre, $email, $password, $telefono, $direccion)
    {

        $this->id = $this->generarNuevoId();
        $this->nombre = $nombre;
        $this->email = $email;
        $this->password = $password;
        $this->telefono = $telefono;
        $this->direccion = $direccion;
    }
    //generar nuevo id
    private function generarNuevoId()
    {
        $jsonUsuarios = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/usuarios.json');
        $datos = json_decode($jsonUsuarios, true);
        if (!is_array($datos) || empty($datos)) {
            return 1; // Si no hay datos, el primer ID será 1
        }
        $ultimoId = max(array_column($datos, 'id'));
        return $ultimoId + 1;
    }
    //convertir a array
    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'nombre' => $this->getNombre(),
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'telefono' => $this->getTelefono(),
            'direccion' => $this->getDireccion()
        ];
    }
    //añadir un usuario
    public static function new($data)
    {
        $jsonUsuarios = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/usuarios.json');
        $datos = json_decode($jsonUsuarios, true);
        $usuario = new usuario(
            $data['nombre'],
            $data['email'],
            $data['password'],
            $data['telefono'],
            $data['direccion']
        );

        // Agregar el nuevo usuario al array de datos
        $datos[] = $usuario->toArray();
        // Guardar los datos en el archivo JSON
        file_put_contents('/xampp/htdocs/apiRest/v1/app/core/data/usuarios.json', json_encode($datos, JSON_PRETTY_PRINT| JSON_UNESCAPED_UNICODE));
        return end($datos);
    }
    //getters
    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function getDireccion()
    {
        return $this->direccion;
    }
    //mostrar todos los usuarios
    public static function cargarUsuariosDesdeJson()
    {
        $jsonUsuarios = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/usuarios.json');
        $datos = json_decode($jsonUsuarios, true);
        return $datos;
    }
    //mostrar un usuario por id
    public static function mostrarId($id)
    {
        $jsonUsuarios = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/usuarios.json');
        $datos = json_decode($jsonUsuarios, true);
        $index = array_search($id, array_column($datos, 'id'));
        if ($index !== false) {
            return $datos[$index];
        }
    }
    //actualizar un usuario
    public static function update($id, $data)
    {
        $jsonUsuarios = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/usuarios.json');
        $datos = json_decode($jsonUsuarios, true);
        $index = array_search($id, array_column($datos, 'id'));
        if ($index !== false) {
            $datos[$index] = $data;
            file_put_contents('/xampp/htdocs/apiRest/v1/app/core/data/usuarios.json', json_encode($datos, JSON_PRETTY_PRINT| JSON_UNESCAPED_UNICODE));
            return $datos[$index];
        }
    }
    //eliminar un usuario
    public static function delete($id)
    {
        $jsonUsuarios = file_get_contents('/xampp/htdocs/apiRest/v1/app/core/data/usuarios.json');
        $datos = json_decode($jsonUsuarios, true);
        $index = array_search($id, array_column($datos, 'id'));
        if ($index !== false) {
            unset($datos[$index]);
            file_put_contents('/xampp/htdocs/apiRest/v1/app/core/data/usuarios.json', json_encode($datos, JSON_PRETTY_PRINT| JSON_UNESCAPED_UNICODE));
            return $datos;
        }
    }
    
}
