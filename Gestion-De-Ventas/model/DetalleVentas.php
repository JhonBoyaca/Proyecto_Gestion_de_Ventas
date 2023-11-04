<?php
class DetalleVentas
{
    private $detalleID;
    private $ventasID;
    private $productosID;
    private $cantidad;
    private $activo;

    public function __construct()
    {
        // Constructor vacío
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
?>
