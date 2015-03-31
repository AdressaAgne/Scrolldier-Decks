<?php
include_once("ajax_prepend.php");
if(isset($_SESSION['rank']) && $_SESSION['rank']<=2) {
    $SettingsController->updateSetting($twitch['id'], $twitch['name'], $_POST['twitchactive'], $_POST['hosted'], $twitch['type']);
} else {
    header("location: /forbidden");
}
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

