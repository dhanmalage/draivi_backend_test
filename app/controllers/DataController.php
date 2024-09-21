<?php
class DataController {
    private $model;
    private $database;
    private $dbConnect;

    public function __construct() {
        $this->database = new Database();
        $this->dbConnect = $this->database->getConnection();
        $this->model = new ProductModel($this->dbConnect);        
    }

    /**
     * Fetch data from database table
     * Load index view with all product data
     */
    public function index() {
        // Fetch product data from the model
        $data = $this->model->getAllData();

        include '../app/views/products_view.php';
    }

    /**
     * Update order amount
     * add or clear
     */
    public function updateOrderAmount($number, $action) {
        if ($action == 'add') {
            $this->model->incrementOrderAmount($number);
        } elseif ($action == 'clear') {
            $this->model->clearOrderAmount($number);
        }

        $updatedProduct = $this->getProduct($number);

        echo json_encode(['status' => 'success', 'data' => $updatedProduct]);
        exit;
    }

    /**
     * Indernal function to get updated product
     * @private
     */
    private function getProduct($number)
    {
        return $this->model->getSingleProduct($number);
    }

    /**
     * Display options page
     */
    public function optionsPage()
    {
        include '../app/views/options_view.php';
    }

    /**
     * Delete records
     * Truncate table
     */
    public function deleteProducts()
    {
        return $this->model->deleteAllProducts();
    }
}
