<?php
class Config{

      public static function DB_HOST(){
        return Config::get_env("DB_HOST", "remotemysql.com");
      }
      public static function DB_USERNAME(){
        return Config::get_env("DB_USERNAME", "WUci3qINay");
      }
      public static function DB_PASSWORD(){
        return Config::get_env("DB_PASSWORD", "7C6ctqsXO0");
      }
      public static function DB_SCHEME(){
        return Config::get_env("DB_SCHEME", "WUci3qINay");
      }
      public static function DB_PORT(){
        return Config::get_env("DB_PORT", "3306");
      }

    const JWT_SECRET = "mB7ZcTvqwu2SkTGX6Kxd";
    const JWT_TOKEN_TIME = 604800;
    const DATE_FORMAT = "Y:m:d H:i:s";

    public static function get_env($name, $default){
        return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
    }
}
