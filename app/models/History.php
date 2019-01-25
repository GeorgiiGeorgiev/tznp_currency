<?php

class History extends Model
{
    const TABLE_NAME = 'history';

    public $id;

    public $createDate;

    public $convertFrom;

    public $convertTo;

    public $amount;

    public $result;

    public function __construct(array $data = [])
    {
        $this->id = $data['id'] ?? null;

        $this->createDate = $data['createDate'] ?? date('Y-m-d H:i:s');

        $this->convertFrom = $data['convertFrom'] ?? null;

        $this->convertTo = $data['convertTo'] ?? null;

        $this->amount = $data['amount'] ?? null;

        $this->result = $data['result'] ?? null;
    }

    public function getId():int
    {
        return $this->id;
    }

    public function getCreateDate(bool $forOutput = false):string
    {
        return $forOutput ? date('d.m.Y H:i',strtotime($this->createDate)) : $this->createDate;
    }

    public function getConvertFrom():string
    {
        return strtoupper($this->convertFrom);
    }

    public function getConvertTo():string
    {
        return strtoupper($this->convertTo);
    }

    public function getAmount():float
    {
        return round($this->amount,2);
    }

    public function getResult():float
    {
        return round($this->result,2);
    }

    protected function setCreateDate(string $date)
    {
        $this->createDate = date('Y-m-d H:i:s',strtotime($date));
    }

    protected function setConvertFrom(string $currency)
    {
        $this->convertFrom = strtolower($currency);
    }

    protected function setConvertTo(string $currency)
    {
        $this->convertTo = strtolower($currency);
    }

    protected function setAmount(float $amount)
    {
        if(is_numeric($amount) && $amount > 0){

            $this->amount = $amount;

        }
    }

    protected function setResult(float $result)
    {
        if(is_numeric($result) && $result > 0){

            $this->result = $result;

        }
    }

    protected function _update(){}

    protected function _insert()
    {
        $db = DB::getInstance();

        $connection = $db->getConnection();

        $connection->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);

        $request = $connection->prepare("
                    INSERT INTO " . self::TABLE_NAME . "(createDate,convertFrom,convertTo,amount,result)
                    VALUES (:createDate, :convertFrom, :convertTo, :amount, :result)"
        );

        $request->bindParam(':createDate', $this->getCreateDate());

        $request->bindParam(':convertFrom', $this->getConvertFrom());

        $request->bindParam(':convertTo', $this->getConvertTo());

        $request->bindParam(':amount', $this->getAmount());

        $request->bindParam(':result', $this->getResult());

        $request->execute();
    }
}