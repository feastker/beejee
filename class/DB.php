<?php

class DB
{

    private static $pdo;

    static function connect()
    {
        $config = include DIR . 'config.php';

        self::$pdo = new PDO('mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['dbname'],
            $config['db']['user'], $config['db']['password'], [
                PDO::ATTR_STRINGIFY_FETCHES => false,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES "utf8";',
            ]);
    }

    static function query($sql, $data = [])
    {
        $stmt = self::$pdo->prepare($sql);
        $stmt->execute($data);

        return $stmt;
    }

    static function insert($sql, $data = [])
    {
        self::query($sql, $data);

        return self::$pdo->lastInsertId();
    }

    static function select($sql, $data = [], $multiple = false)
    {
        $result = self::query($sql, $data);

        if (!empty($multiple)) {
            $result = $result->fetchAll(\PDO::FETCH_CLASS);
        } else {
            $result = $result->fetchObject();
        }

        return $result;
    }
}