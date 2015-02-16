<?php
namespace Shortcodes\Types\Figure;

use \Shortcodes\Types\SCInterface;
use \Shortcodes\Types\ScSanitize;

/**
 * Shortcode Manager Figure
 * [figure]
 * content
 * [/figure]
 *
 * @author Raphael GONCALVES <raphael@couleur-citron.com>
 */
class Figure extends ScSanitize implements SCInterface
{
    public function filter($atts, $content = null)
    {
        
        $content = self::clean($content, '<h3><p><hr><img><b><strong><u><em><span>');
        
        $returnContent = '<figure>';
        $returnContent .= do_shortcode($content);
        $returnContent .= '</figure>';
        
        return $returnContent;
    }
}
