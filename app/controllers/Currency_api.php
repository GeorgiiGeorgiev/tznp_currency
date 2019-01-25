<?php


class Currency_api extends Controller
{
    public function actionConversation()
    {
        $result = ['success' => false,'error' => '','result' => 0,'data' => []];

        try {

            $getConvertFrom = $_GET['convertFrom'] ?? null;

            $getConvertTo = $_GET['convertTo'] ?? null;

            $getAmount = $_GET['amount'] ?? 0;

            $convertFrom = !is_null($getConvertFrom) && is_string($getConvertFrom) ? strtoupper($getConvertFrom) : null;

            $convertTo = !is_null($getConvertTo) && is_string($getConvertTo) ? strtoupper($getConvertTo) : null;

            $amount = is_numeric($getAmount) ? $getAmount : 0;

            if ($convertFrom && $convertTo) {

                if ($convertFrom != $convertTo) {

                    if ($amount > 0) {

                        $result['result'] = Api::conversationCur_cur($convertFrom,$convertTo,$amount);

                        array_push($result['data'], compact('convertFrom', 'convertTo', 'amount'));

                        $result['success'] = true;

                    } else {

                        $result['error'] = 'Количество валюты должно быть больше 0';

                    }

                } else {

                    $result['error'] = "Нельзя конвертировать " . $convertFrom . " в " . $convertTo;

                }

            } else {

                $result['error'] = 'Некорректно указаны единицы конвертации';

            }

        }catch(Exception $e){

            $result['error'] = $e->getMessage();

        }

        echo json_encode($result);
    }

    public function actionGetCurrencyTypes()
    {
        echo json_encode(Api::conversationTypes());
    }
}