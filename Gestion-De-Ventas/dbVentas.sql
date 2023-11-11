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
    nombre_proveedor varchar(100),
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

INSERT INTO Usuario (dui, correo, nombre, rol, contrasena, activo)
VALUES ('987654321-0', 'admin@gmail.com', 'María González', 'admin', 'admin123', true);

INSERT INTO Usuario (dui, correo, nombre, rol, contrasena, activo)
VALUES ('456789123-0', 'gerente@gmail.com', 'Carlos Rodríguez', 'gerente', 'gerente123', true);

INSERT INTO Usuario (dui, correo, nombre, rol, contrasena, activo)
VALUES ('789123456-0', 'vendedor@gmail.com', 'Laura Martínez', 'vendedor', 'vendedor123', true);

-- Registro 1
INSERT INTO Categorias (nombre_categoria, descripcion, activo)
VALUES ('Electrónica', 'Productos electrónicos y gadgets', true);

-- Registro 2
INSERT INTO Categorias (nombre_categoria, descripcion, activo)
VALUES ('Ropa', 'Ropa de moda para todas las edades', true);

-- Registro 3
INSERT INTO Categorias (nombre_categoria, descripcion, activo)
VALUES ('Hogar', 'Artículos para el hogar y decoración', true);

-- Registro 1
INSERT INTO Proveedores (nombre_proveedor, contacto, direccion, activo)
VALUES ('Proveedor A', 'Juan Pérez', 'Calle 123, Ciudad A', true);

-- Registro 2
INSERT INTO Proveedores (nombre_proveedor, contacto, direccion, activo)
VALUES ('Proveedor B', 'María González', 'Avenida 456, Ciudad B', true);

-- Registro 3
INSERT INTO Proveedores (nombre_proveedor, contacto, direccion, activo)
VALUES ('Proveedor C', 'Carlos Rodríguez', 'Calle 789, Ciudad C', true);
