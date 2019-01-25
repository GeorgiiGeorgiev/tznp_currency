<?php

try{

    $db = DB::getInstance();

    $connection = $db->getConnection();

    $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

    $request = "CREATE TABLE IF NOT EXISTS `currency`.`history` 
                (
                 `id` INT NOT NULL AUTO_INCREMENT ,
                  `createDate` DATETIME NOT NULL ,
                   `amount` FLOAT NOT NULL ,
                    `convertFrom` VARCHAR(4)
                     CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                      `convertTo` VARCHAR(4) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
                       `result` FLOAT NOT NULL ,
                        PRIMARY KEY (`id`)
                        ) ENGINE = InnoDB CHARSET=utf8 COLLATE utf8_general_ci;";

    $connection->exec($request);

    //echo "Создание таблицы history прошло успешно.\n";

}catch(PDOException $e){

    echo $e->getMessage();

//    exit();

}