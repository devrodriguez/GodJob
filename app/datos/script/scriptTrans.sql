--Crear tabla con primary key y llave foranea

CREATE TABLE `db_ordenes`.`cliente` (
  `CL_ID` INT NOT NULL AUTO_INCREMENT,
  `CL_Nombre` VARCHAR(50) NULL,
  `CL_Correo` VARCHAR(45) NULL,
  `SU_ID` INT NULL,
  PRIMARY KEY (`CL_ID`),
  UNIQUE INDEX `CL_Nombre_UNIQUE` (`CL_Nombre` ASC),
  INDEX `fk_sucursal_cliente_idx` (`SU_ID` ASC),
  CONSTRAINT `fk_sucursal_cliente`
    FOREIGN KEY (`SU_ID`)
    REFERENCES `db_ordenes`.`sucursal` (`SU_ID`)
    ON DELETE NO ACTION
    ON UPDATE NO ACTION);


-- Agregar llave foranea

ALTER TABLE `db_ordenes`.`producto` 
ADD INDEX `fk_producto_unidadmedida_idx` (`UM_ID` ASC);
ALTER TABLE `db_ordenes`.`producto` 
ADD CONSTRAINT `fk_producto_unidadmedida`
  FOREIGN KEY (`UM_ID`)
  REFERENCES `db_ordenes`.`unidadmedida` (`UM_ID`)
  ON DELETE NO ACTION
  ON UPDATE NO ACTION;

-- ## Agregar Autoincrement ## --
ALTER TABLE `db_ordenes`.`categoria` 
CHANGE COLUMN `CA_ID` `CA_ID` INT(11) NOT NULL AUTO_INCREMENT ;

-- ## Agregar AUTO_INCREMENT a llave primaria ## --
ALTER TABLE `db_ordenes`.`orden` 
DROP FOREIGN KEY `fk_orden_estadoorden`;

ALTER TABLE `db_ordenes`.`estadoorden` 
CHANGE COLUMN `EO_ID` `EO_ID` INT(11) NOT NULL AUTO_INCREMENT;

ALTER TABLE `db_ordenes`.`orden` 
ADD CONSTRAINT `fk_orden_estadoorden`
 FOREIGN KEY (`EO_ID`)
 REFERENCES `db_ordenes`.`estadoorden` (`EO_ID`)
 ON DELETE NO ACTION
 ON UPDATE NO ACTION;

-- ## Cadena de conexion PHP ## --
$host="127.0.0.1";
$port=3306;
$socket="";
$user="root";
$password="";
$dbname="db_ordenes";

$con = new mysqli($host, $user, $password, $dbname, $port, $socket)
	or die ('Could not connect to the database server' . mysqli_connect_error());

//$con->close();

-- ## Realizar Consulta ## ---

$query = "CALL ConsultarProducto()";

if ($stmt = $con->prepare($query)) {
    $stmt->execute();
    $stmt->bind_result($field1, $field2);
    while ($stmt->fetch()) {
        //printf("%s, %s\n", $field1, $field2);
    }
    $stmt->close();
}