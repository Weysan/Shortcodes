<?php
namespace Shortcodes\Types\Image;

use \Shortcodes\Types\SCInterface;
use \Shortcodes\Types\ScSanitize;

/**
 * Description of Image
 *
 * @author Raphael GONCALVES <raphael@couleur-citron.com>
 */
class Image extends ScSanitize implements SCInterface
{
    public function filter($atts, $content = null)
    {
        
        $content = self::clean($content, '<img>,<br>');
        
        $returnContent = '<article class="clearfix header">';
        $returnContent .= do_shortcode($content);
        $returnContent .= '</article>';
        
        return $returnContent;
    }
}
