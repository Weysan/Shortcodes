<?php
namespace Shortcodes\Types\Slide;

use \Shortcodes\Types\SCInterface;
use \Shortcodes\Types\ScSanitize;

/**
 * Description of Slide
 *
 * @author Raphael GONCALVES <raphael@couleur-citron.com>
 */
class Slide extends ScSanitize implements SCInterface
{
    public function filter($atts, $content = null)
    {
        $content = self::clean($content, '<img><br><b><strong><u><em><ul><li>');
        
        
        if(count($atts) && isset($atts['titre'])){
            $content = str_replace('[article]', '[article titre="'.$atts['titre'].'"]', $content);
        }
        
        
        $returnContent = '<div class="swiper-slide">';
        $returnContent .= do_shortcode($content);
        $returnContent .= '</div>';
        
        return $returnContent;
    }
}
