<?php
class CurrencyController {
    public function index() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $baseCurrency = $_SESSION['base_currency'] ?? 'EUR';
    // логика получения курсов
    $url = "https://api.frankfurter.app/latest?from=$baseCurrency";

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    $data = json_decode($response, true);

    // передай данные в view
    require ROOT . '/app/views/currency/index.php';
}

}
?>