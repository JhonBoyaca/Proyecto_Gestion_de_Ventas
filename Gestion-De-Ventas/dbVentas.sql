create database dbVentas;
use dbVentas;
create table Usuario(
	usuarioID int primary key auto_increment,
    dui varchar(12),
    correo varchar(100),
    nombre varchar(100),
    rol varchar(50),
    contrasena varchar(80),
    activo boolean
);
create table Categorias (
    categoriasID int primary key auto_increment,
    nombre_categoria varchar(100),
    descripcion varchar(500),
    activo boolean
);
create table Proveedores (
    ProveedoresID int primary key auto_increment,
    nombre varchar(100),
    contacto varchar(100),
    direccion varchar(500),
    activo boolean
);
create table Productos(
	productosID int primary key auto_increment,
    nombre varchar(100),
    codigo varchar(20),
    precio_compra decimal(30,2),
    precio_venta decimal(30,2),
    stock int,
    stock_min int,
    ProveedoresID int,
    categoriasID int,
    activo boolean,
    foreign key(ProveedoresID) references Proveedores(ProveedoresID),
	foreign key(categoriasID) references Categorias(categoriasID)
);
create table Ventas (
    ventasID int primary key auto_increment,
    fecha date,
    total decimal(30,2),
    usuarioID int,
    activo boolean,
    foreign key(usuarioID) references Usuario(usuarioID)
);
create table Detalle_ventas (
    detalleID int primary key auto_increment,
    ventasID int,
    productosID int,
    cantidad int,
    activo boolean,
    foreign key(ventasID) references Ventas(ventasID),
	foreign key(productosID) references Productos(productosID)
);