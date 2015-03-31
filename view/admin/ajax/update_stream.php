<?php
include_once("ajax_prepend.php");

$SettingsController->updateSetting($twitch['id'], $twitch['name'], $_POST['twitchactive'], $_POST['hosted'], $twitch['type']);
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

