<?php

namespace Model;

class Usuario extends ActiveRecord {
    // base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'apellido', 'email',
     'password', 'telefono', 'admin', 'confirmado', 'token'];

    public $id;
    public $nombre;
    public $apellido;
    public $email;
    public $password;
    public $rePassword;
    public $telefono;
    public $admin;
    public $confirmado;
    public $token;

    public function __construct($args = []) {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->apellido = $args['apellido'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->rePassword = $args['password'] ?? '';
        $this->telefono = $args['telefono'] ?? '';
        $this->admin = $args['admin'] ?? 0;
        $this->confirmado = $args['confirmado'] ?? 0;
        $this->token = $args['token'] ?? '';

    }

    // mensajes de validacion para crear la cuenta
    public function validarNuevaCuenta() {
        if(!$this->nombre) {
            self::$alertas['error'][] = 'Debes ingrenar un nombre';
        }
        if(!$this->apellido) {
            self::$alertas['error'][] = 'Debes ingrenar un apellido';
        }
        if(!$this->telefono) {
            self::$alertas['error'][] = 'Debes ingrenar un numero de telefono';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'Debes ingrenar un email';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'Debes ingrenar una password';
        }
        if($this->password != $this->rePassword) {
            self::$alertas['error'][] = 'tu password no coincide';
        }
        if(strlen($this->password) < 8){
            self::$alertas['error'][] = 'tu password es muy corta';
        }

        return self::$alertas;
    }

    public function validarLogin() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El correo es obligatorio man';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El password es obligatorio man';
        }
        return self::$alertas;
    }

    public function validarEmail() {
        if(!$this->email) {
            self::$alertas['error'][] = 'El correo es obligatorio man';
        }
        return self::$alertas;
    }

    public function validarPassword() {
        if(!$this->password && strlen($this->password) < 8) {
            self::$alertas['error'][] = 'la PSW no cumple con los requisitos minimos';
        }
        return self::$alertas;
    }


    // revisar si el usuario existe
    public function existeUsuario() {
        $query = "SELECT * FROM " . self::$tabla . " WHERE email = '" . $this->email . "' LIMIT 1";

        $resultado = self::$bd->query($query); 
        
        if($resultado->num_rows) {
            self::$alertas['error'][] = 'El usuario ya existe';
        }
        return $resultado;
    }

    public function hashPassword() {
        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    public function crearToken() {
        $this->token = uniqid();
    }

    public function comprobarPasswordVerificado($password) {

        $resultado = password_verify($password, $this->password);

        if(!$resultado || !$this->confirmado) {
            self::$alertas['error'][] = 'Cuenta no confirmada o pass incorrecta';
        } else {
            return true;
        }
    }
}
