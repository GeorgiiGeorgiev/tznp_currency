<?php

abstract class Api
{
    public static function conversationCur_cur(string $convertFrom = '',string $convertTo = '',float $amount = 0,bool $save = true):float
    {
        $query = "?q=" . $convertFrom . "_" . $convertTo . "&compact=ultra";

        $currencyValue = json_decode(file_get_contents("http://free.currencyconverterapi.com/api/v5/convert" . $query), true);

        $result = round($currencyValue[$convertFrom . "_" . $convertTo] * $amount,2);

        if($save) {

            $history = new History(compact('convertFrom','convertTo','result','amount'));

            $history->save();

        }

        return $result;
    }

    public static function conversationTypes():array
    {
        return json_decode(file_get_contents("http://free.currencyconverterapi.com/api/v6/currencies"),true);
    }
}