<?
# Защита
if (!defined('VERSION')){exit();}
# Тестовый режим
error_reporting(E_ALL);

if(defined('TEST_MODE')){
    if(!TEST_MODE){
        error_reporting(0);
    }
}
# Подключение модулей
    # Функции ядра
    include DIR_CORE_MODULE.'func.php';
    # Подключаем настройки
    include DIR_SETTINGS.'config.php';
    # Оптимизируем настройки
    include DIR_DEFAULT.'config.php';
    # HTACCESS-правки (см. докуоментацию)
    include DIR_CORE_MODULE.'htaccess.php';
    # Регистр
    include DIR_CORE_MODULE.'regisrtry.php';
    # Определение клиента
    include DIR_CORE_MODULE.'identclient.php';
    # Контроллёр
    include DIR_CORE_MODULE.'controller.php';

# Включаем возможность краткого обращения
define('R', 'romens',TRUE);   

# Запускаем контроллер
$controller = new Controller();

# Подключение библиотек с помощью Контроллера
include_once DIR_SETTINGS.'library.php';
$controller->library($library_list);

# print_var()
if (CheckFlag('TEST_MODE')){
    include _filter(DIR_CORE.'devlib/print_var.php');
}   else{
    function print_var($var){}
}

# MODEL
if (CheckFlag('APP_MODEL')) {
    $controller->load_model(APP_MODEL);
    
    if(CheckFlag('LOAD_MODEL')) {
        $romens = $controller->model;
    }
}

# VIEW
if (CheckFlag('APP_VIEW_JSON')) {
    $controller->load_view(APP_VIEW_JSON);
}
if (CheckFlag('APP_VIEW_HTML')) {
    $controller->load_view(APP_VIEW_HTML);
}

# Start
ob_start();

#
$controller->view->model = $controller->model;
$controller->model->view = $controller->view;

# Подключаем начальный файл приложения
include DIR_APP.'_start.php';

# Подключаем настройки приложения
include DIR_APP.'config.php';

# Определяем парметр вызова
if($_SERVER['REQUEST_URI']){
	$uri = str_replace('?'.$_SERVER['QUERY_STRING'],'', $_SERVER['REQUEST_URI']);
} else {
	$uri = $_SERVER['REDIRECT_URL'];
}

@define('URI', substr($uri,1));

$router = DIR_CORE_MODULE.'router/'.ROUTER.'.php';

if(is_file($router)){
    include $router;
    
    if(defined('ROUTING_STATUS') != TRUE){
        if(defined('NOT_ROUTING_FILE')){
            include _filter(DIR_APP_PAGE.NOT_ROUTING_FILE);
        }
    }
}

# Подключаем конечный файл приложения
if(!defined('NO_END_APP')){
    include _filter(DIR_APP.'_end.php');
}