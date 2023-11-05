<?php
class DetalleVentas
{
    private $detalleID;
    private $ventasID;
    private $productosID;
    private $cantidad;
    private $activo;
    private $precioVenta;
    private $nombreProducto;
    private $codigoProducto;



    public function __construct()
    {
        // Constructor vacío
    }


    public function getNombreProducto()
    {
        return $this->nombreProducto;
    }

    public function setNombreProducto($nombreProducto)
    {
        $this->nombreProducto = $nombreProducto;
        return $this;
    }

    public function getCodigoProducto()
    {
        return $this->codigoProducto;
    }

    public function setCodigoProducto($codigoProducto)
    {
        $this->codigoProducto = $codigoProducto;
        return $this;
    }

    public function getPrecioVenta()
    {
        return $this->precioVenta;
    }

    public function setPrecioVenta($precioVenta)
    {
        $this->precioVenta = $precioVenta;
        return $this;
    }

    public function getDetalleID()
    {
        return $this->detalleID;
    }

    public function setDetalleID($detalleID)
    {
        $this->detalleID = $detalleID;
        return $this;
    }

    public function getVentasID()
    {
        return $this->ventasID;
    }

    public function setVentasID($ventasID)
    {
        $this->ventasID = $ventasID;
        return $this;
    }

    public function getProductosID()
    {
        return $this->productosID;
    }

    public function setProductosID($productosID)
    {
        $this->productosID = $productosID;
        return $this;
    }

    public function getCantidad()
    {
        return $this->cantidad;
    }

    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
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
}
