<?php
$eSettings = Setting::find();

if(!$eSettings){

    Setting::setDefaultSettings();

}
