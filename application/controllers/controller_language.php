<?php

class Controller_Language extends Controller {
    public function action_set() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = json_decode(file_get_contents('php://input'), true);
            $language = $data['language'] ?? 'en';

            // Установите язык в сессии
            $_SESSION['language'] = $language;

            // Верните успешный ответ
            echo json_encode(['status' => 'success']);
            exit();
        }
    }
}
