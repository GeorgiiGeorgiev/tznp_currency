<?php

class Settings extends Controller
{
    public function actionStore()
    {
        $result = ['success' => false,'error' => '','response' => []];

        try {

            $getMaxRecords = $_POST['maxRecords'] ?? null;

            $getCurrencyType = $_POST['currencyType'] ?? null;

            $maxRecords = !is_null($getMaxRecords) && is_numeric($getMaxRecords) ? $getMaxRecords : null;

            $currencyType = !is_null($getCurrencyType) && is_array($getCurrencyType) ? $getCurrencyType : null;

            if($maxRecords || $currencyType) {

                $settings = Setting::find();

                if ($settings) {

                    $stopOperation = false;

                    if ($maxRecords && $maxRecords > 0) {

                        $settings->setMaxRecords($maxRecords);

                    }else{

                        $result['error'] = 'Количетсво записей должны быть больше 0.';

                        $stopOperation = true;

                    }

                    if ($currencyType && !empty($currencyType)) {

                        $handleTypes = array_keys($currencyType);

                        $settings->setCurrencyType($handleTypes);

                    }else{

                        $result['error'] = 'еобходимо выбрать хотябы один тип валюты.';

                        $stopOperation = true;

                    }

                    if(!$stopOperation){

                        $settings->save();

                        $result['success'] = true;

                    }

                }

            }

        }catch(Exception $e){

            $result['error'] = $e->getMessage();

        }

        echo json_encode($result);
    }
}