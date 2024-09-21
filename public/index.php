<?php
require '../vendor/autoload.php';
require '../config/database.php';
require '../app/helpers/GuzzleHelper.php';
require '../app/models/ProductModel.php';
require '../app/controllers/FileController.php';
require '../app/controllers/DataController.php';

// Route handler for the application
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    switch ($_POST['action']) {
        case 'data-update':
            $controller = new FileController();
            $controller->downloadAndImport();
            break;
        case 'add':
            $controller = new DataController();
            $controller->updateOrderAmount($_POST['number'], $_POST['action']);
            break;
        case 'clear':
            $controller = new DataController();
            $controller->updateOrderAmount($_POST['number'], $_POST['action']);
            break;
        default:
            break;
    }
}

if($_SERVER['REQUEST_METHOD'] === 'GET') {
    $controller = new DataController();
    if(isset($_GET['options'])) {
        $controller->optionsPage();
    }  else if(isset($_GET['empty'])) {
        $controller->deleteProducts();
        header( "refresh:1; url=index.php" );
    } else {
        $controller->index();
    }
}
?>

