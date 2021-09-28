<?php

namespace TeamBuilder\Model;

use Exception;
use PDO;

class DB
{

    public function __construct()
    {
    }

    private static function getPDO()
    {
        $DB = null;
        try {
            require '.env.php';
            $DB = new PDO($DSN, $USERNAME, $PASSWORD);
        } catch (Exception $exception) {
            throw new Exception("An exception has occurred when trying to connect to the database!");
        }

        $DB->exec("set names utf8");
        $DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $DB;
    }

    /** This method is used for executing "select" querys
     * @param $query - The SQL query
     * @param $params - The parameters
     * @param $multirecord - Bool - Do we want multiple raws ?
     * @return array|null
     */
    public static function select($query, $params, $multirecord)
    {

        $DB = self::getPDO();
        try {
            $statement = $DB->prepare($query);     //Préparer la requête
            $statement->execute($params);       //Exécuter la requête
            if ($multirecord)       //Si on veut récuperer plusieurs données
            {
                $queryResult = $statement->fetchAll(PDO::FETCH_ASSOC);  //Alors on fait un fetchAll
            } else {
                $queryResult = $statement->fetch(PDO::FETCH_ASSOC);     //Sinon on fait un fetch simple
            }
            $DB = null;
            return $queryResult;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }


    public static function selectMany($query, $params = [])
    {
        return self::select($query, $params, true);
    }


    public static function selectOne($query, $params = [])
    {
        return self::select($query, $params, false);
    }

    /**
     * @param $query - The SQL query
     * @param array $params - The parameters
     * @return bool
     * @throws Exception - SQL exceptions
     */
    public static function insert($query, $params = [])
    {
        $DB = self::getPDO();
        try {
            $statement = $DB->prepare($query);     //Préparer la requête
            $statement->execute($params);       //Exécuter la requête
            return $DB->lastInsertId();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }

    }

    /**
     * @param $query - The SQL query
     * @param array $params - The parameters
     * @return bool|null
     */
    public static function execute($query, $params = [])
    {
        $DB = self::getPDO();
        try {
            $statement = $DB->prepare($query);     //Préparer la requête
            $statement->execute($params);       //Exécuter la requête
            $DB = null;
            return true;
        } catch (PDOException $e) {
            error_log($e->getMessage());
            return null;
        }
    }


}

