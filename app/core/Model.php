<?php

abstract class Model
{
    const TABLE_NAME = '';

    public static function find(int $id = 1)
    {
        $result = null;

        try {

            $db = DB::getInstance();

            $connection = $db->getConnection();

            $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $request = $connection->prepare("SELECT * FROM " . static::TABLE_NAME . " WHERE id = $id");

            $request->execute();

            $fetch = $request->fetch(PDO::FETCH_ASSOC);

            $result = $fetch ? new static($fetch) : null;

        }catch (PDOException $e){

            $result = $e->getMessage();

        }

        return $result;
    }

    public static function findAll(array $order = [],int $limit = 0):array
    {
        $result = [];

        $limitRequest = "";

        $orderRequest = "";

        if($limit){

            $limitRequest = "LIMIT $limit";

        }

        if(!empty($order)){

            $orderRequest = "ORDER BY " . $order[0] . " " . strtoupper($order[1]);

        }

        try{

            $db = DB::getInstance();

            $connection = $db->getConnection();

            $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

            $request = $connection->prepare("SELECT * FROM " . static::TABLE_NAME . " " . $orderRequest . " " . $limitRequest);

            $request->execute();

            $fetchAll = $request->fetchAll();

            if($fetchAll) {

                foreach ($fetchAll as $fetch) {

                    $result[] = new static($fetch);

                }

            }

        }catch (PDOException $e){

            $result[] = $e->getMessage();

        }

        return $result;
    }

    public function save()
    {
        if (isset($this->id)) {

            $this->_update();

        } else {

            $this->_insert();

        }
    }

    protected function _update(){}

    protected function _insert(){}

    public function delete(){}
}