<?php
class Language {
    private $language;
    private $translations;

    public function __construct() {
        // Проверяем, есть ли в сессии выбранный язык, если нет — выбираем по умолчанию
        $this->language = isset($_SESSION['language']) ? $_SESSION['language'] : 'en';
        $this->loadTranslations();
    }

    // Загружаем переводы из соответствующего файла
    private function loadTranslations() {
        $langFile = __DIR__ . "/../assets/lang/{$this->language}.php";
        if (file_exists($langFile)) {
            $this->translations = include($langFile);
        } else {
            // Если файл не существует, загружаем по умолчанию
            $this->translations = include(__DIR__ . "/../assets/lang/en.php");
        }
    }

    // Получаем перевод по ключу
    public function translate($key) {
        return isset($this->translations[$key]) ? $this->translations[$key] : $key;
    }

    // Устанавливаем язык
    public function setLanguage($lang) {
        $_SESSION['language'] = $lang;
        $this->language = $lang;
        $this->loadTranslations();
    }
}
