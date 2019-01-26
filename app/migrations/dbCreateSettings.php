<?php

try{

    $db = DB::getInstance();

    $connection = $db->getConnection();

    $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $request = "CREATE TABLE IF NOT EXISTS " . Setting::TABLE_NAME . "
                 (
                  `id` INT NOT NULL  AUTO_INCREMENT,
                   `maxRecords` TINYINT NOT NULL DEFAULT '10' ,
                    `currencyType` TEXT CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                     PRIMARY KEY (`id`)
                      ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";

    $connection->exec($request);

    //echo "Создание таблицы settings прошло успешно.\n";

}catch(PDOException $e){

    echo $e->getMessage();

//    exit();

}