<?php
# Защита
if (!defined('DIR')) {
    exit();
}
/**
 *  Класс Model - Базовый класс
 *
 * @author Romens <romantrutnev@gmail.com>
 * @version 1.2
 */
class Model implements ModelInterface {
    /**
     * @var Lang
     */
    public $app_lang;
    public $var_app = array();
    public $pfc_status;
    public $base_list;
    public static $PDO = NULL;

    /* Настройки языка */
    public function app_lang($lang = null,$library = null) {
        if ($this->app_lang instanceof Lang){
            return $this->app_lang;
        }
        include_once DIR_CORE_MODULE.'Lang.php';
        $this->app_lang = new Lang($lang,$library);
		
        return $this->app_lang;
    }
    /* Взаимодействие с View */

    public function render(){
        include _filter(DIR_DEFAULT.'var_app.php');
        $array = array_merge(Lang::$lang,$this->var_app);
        $array = array_change_key_case($array, CASE_LOWER);

        Remus::View()->setData($array);

        $this->buffer = Remus::View()->render();
    }

    public function pattern($name=null, $block = false){
        if($block === TRUE){
            return VIEW_TAG_START.strtoupper(VIEW_BLOCK_TAG_NAME.$name).VIEW_TAG_END;
        }
        return VIEW_TAG_START.strtoupper($name).VIEW_TAG_END;
    }
    public function var_app($var = NULL, $value = NULL){
        if($var === NULL){
            return $this->var_app;
        }
        if(is_array($var)){$this->var_app = array_merge($this->var_app, $var);}
        else if(is_string($var) and is_null($value)){ return $this->var_app[$var]; } 
        else { $this->var_app[$var] = $value;}
        return $this;
    }

    public function getBlock($name){
        $block_path = RE_Theme::$dir_theme . 'block' . _DS . strtolower($name);
        if(!file_exists(_filter($block_path))){
            $block_path .= '.tpl';
        }
        $block_path = _filter($block_path);
        if(file_exists($block_path)){
            if(REMUSPANEL){
                RemusPanel::log('Использован блок: <span class="badge badge-info">'.$name.'</span>');
            }
            return file_get_contents($block_path);
        }
        else{
            if(REMUSPANEL) {RemusPanel::log ('Called block don\'t exsist: <b>'.$name.'</b><hr>'.$block_path, 'warning');}
            return FALSE;
        }
    }
    public function connect($comment = null){
        
        if(self::$PDO instanceof PDO){
            return self::$PDO;
        }
        
        $settings = array_change_key_case($this->load_settings(DIR_SETTINGS.BASE_SETTINGS_FILE));
        
        if( isset($settings['base'][strtolower(ENV)]) ){
            $settings = $settings['base'][strtolower(ENV)]['access'];
        } else {
            throw new RemusException(lang('not_settings_base_env'));
        }
        
        extract($settings);

        try {
            self::$PDO = new PDO("mysql:host=$host;dbname=$base", $login, $pass);
        } catch (PDOException $e) {
            throw new RemusException($e->getMessage());
        }
        
        if(REMUSPANEL){
            $trace = debug_backtrace(1,2);
            $sql = 'Открыто соединение с БД `<b>'.$host.'@'.$login.'</b>` к БД: `'.$base.'`.';
            if(!empty($comment))
                { $sql .= '<br>'.$comment;}
            RemusPanel::addData('query', array(
                'sql'       => $sql,
                'result'    => '',
                'trace'     => $trace[1]
            ));
        }
        return self::$PDO;
    }
    
    private function open_json($path){
        return open_json($path);
    }
        
    private function load_settings($path) {
        return load_settings($path);
    }
    
    public function __toString(){
        return 'Remus.'.VERSION;
    }
}
