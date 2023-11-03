<?php
class Productos {
    private $productosID;
    private $nombre;
    private $codigo;
    private $precioCompra;
    private $precioVenta;
    private $stock;
    private $stockMin;
    private $ProveedoresID;
    private $categoriasID;
    private $activo;

    public function __construct() {
        // Constructor vacío
    }

    public function getProductosID() {
        return $this->productosID;
    }

    

    public function setProductosID($productosID) {
        $this->productosID = $productosID;
        return $this;
    }

    public function getNombre() {
        return $this->nombre;
    }

    public function setNombre($nombre) {
        $this->nombre = $nombre;
        return $this;
    }

    
    public function getCodigo() {
        return $this->codigo;
    }

    public function setCodigo($codigo) {
        $this->codigo = $codigo;
        return $this;
    }

    public function getPrecioCompra() {
        return $this->precioCompra;
    }

    public function setPrecioCompra($precioCompra) {
        $this->precioCompra = $precioCompra;
        return $this;
    }

    public function getPrecioVenta() {
        return $this->precioVenta;
    }

    public function setPrecioVenta($precioVenta) {
        $this->precioVenta = $precioVenta;
        return $this;
    }

    public function getStock() {
        return $this->stock;
    }

    public function setStock($stock) {
        $this->stock = $stock;
        return $this;
    }

    public function getStockMin() {
        return $this->stockMin;
    }

    public function setStockMin($stockMin) {
        $this->stockMin = $stockMin;
        return $this;
    }

    public function getProveedoresID() {
        return $this->ProveedoresID;
    }

    public function setProveedoresID($ProveedoresID) {
        $this->ProveedoresID = $ProveedoresID;
        return $this;
    }

    public function getCategoriasID() {
        return $this->categoriasID;
    }

    public function setCategoriasID($categoriasID) {
        $this->categoriasID = $categoriasID;
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
