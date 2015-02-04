<?php
namespace Shortcodes\Types\Article;

use \Shortcodes\Types\SCInterface;
use \Shortcodes\Types\ScSanitize;

/**
 * ShortCode manager Article :
 * [article]
 * content
 * [/article]
 *
 * @author Raphael
 */
class Article extends ScSanitize implements SCInterface
{
    public function filter($atts, $content = null)
    {
        
        $content = self::clean($content, '<h2>,<p>,<hr>,<img>,<h3>,<a>');
        
        $returnContent = '';
        if(count($atts) && isset($atts['titre'])){
            $returnContent .= '<article><h1>';
            $returnContent .= '<div class="center">';
            $returnContent .= '<a href="#_" class="precedent"></a>';
            $returnContent .= '<a href="#_" class="suivant"></a>';
            $returnContent .= '</div>';
            $returnContent .= $atts['titre'].'</h1>';
        }
        
        $returnContent .= '<div class="conteneur">';
        $returnContent .= do_shortcode($content);
        $returnContent .= '</div>';
        
        if(count($atts) && isset($atts['titre'])){
            $returnContent .= '</article>';
        }
        
        return $returnContent;
    }
}
