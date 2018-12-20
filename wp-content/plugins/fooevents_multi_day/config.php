<?php if ( ! defined( 'ABSPATH' ) ) exit;

class Fooevents_Multiday_Events_Config {
    
    public $scriptsPath;
    public $stylesPath;
    public $templatePath; 
    public $templatePathTheme;
    public $pluginDirectory;
    public $classPath;
    public $path;
    public $pluginFile;

    /**
     * Initialize configuration variables to be used as object.
     * 
     */
    public function __construct() {
        
        $this->pluginDirectory = 'fooevents_multiday_events';
        $this->scriptsPath = plugin_dir_url(__FILE__) .'js/';
        $this->stylesPath = plugin_dir_url(__FILE__) .'css/';
        $this->templatePath = plugin_dir_path( __FILE__ ).'templates/';
        $this->templatePathTheme = get_stylesheet_directory().'/'.$this->pluginDirectory.'/templates/';
        $this->classPath = plugin_dir_path( __FILE__ ).'classes/';
        $this->path = plugin_dir_path( __FILE__ );
        $this->pluginFile = $this->path.'fooevents-multi-day.php';
        
    }

    
}