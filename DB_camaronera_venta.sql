CREATE DATABASE camaronera_venta;
CREATE TABLE usuarios(
	id int primary key AUTO_INCREMENT,
    nombre VARCHAR(100),
    email VARCHAR(100),
    usuario VARCHAR(50),
    password VARCHAR(200),
    categoria VARCHAR(50),
    estado int,
    fecha_regis VARCHAR(30)
);
CREATE TABLE producto(
	id int primary key AUTO_INCREMENT,
    nombre VARCHAR(150),
    descripcion TEXT,
    unidad_medida VARCHAR(50),
    categoria VARCHAR(50),
    fecha VARCHAR(15),
    hora VARCHAR(15),
   	usuario_id int
);
CREATE TABLE venta(
	id int primary key AUTO_INCREMENT,
    numero_venta VARCHAR(50),
    monto FLOAT(8,2),
    saldo FLOAT(8,2),
    fecha VARCHAR(15),
    hora VARCHAR(15),
    tipo_venta VARCHAR(50),
    tipo_pago VARCHAR(50),
    usuario_id int
);
CREATE TABLE detalle_venta(
	id int primary key AUTO_INCREMENT,
    numero_venta VARCHAR(50),
    cantidad INT,
    precioUnitario FLOAT(8,2),
    producto_id INT,
    venta_id INT,
    usuario_id int
);
CREATE TABLE abonos(
	id int primary key AUTO_INCREMENT,
    numero_venta VARCHAR(50),
    numero_recibo VARCHAR(50),
    monto_abono FLOAT(8,2),
    tipo_pago VARCHAR(50),
    fecha VARCHAR(15),
    hora VARCHAR(15),
    venta_id INT,
    usuario_id INT
);
CREATE TABLE compra(
	id int primary key AUTO_INCREMENT,
    nombre_proveedor VARCHAR(150),
    descripcion TEXT,
    monto FLOAT(8,2),
    saldo FLOAT(8,2),
    producto_id INT,
    tipo_pago VARCHAR(50),
    fecha VARCHAR(15),
    hora VARCHAR(15),
    usuario_id INT
);