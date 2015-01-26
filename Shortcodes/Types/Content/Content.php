<?php
namespace Shortcodes\Types\Content;

use \Shortcodes\Types\SCInterface;
use \Shortcodes\Types\ScSanitize;

/**
 * Description of Content
 *
 * @author Raphael
 */
class Content extends ScSanitize implements SCInterface
{
    public function filter($atts, $content = null)
    {
        
        $content = self::clean($content, '<br>');
        
        $returnContent = '<div class="legende">';
        $returnContent .= $content;
        $returnContent .= '</div>';
        
        return $returnContent;
        
    }
}