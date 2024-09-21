<?php

use GuzzleHttp\Client;

class GuzzleHelper {
    /**
     * Download the excel file
     * SSL verification is set to FALSE
     */
    public function downloadFile($url, $saveTo) {
        $client = new Client();
        $response = $client->get($url, ['sink' => $saveTo, 'verify' => false]);

        if ($response->getStatusCode() === 200) {
            return true;
        }
        return false;
    }

    /**
     * Get currency exchange rate
     * EUR / GBP
     * get api key from .env file
     */
    public function getExchangeRate() {
        $dotenv = Dotenv\Dotenv::createImmutable('../');
        $dotenv->load();

        $api_key = $_ENV['CURRENCYLAYER_API_KEY'];

        try {
            $api_endpoint = "https://api.currencylayer.com/live?access_key=".$api_key."&source=EUR&currencies=GBP";

            $client = new Client();
            $response = $client->get($api_endpoint, ['verify' => false]);

            if ($response->getStatusCode() === 200) {
                $exchangeRateData = json_decode($response->getBody());
                $exchangeRate = $exchangeRateData->quotes->EURGBP;

                return $exchangeRate;
            }
            return false;

        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
