<?php

class Route
{
    private $controller = 'CurrencyController';
    private $method = 'index';
    private $params = [];

    // 🔄 Обработка запроса смены валюты
    private function handleBaseCurrency(){
        require_once 'app/library/Database.php';
        $db = new Database();
        $db->logAccess();
        parse_str($_SERVER['QUERY_STRING'] ?? '', $queryParams);
        if (isset($queryParams['currency'])) {
            $currency = strtoupper($queryParams['currency']);
            var_dump($currency);
            
            if (preg_match('/^[A-Z]{3}$/', $currency)) {
                $_SESSION['base_currency'] = $currency;
                var_dump($_SESSION['base_currency']);
                header('Location: /');
                exit;
            } else {
                http_response_code(400);
                echo "Неверный код валюты.";
                exit;
            }
        } else {
            http_response_code(400);
            echo "Не передан параметр currency.";
            exit;
        }
    }

    public function run()
    {
        $requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $url = explode('/', trim($requestUri, '/'));

        // ⚠️ Обработка /base?currency=XXX
        if ($url[0] === 'base') {
            $this->handleBaseCurrency();
            return; // 💡 Обязательно остановить выполнение
        }

        // 🧠 Контроллер по умолчанию
        if (empty($url[0])) {
            $url[0] = 'currency';
        }

        // 🗂 Путь к контроллеру
        $controllerFile = ROOT . '/app/controllers/' . ucfirst($url[0]) . 'Controller.php';

        // ⚠️ Проверка на существование контроллера
        if (file_exists($controllerFile)) {
            $this->controller = ucfirst($url[0]) . 'Controller';
            unset($url[0]);
        } else {
            http_response_code(404);
            echo "Страница не найдена (контроллер не существует)";
            exit;
        }

        require_once ROOT . '/app/controllers/' . $this->controller . '.php';
        $this->controller = new $this->controller;

        // ⚙️ Проверка метода
        if (isset($url[1]) && method_exists($this->controller, $url[1])) {
            $this->method = $url[1];
            unset($url[1]);
        }

        $this->params = $url ? array_values($url) : [];

        call_user_func_array([$this->controller, $this->method], $this->params);
    }

    
}
