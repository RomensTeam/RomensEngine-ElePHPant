<?
if(!defined('DIR')){exit();} // Защита
// Настройки сайта по умолчанию
$site_meta = array(
    'title'=>'Remus: Первый Сайт',
    'description'=>'Первый сайт сделанный на Remus',
    'keywords'=>'Remus',
    'favicon'=>URL.'favicon.ico',
    'preview-image'=>URL.'preview_image.png'
);
Controller::Model()->setTheme('default'); // Выбираем тему