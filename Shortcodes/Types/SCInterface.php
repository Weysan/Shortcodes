<?php
namespace Shortcodes\Types;

/**
 * Description of SCInterface
 *
 * @author Raphael GONCALVES <raphael@couleur-citron.com>
 */
interface SCInterface
{
    public function filter($atts, $content = null);
}
