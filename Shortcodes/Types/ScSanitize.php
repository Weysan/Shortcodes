<?php
namespace Shortcodes\Types;

/**
 * Description of ScSanitize
 *
 * @author Raphael GONCALVES <raphael@couleur-citron.com>
 */
abstract class ScSanitize
{
    protected function clean($content, $authorized_tags = null){
        
        $content = strip_tags ($content, $authorized_tags);
        
        if ( '</p>' == substr( $content, 0, 4 )
and '<p>' == substr( $content, strlen( $content ) - 3 ) )
	$content = substr( $content, 4, strlen( $content ) - 7 );
        
        $content = str_replace('<br />[', '[', $content);
        
        return $content;
        
    }
}
