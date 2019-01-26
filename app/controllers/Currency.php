<?php

class Currency extends Controller
{
    public function actionIndex()
    {
        $settings = Setting::find();

        $settingsTypes = $settings->getCurrencyType(true);

        natsort($settingsTypes);

        $maxRecords = $settings->getMaxRecords();

        $history = History::findAll(['createDate','desc'],$maxRecords);

        $allTypesApi = Api::conversationTypes();

        if(array_key_exists('results',$allTypesApi)) $allTypes = $allTypesApi['results'];

        $this->view->render('currency',
            [
                'history' => $history,
                'allTypes' => $allTypes ?? [],
                'settingsTypes' => $settingsTypes,
                'maxRecords' => $maxRecords,
            ]
        );
    }
}