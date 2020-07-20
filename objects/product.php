<?php
class Product{

    // database connection and table tipo
    private $conn;
    private $table_tipo = "articulos";

    // object properties
    public $id;
    public $tipo;
    public $nombre;
    public $serial;
    public $marca;
    public $garantia;
    public $proveedor;
    public $cantidad;
    public $p_compra;
    public $p_venta;
    public $material;

    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }
    // read products
function read(){

    // select all query
    $query = "SELECT
                p.id, p.tipo, p.nombre, p.serial, p.marca, p.garantia, p.proveedor, p.cantidad, p.p_compra, p.p_venta ,p.material
            FROM
                " . $this->table_tipo . " p
            ORDER BY
                p.id DESC";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // execute query
    $stmt->execute();

    return $stmt;
}
// create product
function create(){

    // query to insert record
    $query = "INSERT INTO
                " . $this->table_tipo . "
            SET
                tipo=:tipo, nombre=:nombre, serial=:serial, marca=:marca, garantia=:garantia, proveedor=:proveedor, cantidad=:cantidad, p_compra=:p_compra, p_venta=:p_venta, material=:material";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->tipo=htmlspecialchars(strip_tags($this->tipo));
    $this->nombre=htmlspecialchars(strip_tags($this->nombre));
    $this->serial=htmlspecialchars(strip_tags($this->serial));
    $this->marca=htmlspecialchars(strip_tags($this->marca));
    $this->garantia=htmlspecialchars(strip_tags($this->garantia));
    $this->proveedor=htmlspecialchars(strip_tags($this->proveedor));
    $this->cantidad=htmlspecialchars(strip_tags($this->cantidad));
    $this->p_compra=htmlspecialchars(strip_tags($this->p_compra));
    $this->p_venta=htmlspecialchars(strip_tags($this->p_venta));
    $this->material=htmlspecialchars(strip_tags($this->material));

    // bind values
    $stmt->bindParam(":tipo", $this->tipo);
    $stmt->bindParam(":nombre", $this->nombre);
    $stmt->bindParam(":serial", $this->serial);
    $stmt->bindParam(":marca", $this->marca);
    $stmt->bindParam(":garantia", $this->garantia);
    $stmt->bindParam(":proveedor", $this->proveedor);
    $stmt->bindParam(":cantidad", $this->cantidad);
    $stmt->bindParam(":p_compra", $this->p_compra);
    $stmt->bindParam(":p_venta", $this->p_venta);
    $stmt->bindParam(":material", $this->material);

    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;

}
// used when filling up the update product form
function readOne(){

    // query to read single record
    $query = "SELECT
                p.id, p.tipo, p.nombre, p.serial, p.marca, p.garantia, p.proveedor, p.cantidad, p.p_compra, p.p_venta ,p.material
            FROM
                " . $this->table_tipo . " p
            WHERE
                p.id = ?
            LIMIT
                0,1";

    // prepare query statement
    $stmt = $this->conn->prepare( $query );

    // bind id of product to be updated
    $stmt->bindParam(1, $this->id);

    // execute query
    $stmt->execute();

    // get retrieved row
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    // set values to object properties
    $this->tipo = $row['tipo'];
    $this->nombre = $row['nombre'];
    $this->serial = $row['serial'];
    $this->marca = $row['marca'];
    $this->garantia = $row['garantia'];
    $this->proveedor = $row['proveedor'];
    $this->cantidad = $row['cantidad'];
    $this->p_compra = $row['p_compra'];
    $this->p_venta = $row['p_venta'];
    $this->material = $row['material'];
}
// update the product
function update(){

    // update query
    $query = "UPDATE
                " . $this->table_tipo . "
            SET
                tipo=:tipo,
                nombre=:nombre,
                serial=:serial,
                marca=:marca,
                garantia=:garantia,
                proveedor=:proveedor,
                cantidad=:cantidad,
                p_compra=:p_compra,
                p_venta=:p_venta,
                material=:material
            WHERE
                id = :id";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->tipo=htmlspecialchars(strip_tags($this->tipo));
    $this->nombre=htmlspecialchars(strip_tags($this->nombre));
    $this->serial=htmlspecialchars(strip_tags($this->serial));
    $this->marca=htmlspecialchars(strip_tags($this->marca));
    $this->garantia=htmlspecialchars(strip_tags($this->garantia));
    $this->proveedor=htmlspecialchars(strip_tags($this->proveedor));
    $this->cantidad=htmlspecialchars(strip_tags($this->cantidad));
    $this->p_compra=htmlspecialchars(strip_tags($this->p_compra));
    $this->p_venta=htmlspecialchars(strip_tags($this->p_venta));
    $this->material=htmlspecialchars(strip_tags($this->material));
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind new values
    $stmt->bindParam(':tipo', $this->tipo);
    $stmt->bindParam(':nombre', $this->nombre);
    $stmt->bindParam(':serial', $this->serial);
    $stmt->bindParam(':marca', $this->marca);
    $stmt->bindParam(':garantia', $this->garantia);
    $stmt->bindParam(':proveedor', $this->proveedor);
    $stmt->bindParam(':cantidad', $this->cantidad);
    $stmt->bindParam(':p_compra', $this->p_compra);
    $stmt->bindParam(':p_venta', $this->p_venta);
    $stmt->bindParam(':material', $this->material);
    $stmt->bindParam(':id', $this->id);

    // execute the query
    if($stmt->execute()){
        return true;
    }

    return false;
}
// delete the product
function delete(){

    // delete query
    $query = "DELETE FROM " . $this->table_tipo . " WHERE id = ?";

    // prepare query
    $stmt = $this->conn->prepare($query);

    // sanitize
    $this->id=htmlspecialchars(strip_tags($this->id));

    // bind id of record to delete
    $stmt->bindParam(1, $this->id);

    // execute query
    if($stmt->execute()){
        return true;
    }

    return false;
}
// search products
function search($keywords){

    // select all query
    $query = "SELECT
                p.id, p.tipo, p.nombre, p.serial, p.marca, p.garantia, p.proveedor, p.cantidad, p.p_compra, p.p_venta ,p.material
            FROM
                " . $this->table_tipo . " p
            WHERE
                p.nombre LIKE ? OR p.serial LIKE ? OR p.proveedor LIKE ?
            ORDER BY
                p.nombre DESC";

    // prepare query statement
    $stmt = $this->conn->prepare($query);

    // sanitize
    $keywords=htmlspecialchars(strip_tags($keywords));
    $keywords = "%{$keywords}%";

    // bind
    $stmt->bindParam(1, $keywords);
    $stmt->bindParam(2, $keywords);
    $stmt->bindParam(3, $keywords);

    // execute query
    $stmt->execute();

    return $stmt;
}
}
?>