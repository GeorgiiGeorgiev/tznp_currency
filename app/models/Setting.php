<?php

class Setting extends Model
{
    const TABLE_NAME = 'settings';

    public $id;

    public $currencyType;

    public $maxRecords;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;

        $this->currencyType = $data['currencyType'] ?? null;

        $this->maxRecords = $data['maxRecords'] ?? null;
    }

    public function getId():int
    {
        return $this->id;
    }

    public function getMaxRecords():int
    {
        return $this->maxRecords;
    }

    public function getCurrencyType(bool $asArray = true)//: array || string
    {
        return $asArray ? json_decode($this->currencyType,true) : $this->currencyType;
    }

    public function setMaxRecords(int $records)
    {
        $this->maxRecords = $records;
    }

    public function setCurrencyType(array $types)
    {
        $this->currencyType = json_encode($types);
    }

    protected function _insert()
    {
        $db = DB::getInstance();

        $connection = $db->getConnection();

        $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $request = $connection->prepare("
                    INSERT INTO " . self::TABLE_NAME . "(currencyType, maxRecords)
                    VALUES (:currencyType, :maxRecords)"
        );

        $request->bindParam(':currencyType', $this->getCurrencyType(false));

        $request->bindParam(':maxRecords', $this->getMaxRecords());

        $request->execute();
    }

    protected function _update()
    {
        $db = DB::getInstance();

        $connection = $db->getConnection();

        $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $request = $connection->prepare("UPDATE " . self::TABLE_NAME . " SET maxRecords=:maxRecords, currencyType=:currencyType WHERE id=:id");

        $request->bindParam(':currencyType', $this->getCurrencyType(false));

        $request->bindParam(':maxRecords', $this->getMaxRecords());

        $request->bindParam(':id', $this->getId());

        $request->execute();
    }

    public static function setDefaultSettings()
    {
        $maxRecords = 15;

        $currencyTypeInsert = [];

        $allCurrencyTypeApi = Api::conversationTypes();

        if($allCurrencyTypeApi) {

            foreach ($allCurrencyTypeApi['results'] as $type) {

                if (array_key_exists('id', $type)) {

                    $currencyTypeInsert[] = strtolower($type['id']);

                }

            }

        }

        $allCurrencyType = $allCurrencyTypeApi['results'];

        $db = DB::getInstance();

        $connection = $db->getConnection();

        $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $request = $connection->prepare("INSERT INTO " . self::TABLE_NAME . "(maxRecords, currencyType) VALUES (:maxRecords, :currencyType)");

        $request->bindParam(':maxRecords', $maxRecords);

        $request->bindParam(':currencyType', json_encode($currencyTypeInsert));

        $request->execute();
    }

}