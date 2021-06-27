<?php
class Config{

      public static function DB_HOST(){
        return Config::get_env("DB_HOST", "web-project-database-do-user-9448170-0.b.db.ondigitalocean.com");
      }
      public static function DB_USERNAME(){
        return Config::get_env("DB_USERNAME", "amela");
      }
      public static function DB_PASSWORD(){
        return Config::get_env("DB_PASSWORD", "wrioqlkqbovqyzd5");
      }
      public static function DB_SCHEME(){
        return Config::get_env("DB_SCHEME", "webprogramming");
      }
      public static function DB_PORT(){
        return Config::get_env("DB_PORT", "25060");
      }

    const JWT_SECRET = "mB7ZcTvqwu2SkTGX6Kxd";
    const JWT_TOKEN_TIME = 604800;
    const DATE_FORMAT = "Y:m:d H:i:s";

    public static function get_env($name, $default){
        return isset($_ENV[$name]) && trim($_ENV[$name]) != '' ? $_ENV[$name] : $default;
    }
}
