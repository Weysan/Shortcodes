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
        
        
        if(isset($_POST) && !empty($_POST) && preg_match('#error#', $retour)){
            $clean['name'] = filter_var($_POST['name_user'], FILTER_DEFAULT);
            $clean['lastname'] = filter_var($_POST['lastname'], FILTER_DEFAULT);
            $clean['company'] = filter_var($_POST['company'], FILTER_DEFAULT);
            $clean['mail'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            
            $clean['country'] = filter_var($_POST['country'], FILTER_DEFAULT);
            
            $clean['phone'] = filter_var($_POST['phone'], FILTER_DEFAULT);
            
            $clean['city'] = filter_var($_POST['city'], FILTER_DEFAULT);
            
            $clean['message'] = nl2br( filter_var($_POST['message'], FILTER_DEFAULT) );
        }
        
        $returnContent .= '<a name="form-contact">&nbsp;</a>';
        $returnContent .= '<form method="post" action="'.  get_the_permalink($post->ID).'#form-contact">';
        $returnContent .= '<input type="text" placeholder="First Name*" id="name" '
                . 'name="name_user" value="';
        
        if(isset($clean['name']) && !empty($clean['name'])) $returnContent .= $clean['name'];
        else $returnContent .= 'First Name*';
        
        $returnContent .= '" '
                . 'onfocus="if(this.value==\'First Name*\')this.value=\'\';">';
        
        
        $returnContent .= '<input type="text" placeholder="Last Name*" id="lastname" '
                . 'name="lastname" value="';
        
        if(isset($clean['lastname']) && !empty($clean['lastname'])) $returnContent .= $clean['lastname'];
        else $returnContent .= 'Last Name*';
        
        $returnContent .= '" '
                . 'onfocus="if(this.value==\'Last Name*\')this.value=\'\';">';
        
        $returnContent .= '<input type="text" placeholder="Your Email*" 
            id="email" name="email" value="';
        
        if(isset($clean['mail']) && !empty($clean['mail'])) $returnContent .= $clean['mail'];
        else $returnContent .= 'Your Email*';
        
        $returnContent .= '" 
            onfocus="if(this.value==\'Your Email*\')this.value=\'\';"><br />';
        
        $returnContent .= '<input type="text" placeholder="Your Country*" 
            id="country" name="country" value="';
        
        if(isset($clean['country']) && !empty($clean['country'])) $returnContent .= $clean['country'];
        else $returnContent .= 'Your Country*';
        
        $returnContent .= '" 
            onfocus="if(this.value==\'Your Country*\')this.value=\'\';">';
        
        $returnContent .= '<input type="text" placeholder="Your City" 
            id="city" name="city" value="';
        
        if(isset($clean['city']) && !empty($clean['city'])) $returnContent .= $clean['city'];
        else $returnContent .= 'Your City';
        
        $returnContent .= '" 
            onfocus="if(this.value==\'Your City\')this.value=\'\';">';
        
        $returnContent .= '<input type="text" placeholder="Your Phone" '
                . 'id="phone" name="phone" value="';
        
        if(isset($clean['phone']) && !empty($clean['phone'])) $returnContent .= $clean['phone'];
        else $returnContent .= 'Your Phone';
        
        $returnContent .= '" '
                . 'onfocus="if(this.value==\'Your Phone\')this.value=\'\';">';

        $returnContent .= '<input type="text" placeholder="Your Company" '
                . 'id="company" name="company" value="';
        
        if(isset($clean['company']) && !empty($clean['company'])) $returnContent .= $clean['company'];
        else $returnContent .= 'Your Company*';
        
        $returnContent .= '" '
                . 'onfocus="if(this.value==\'Your Company*\')this.value=\'\';">';
                
        $returnContent .= '<textarea onfocus="if(this.value==\'Your Message*\')this.value=\'\';" name="message">';
        
        if(isset($clean['message']) && !empty($clean['message'])) $returnContent .= $clean['message'];
        else $returnContent .= 'Your Message*';
        
        $returnContent .= '</textarea>';
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
            $clean['lastname'] = filter_var($_POST['lastname'], FILTER_DEFAULT);
            $clean['company'] = filter_var($_POST['company'], FILTER_DEFAULT);
            $clean['mail'] = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);
            
            $clean['country'] = filter_var($_POST['country'], FILTER_DEFAULT);
            
            $clean['phone'] = filter_var($_POST['phone'], FILTER_DEFAULT);
            if($clean['phone'] === false || $clean['phone'] == '' || $clean['phone'] == 'Your Phone') $clean['phone'] = 'none';
            
            $clean['city'] = filter_var($_POST['city'], FILTER_DEFAULT);
            if($clean['city'] === false || $clean['city'] == '' || $clean['city'] == 'Your City') $clean['city'] = 'none';
            
            $clean['message'] = nl2br( filter_var($_POST['message'], FILTER_DEFAULT) );

            if(in_array(false, $clean) ||
                    ( empty($clean['name']) || 'Your Name*' == $clean['name'] ) || 
                    ( empty($clean['lastname']) || 'Your Name*' == $clean['lastname'] ) || 
                    ( empty($clean['company']) || 'Your Company*' == $clean['company'] ) || 
                    ( empty($clean['mail']) || 'Your Email*' == $clean['mail'] ) || 
                    ( empty($clean['country']) || 'Your Country*' == $clean['country'] ) || 
                    ( empty($clean['message']) || 'Your Message*' == $clean['message'] )
                    ){
                return '<p class="error">Please check the form, it seems there are some errors.</p>';
            } else {
                $headers = "From: Delair Tech <contact@delair-tech.com>\r\n";
                $headers .= 'MIME-Version: 1.0' . "\r\n";
                $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
                
                $message .= '';
                foreach($clean as $name => $value){
                    $message .= '<strong>'.$name.' :</strong> ' . $value.'<br />';
                }
                
                if(!empty($message)){
                    $send = wp_mail($clean_to, $clean_subject, $message, $headers);
					//$send = mail($clean_to, $clean_subject, $message, $headers);
                    $id = self::save($clean['mail'], $message);
                    
                    if($send || $id){
                        return '<p class="validation">Your message has been sent.</p>';
                    } else {
                        //var_dump($send);
                        
                        return '<p class="error">An error occured during sending your email.</p>';
                    }
                } else {
                    return '<p class="error">An error occured.</p>';
                }
            }
        }
        return;
    }
    
    private function save($mail, $message){
        
        
        $post_id = wp_insert_post(
		array(
			'comment_status'	=>	'closed',
			'ping_status'		=>	'closed',
			'post_author'		=>	1,
			'post_title'		=>	$mail,
			'post_status'		=>	'publish',
			'post_type'		=>	'contact_content',
                        'post_content'          =>      $message
		)
	);
        
        return $post_id;
    }
}
