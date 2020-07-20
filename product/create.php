<?php
// required headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// get database connection
include_once '../config/database.php';

// instantiate product object
include_once '../objects/product.php';

$database = new Database();
$db = $database->getConnection();

$product = new Product($db);

// get posted data
$data = json_decode(file_get_contents("php://input"));

// make sure data is not empty
if(
    !empty($data->tipo) &&
    !empty($data->nombre) &&
    !empty($data->serial) &&
    !empty($data->marca) &&
    !empty($data->garantia) &&
    !empty($data->proveedor) &&
    !empty($data->cantidad) &&
    !empty($data->p_compra) &&
    !empty($data->p_venta) &&
    !empty($data->material)
){

    // set product property values
    $product->tipo = $data->tipo;
    $product->nombre = $data->nombre;
    $product->serial = $data->serial;
    $product->marca = $data->marca;
    $product->garantia = $data->garantia;
    $product->proveedor = $data->proveedor;
    $product->cantidad = $data->cantidad;
    $product->p_compra = $data->p_compra;
    $product->p_venta = $data->p_venta;
    $product->material = $data->material;

    // create the product
    if($product->create()){

        // set response code - 201 created
        http_response_code(201);

        // tell the user
        echo json_encode(array("message" => "Product was created."));
    }

    // if unable to create the product, tell the user
    else{

        // set response code - 503 service unavailable
        http_response_code(503);

        // tell the user
        echo json_encode(array("message" => "Unable to create product."));
    }
}

// tell the user data is incomplete
else{

    // set response code - 400 bad request
    http_response_code(400);

    // tell the user
    echo json_encode(array("message" => "Unable to create product. Data is incomplete."));
}
?>