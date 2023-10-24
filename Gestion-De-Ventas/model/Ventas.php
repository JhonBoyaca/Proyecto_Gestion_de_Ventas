<?php
class Ventas {
    private $ventasID;
    private $fecha;
    private $total;
    private $usuarioID;
    private $activo;

    public function __construct() {
        // Constructor vacío
    }

    public function getVentasID() {
        return $this->ventasID;
    }

    public function setVentasID($ventasID) {
        $this->ventasID = $ventasID;
        return $this;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function setFecha($fecha) {
        $this->fecha = $fecha;
        return $this;
    }

    public function getTotal() {
        return $this->total;
    }

    public function setTotal($total) {
        $this->total = $total;
        return $this;
    }

    public function getUsuarioID() {
        return $this->usuarioID;
    }

    public function setUsuarioID($usuarioID) {
        $this->usuarioID = $usuarioID;
        return $this;
    }

    public function isActivo() {
        return $this->activo;
    }

    public function setActivo($activo) {
        $this->activo = $activo;
        return $this;
    }
}
