<?
/**
 * Конфигурация приложения и фреймворка в целом
 * 
 */
if(!defined('VERSION')){exit();} # Защита
# Настройки движка
define('LANG', 'ru');                               # Язык фреймворка ошибок
define('TEST_MODE', TRUE);                          # Режим тестирования
define('URL','http://'.$_SERVER['HTTP_HOST'].'/');  # HTTP-адрес сайта
define('WWW', FALSE);                               # Оставлять доступ к сайту через www.site.loc
define('LOAD_ROMENS', TRUE);                        # Создавать ли объект с классом Romens

# Настройки базы данных
define('BASE_CONFIG_PHP',FALSE); # Если у вас настройки для подключения к базе данных прописаны в php.ini или в .htaccess то укажите этот параметр
define('BASE','MySQL');          # Поддержка: MySQL, SQLite, PostgreSQL. Если этого параметра нет, то база использоваться не будет во всё приложении.
define('BASE_DRIVER', 'MySQL');  # Желательно выбрать PDO, но если вы хотите работать с другим драйвером то укажите.
define('BASE_NUMBER', 1);        # Кол-во баз с которыми вы будете работать.
define('ROMENSBASE',TRUE);
# Настройки вывода
define('COMPRESS', FALSE);  # Сжимать данные перед отправкой или нет
define('CHARSET' , 'UTF-8'); # Кодировка. Настоятельно использовать только UTF-8

/** 
 * Настройки базы данных
 * 
 * Если вы используете SQLite то укажите путь.
 * 
 */
define('BASE_HOST'  , 'localhost'); # Сервер хранения базы данных
define('BASE_PATH'  , 'app/base/mybase.php'); # Путь к базе данных. Если база данных это SQLite  
define('BASE_LOGIN' , 'root'); # Логин пользователя
define('BASE_PASS'  , ''); # Пароль
define('BASE_PREFIX', ''); # Префикс таблиц
define('BASE_PORT'  , ''); # Порт
define('BASE_BASE'  , 'user32052_romens_user , base_number_2'); # Представленны две базы

/** 
 * Настройки роутера
 * 
 * DYNAMIC - На каждый паттерн свой обработчик
 * ^Пример: http://romens.ru/feed.php?lol=true  => http://romens.ru/app/feed.php
 * STATIC - Паттерны игнорируются и запрос напрямую идёт к обработчику 
 * ^Пример: http://romens.ru/feed.php  => http://romens.ru/app/feed.php?lol=true
 * 
 * В переменной "app" вводятся данные для роутера.
 * При STATIC этот параметр не нужен.
 */ 
define('ROUTER'     , 'DYNAMIC');
# Роутинг
$app = array(
    '/index/'=>'index.php', # Укажите ПАТТЕРН => Исполняемый файл
    '/favicon.png/'=>'http://habrahabr.ru/favicon.ico' # Укажите ПАТТЕРН => Ссылка
);

/**
 * Настройки параметров для локализации приложения
 * 
 * Пока не надо ничего менять
 */
define('APP_LANG_METHOD',   'JSON_FILE');
define('APP_LANG_FORMAT',   'JSON');
define('APP_LANG_PREFIX',   '');
define('APP_LANG_PATTERN',  '');
define('APP_LANG_EXT',      'json');

/**
 * Выбор обработчиков
 */
define('APP_VIEW_HTML',     'RomensViewHTML');
define('APP_MODEL',         'RomensModel');
define('APP_BASE',          'Romens'.strtoupper(BASE));
define('APP_BASE_START',    DIR_LIB.'class.romensmysql.php');

/**
 * Настройка обработчика View
 */
define('VIEW_TAG_PATTERN',  '{\[(.*)\]\}');
define('VIEW_TAG_START',    '{[');
define('VIEW_TAG_END',      ']}');