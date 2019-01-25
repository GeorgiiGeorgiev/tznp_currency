<?php

try{

    $db = DB::getInstance();

    $connection = $db->getConnection();

    $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $request = "DROP TABLE IF EXISTS `currency`.`settings`";

    $connection->exec($request);

    echo "Удаление таблицы settings прошло успешно.\n";

}catch(PDOException $e){

    echo $e->getMessage();

//    exit();

}