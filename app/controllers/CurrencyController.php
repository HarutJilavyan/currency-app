<?php

class CurrencyController {
    public function index() {
        $base = 'EUR'; // базовая валюта по умолчанию

        // Проверка, есть ли другая валюта в сессии
        if (isset($_SESSION['base_currency'])) {
            $base = $_SESSION['base_currency'];
        }

        // Запрос через cURL
        $url = "https://api.frankfurter.app/latest?from=$base";
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $result = curl_exec($ch);

        if ($result === false) {
            die('Ошибка запроса: ' . curl_error($ch));
        }

        $data = json_decode($result, true);
        curl_close($ch);

        // Простой вывод (в будущем — через view)
        echo "<h1>Курсы валют относительно $base</h1>";
        echo "<ul>";
        foreach ($data['rates'] as $currency => $rate) {
            echo "<li>1 $base = $rate $currency</li>";
        }
        echo "</ul>";
    }
}
