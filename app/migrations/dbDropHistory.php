<?php

try{

    $db = DB::getInstance();

    $connection = $db->getConnection();

    $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $request = "DROP TABLE IF EXISTS `currency`.`history`";

    $connection->exec($request);

    echo "Удаление таблицы history прошло успешно.\n";

}catch(PDOException $e){

    echo $e->getMessage();

//    exit();

}