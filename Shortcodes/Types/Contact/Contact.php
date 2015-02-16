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
        
        $returnContent .= '<input type="text" placeholder="Your Country*" 
            id="country" name="country" value="Your Country*" 
            onfocus="if(this.value==\'Your Country*\')this.value=\'\';">';
        
        $returnContent .= '<input type="text" placeholder="Your City" 
            id="city" name="city" value="Your City" 
            onfocus="if(this.value==\'Your City\')this.value=\'\';">';
        
        $returnContent .= '<input type="text" placeholder="Your Phone" '
                . 'id="phone" name="phone" value="Your Phone" '
                . 'onfocus="if(this.value==\'Your Phone\')this.value=\'\';">';
        $returnContent .= '<textarea onfocus="if(this.value==\'Your Message*\')this.value=\'\';" name="message">Your Message*</textarea>';
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
        $clean_subject = filter_var($atts['subject'], FILTER_DEFAULT);
        
        if(isset($_POST) && !empty($_POST)){
            $clean['name'] = filter_var($_POST['name_user'], FILTER_DEFAULT);
            $clean['company'] = filter_var($_POST['company'], FILTER_DEFAULT);
            $clean['mail'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            
            $clean['country'] = filter_var($_POST['country'], FILTER_DEFAULT);
            
            $clean['phone'] = filter_var($_POST['phone'], FILTER_DEFAULT);
            if($clean['phone'] === false || $clean['phone'] == '' || $clean['phone'] == 'Your Phone') $clean['phone'] = 'none';
            
            $clean['city'] = filter_var($_POST['city'], FILTER_DEFAULT);
            if($clean['city'] === false || $clean['city'] == '' || $clean['city'] == 'Your City') $clean['city'] = 'none';
            
            $clean['message'] = nl2br( filter_var($_POST['message'], FILTER_DEFAULT) );

            if(in_array(false, $clean)){
                return '<p class="error">There is errors in the form.</p>';
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
                        return '<p class="validation">Your message has been sent.</p>';
                    else
                        return '<p class="error">An error occured.</p>';
                } else {
                    return '<p class="error">An error occured.</p>';
                }
            }
        }
        return;
    }
}
