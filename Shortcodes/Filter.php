<?php
namespace Shortcodes;

/**
 * Register new shortcodes
 *
 * @author Raphael GONCALVES <raphael@couleur-citron.com>
 */
class Filter
{
    static function register($aCodes)
    {
        foreach($aCodes as $tag => $class){            
            add_shortcode( $tag, array( "Shortcodes\Types\\$class\\$class", 'filter' ) );
        }
    }
}
