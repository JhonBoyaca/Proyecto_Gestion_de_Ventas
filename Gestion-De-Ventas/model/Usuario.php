<?php
class Usuario
{
    private $usuarioID;
    private $dui;
    private $correo;
    private $nombre;
    private $rol;
    private $contrasena;
    private $activo;
    private $token_reset; // Nuevo atributo para token de restablecimiento

    public function __construct()
    {
        // Constructor vacío
    }

    public function getUsuarioID()
    {
        return $this->usuarioID;
    }

    public function setUsuarioID($usuarioID)
    {
        $this->usuarioID = $usuarioID;
        return $this;
    }

    public function getDui()
    {
        return $this->dui;
    }

    public function setDui($dui)
    {
        $this->dui = $dui;
        return $this;
    }

    public function getCorreo()
    {
        return $this->correo;
    }

    public function setCorreo($correo)
    {
        $this->correo = $correo;
        return $this;
    }

    public function getNombre()
    {
        return $this->nombre;
    }

    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
        return $this;
    }

    public function getRol()
    {
        return $this->rol;
    }

    public function setRol($rol)
    {
        $this->rol = $rol;
        return $this;
    }

    public function getContrasena()
    {
        return $this->contrasena;
    }

    public function setContrasena($contrasena)
    {
        $this->contrasena = $contrasena;
        return $this;
    }

    public function isActivo()
    {
        return $this->activo;
    }

    public function setActivo($activo)
    {
        $this->activo = $activo;
        return $this;
    }

    public function getTokenReset()
    {
        return $this->token_reset;
    }

    public function setTokenReset($token_reset)
    {
        $this->token_reset = $token_reset;
        return $this;
    }
}
