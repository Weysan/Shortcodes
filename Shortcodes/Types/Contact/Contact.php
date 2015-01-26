<?php
namespace Shortcodes\Types\Contact;

use \Shortcodes\Types\SCInterface;
use \Shortcodes\Types\ScSanitize;

/**
 * Description of Contact
 *
 * @author Raphael GONCALVES <raphael@couleur-citron.com>
 */
class Contact extends ScSanitize implements SCInterface
{
    public function filter($atts, $content = null)
    {
        global $post;
        
        $content = self::clean($content);

        $retour = self::sendMail($atts);
        
        $returnContent = '';
        
        if(!empty($retour))
            $returnContent .= $retour;
        
        $returnContent .= '<form method="post" action="'.  get_the_permalink($post->ID).'">';
        $returnContent .= '<input type="text" placeholder="Your Name*" id="name" '
                . 'name="name_user" value="Your Name*" '
                . 'onfocus="if(this.value==\'Your Name*\')this.value=\'\';">';
        $returnContent .= '<input type="text" placeholder="Your Company*" '
                . 'id="company" name="company" value="Your Company*" '
                . 'onfocus="if(this.value==\'Your Company*\')this.value=\'\';">';
        $returnContent .= '<input type="text" placeholder="Your Email*" 
            id="email" name="email" value="Your Email*" 
            onfocus="if(this.value==\'Your Email*\')this.value=\'\';">';
        $returnContent .= '<input type="text" placeholder="Your Phone*" '
                . 'id="phone" name="phone" value="Your Phone*" '
                . 'onfocus="if(this.value==\'Your Phone*\')this.value=\'\';">';
        $returnContent .= '<textarea name="message">Your Message*</textarea>';
        $returnContent .= '<input type="submit" id="submit" name="submit" value="Send">';
        $returnContent .= '</form>';
        
        return $returnContent;
        
    }
    
    private function sendMail($atts)
    {
        
        if(!isset($atts['to']) || empty($atts['to']) || 
                !filter_var($atts['to'], FILTER_VALIDATE_EMAIL)){
            throw new \Exception('You have to specify a email destination.');
        }
        if(!isset($atts['subject'])){
            $atts['subject'] = 'Formulaire de contact';
        }
        
        $clean_to = filter_var($atts['to'], FILTER_VALIDATE_EMAIL);
        $clean_subject = filter_var($atts['to'], FILTER_DEFAULT);
        
        if(isset($_POST) && !empty($_POST)){
            $clean['name'] = filter_var($_POST['name_user'], FILTER_DEFAULT);
            $clean['company'] = filter_var($_POST['company'], FILTER_DEFAULT);
            $clean['mail'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            $clean['phone'] = filter_var($_POST['phone'], FILTER_DEFAULT);
            $clean['message'] = nl2br( filter_var($_POST['message'], FILTER_DEFAULT) );

            if(in_array(false, $clean)){
                return '<p class="error">Le formulaire présente des erreur.</p>';
            } else {
                $headers = "From: Delair Tech <no-reply@delairtech.com>\r\n";
                $headers .= 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                
                $message .= '';
                foreach($clean as $name => $value){
                    $message .= '<strong>'.$name.' :</strong> ' . $value.'<br />';
                }
                
                if(!empty($message)){
                    $send = wp_mail($clean_to, $clean_subject, $message, $headers);
                    if($send)
                        return '<p class="validation">Votre message a été transmis.</p>';
                    else
                        return '<p class="error">Une erreur s\'est produite '
                    . 'lors de l\'envoie du mail.</p>';
                } else {
                    return '<p class="error">Une erreur s\'est produite '
                    . 'lors de l\'envoie du mail.</p>';
                }
            }
        }
        return;
    }
}
