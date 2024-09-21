<?php
use PhpOffice\PhpSpreadsheet\IOFactory;

class ProductModel {
    private $conn;
    private $guzzleHelper;

    function __construct($db) {
        $this->conn = $db; // DB connection
        $this->guzzleHelper = new GuzzleHelper(); // Guzzel helper Class
    }

    /**
     * Import data from excel file to database table
     */
    function importData($filePath) {
        // Process excel file using phpoffice library
        $spreadsheet = IOFactory::load($filePath);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();

        // Insert query
        $insertQuery = "INSERT INTO products (number, name, bottlesize, price, priceGBP, timestamp, orderamount) 
                        VALUES (:number, :name, :bottlesize, :price, :priceGBP, :timestamp, :orderamount)";

        // Update query
        $updateQuery = "UPDATE products 
                        SET name = :name, bottlesize = :bottlesize, price = :price, priceGBP = :priceGBP, timestamp = :timestamp 
                        WHERE number = :number";

        // Count query to check if the product is already on table
        $checkExistenceQuery = "SELECT COUNT(*) FROM products WHERE number = :number";

        // Prepare queries
        $insertStmt = $this->conn->prepare($insertQuery);
        $updateStmt = $this->conn->prepare($updateQuery);
        $checkStmt = $this->conn->prepare($checkExistenceQuery);

        // Default values for additional columns
        $priceGBP = 0.00; // Default value for priceGBP
        $orderamount = 0; // Default value for orderamount
        $timestamp = date('Y-m-d H:i:s'); // Current timestamp

        // Get Exchange rate for EUR/GBP
        $exchangeRate = $this->guzzleHelper->getExchangeRate();

        // Automatically detect the first row of data
        // This was done because data rows not starting at begining of the file
        // There are 2 text lines above the data
        $dataRowIndex = null;
        foreach ($rows as $index => $row) {
            // Check if the required columns (e.g., number, name, bottlesize and price) are not empty
            // Also check number column contains a number
            // This logic will detect the first data row
            if (!empty($row[0]) && preg_match('/^[0-9]+$/', $row[0]) && !empty($row[1]) && !empty($row[4]) && !empty($row[5])) {
                // If columns are not empty and logic return true, assume this is the first data row
                $dataRowIndex = $index;
                break; // Stop searching once we find the first data row
            }
        }

        // If we found the first data row, lets start import from there
        if ($dataRowIndex !== null) {
            // Loop through the rows, starting from the first data row
            for ($i = $dataRowIndex; $i < count($rows); $i++) {
                $row = $rows[$i];

                // Map the relevant columns from the Excel file to the database fields
                $number = $row[0]; // Column 1 in Excel
                $name = $row[1] != null && $row[1] != "" ? $row[1] : "No Name"; // Column 2 in Excel
                $bottlesize = $row[3] != null && $row[3] != "" ? $row[3] : 0; // Column 4 in Excel
                $price = $row[4] != null && $row[4] != "" ? $row[4] : 0.00; // Column 5 in Excel
                $priceGBP = $price * $exchangeRate; // Calculate GBP value using the EUR exchange rate

                // Check if the record with the given number already exists
                $checkStmt->bindParam(':number', $number);
                $checkStmt->execute();
                $exists = $checkStmt->fetchColumn() > 0;

                if ($exists) {
                    // Update existing record
                    $updateStmt->bindParam(':number', $number);
                    $updateStmt->bindParam(':name', $name);
                    $updateStmt->bindParam(':bottlesize', $bottlesize);
                    $updateStmt->bindParam(':price', $price);
                    $updateStmt->bindParam(':priceGBP', $priceGBP);
                    $updateStmt->bindParam(':timestamp', $timestamp);
                    $updateStmt->execute();
                } else {
                    // Insert new record
                    $insertStmt->bindParam(':number', $number);
                    $insertStmt->bindParam(':name', $name);
                    $insertStmt->bindParam(':bottlesize', $bottlesize);
                    $insertStmt->bindParam(':price', $price);
                    $insertStmt->bindParam(':priceGBP', $priceGBP);
                    $insertStmt->bindParam(':timestamp', $timestamp);
                    $insertStmt->bindParam(':orderamount', $orderamount);
                    $insertStmt->execute();
                }
            }
        } else {
            // When there is no data to import
            echo "No data rows found.";
        }
    }

    /**
     * Get all products
     */
    function getAllData() {
        $query = "SELECT * FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC); // Return all results as associative array
    }

    /**
     * add 1 to order amount
     */
    function incrementOrderAmount($number) {
        $query = "UPDATE products SET orderamount = orderamount + 1 WHERE number = $number";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }

    /**
     * clear the order amount
     */
    function clearOrderAmount($number) {
        $query = "UPDATE products SET orderamount = 0 WHERE number = $number";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }

    /**
     * Get single product data
     */
    function getSingleProduct($number)
    {
        $query = "SELECT * FROM products WHERE number = $number";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
