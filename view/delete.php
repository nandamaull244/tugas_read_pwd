<?php
require_once '../controller/produkController.php';

$controller = new ProdukController();
$controller->deleteProduk($_GET['id']);

header("Location: index.php");
exit;
