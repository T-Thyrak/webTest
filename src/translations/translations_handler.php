<?php
    class TranslationHandler {
        private $translations;

        public function __construct(array $translations) {
            $this->translations = $translations;
        }

        public function get(string $key, ?array $params = []): string {
            if (array_key_exists($key, $this->translations)) {
                $translations = $this->translations[$key];
            } else {
                $translations = $key;
            }

            $trans = $this->format($translations, $params);

            return $trans;
        }

        public static function format(string $str, ?array $params = []): string {
            if (!is_null($params)) {
                foreach ($params as $key => $value) {
                    $str = str_replace("{{" . $key . "}}", $value, $str);
                }
            }

            return $str;
        }
    }
?>