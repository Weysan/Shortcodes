<?php
namespace Shortcodes\Types\Legend;

use \Shortcodes\Types\SCInterface;
use \Shortcodes\Types\ScSanitize;

/**
 * Shortcode Manager Legend:
 * [legend]
 * content
 * [legend]
 *
 * @author Raphael GONCALVES <raphael@couleur-citron.com>
 */
class Legend extends ScSanitize implements SCInterface
{
    public function filter($atts, $content = null)
    {
        
        $content = self::clean($content, '<h3><p><a><b><strong><u><em><ul><li>');
        
        $returnContent = '<figcaption><hr />';
        $returnContent .= $content;
        $returnContent .= '</figcaption>';
        
        return $returnContent;
    }
}
