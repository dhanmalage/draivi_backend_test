<?php
class FileController {
    private $model;
    private $guzzleHelper;
    private $database;
    private $dbConnect;

    public function __construct() {
        $this->database = new Database();
        $this->dbConnect = $this->database->getConnection();
        $this->model = new ProductModel($this->dbConnect);
        $this->guzzleHelper = new GuzzleHelper();
    }

    /**
     * Download and Import excel file
     */
    public function downloadAndImport() {

        // Looing for .env at the root directory
        $dotenv = Dotenv\Dotenv::createImmutable('../');
        $dotenv->load();

        // Get URL from .env
        $url = $_ENV['IMPORT_FILE_URL'];

        $checkDIR = is_dir('temp') || mkdir('temp');
        $saveTo = 'temp/file.xlsx';

        // Download the file
        if ($this->guzzleHelper->downloadFile($url, $saveTo)) {
            // Import the data into the database
            $this->model->importData($saveTo);

            echo "File downloaded and data imported successfully!";
            echo "Redirecting in 3 seconds...";
            header( "refresh:3; url=index.php" );
        } else {
            // Error
            echo "Failed to download the file.";
            echo "Check .env file data.";
            echo "Redirecting in 5 seconds.....";
            header( "refresh:5; url=index.php" );
        }
    }
}
