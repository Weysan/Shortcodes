<?php
namespace Shortcodes;

/**
 * Description of Button
 *
 * @author Raphael GONCALVES <raphael@couleur-citron.com>
 */
class Button
{
    
    private $name;
    
    private $js_plugin;
    
    public function __construct($name)
    {
        $this->name = $name;
    }
    
    public function addPlugin($uri_js_plugin)
    {
        $this->js_plugin = $uri_js_plugin;
    }
    
    public function register()
    {
        add_filter('mce_external_plugins', array($this, 'add_tinymce_plugin'));
        add_filter('mce_buttons', array($this, 'register_button'));
        
        /* remove cache */
        add_filter( 'tiny_mce_version', array($this, 'refresh_mce'));
    }
    
    public function add_tinymce_plugin($plugin_array)
    {
        $plugin_array[$this->name] = $this->js_plugin;
        return $plugin_array;
    }
    
    public function register_button($buttons)
    {
        array_push($buttons, "|", $this->name);
        return $buttons;
    }
    
    public function refresh_mce($ver)
    {
        $ver += 3;
        return $ver;
    }
}
