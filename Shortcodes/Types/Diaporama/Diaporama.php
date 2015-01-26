<?php
namespace Shortcodes\Types\Diaporama;

use \Shortcodes\Types\SCInterface;
use \Shortcodes\Types\ScSanitize;

/**
 * Description of Diaporama
 *
 * @author Raphael GONCALVES <raphael@couleur-citron.com>
 */
class Diaporama extends ScSanitize implements SCInterface
{
    public function filter($atts, $content = null)
    {
        
        $content = self::clean($content, '<img><br>');
        
        if(self::countSlide($content) === 1){
            return self::oneSlide($content);
        } else {
            return self::multipleSlide($content, $atts);
        }
    }
    
    protected function countSlide($slides)
    {
        $aSlides = explode('[/slide]', $slides);
        
        foreach($aSlides as $key => $slide){
            if(trim($slide) === '')
                unset($aSlides[$key]);
        }
        
        return count($aSlides);
        
    }
    
    protected function oneSlide($content)
    {
        $content = str_replace(array('[slide]', '[/slide]'), '', $content);
        
        $returnContent = '<div class="header">';
        $returnContent .= do_shortcode($content);
        $returnContent .= '</div>';
        
        return $returnContent;
    }
    
    protected function multipleSlide($content, $atts)
    {
        global $iteration;
        
        if(!isset($iteration)) $iteration = 0;
        $iteration++;
        
        if(count($atts) && $atts['type'] == 'text'){ return self::globalDiaporama($content, $atts); }
        
        $returnContent = '<article class="clearfix header swiper-container" id="swiper-container'.$iteration.'">';
        $returnContent .= '<div class="content_descriptif">';
        if(count($atts)){
            $returnContent .= '    <p class="entete">'.$atts['titre'].'</p>';
        }
        $returnContent .= '    <div class="paginations" id="pagination'.$iteration.'"></div>';
        $returnContent .= '</div>';
        $returnContent .= '<div class="swiper-wrapper">';
        $returnContent .= do_shortcode($content);
        $returnContent .= '</div>';
        $returnContent .= '</article>';
        
        $returnContent .= '<script type="text/javascript">';
        
        $returnContent .= <<<EOD
        $(function(){
            var mySwiper$iteration = $('#swiper-container$iteration').swiper({
                mode:'horizontal',
                loop: false,
                autoplay: 0,
                calculateHeight: true,
                onInit: function(swiper){
                    $('#pagination$iteration a img').show();
                    $('#pagination$iteration .goToSlide'+swiper.activeLoopIndex+' img').hide();
                },
                onSlideChangeEnd: function(swiper){
                    $('#pagination$iteration a img').show();
                    $('#pagination$iteration .goToSlide'+swiper.activeLoopIndex+' img').hide();
                }
            });

            /* CLICK SUR BOUTON DE LA PAGINATION */
                $('.paginations a').click(function(){
                    var elementSlide = $(this).attr('class');
                    var indexSlide = elementSlide.replace(/[^0-9]/g, '');
                    mySwiper$iteration.swipeTo(indexSlide);
                });

        });

        /* CREATION PAGINATION SWIPER + MINIATURES */
        var cpt$iteration = 0;
        $('#swiper-container$iteration .swiper-wrapper .swiper-slide').each(function(){
            if($('#pagination$iteration').length != 0){
                    var imageElement = $(this).find('img').attr('src');
                    var html = $('#pagination$iteration').html();
                    $('#pagination$iteration').html(html+'<a href="#_" class="goToSlide'+cpt$iteration+'"><img src="'+imageElement+'" alt="" /></a>');
                    cpt$iteration++;
            }
        });
EOD;
        $returnContent .= '</script>';
        
        return $returnContent;
    }
    
    protected function globalDiaporama($content, $atts)
    {
        global $iteration;
        
        if(!isset($iteration)) $iteration = 0;
        $iteration++;
        
        $returnContent = '<div id="swiper-container'.$iteration.'" class="swiper-global">';
        $returnContent .= '<div class="swiper-wrapper">';
        $returnContent .= do_shortcode($content);
        $returnContent .= '</div>';
        $returnContent .= '</div>';
        
        $returnContent .= '<script type="text/javascript">';
        
        $returnContent .= <<<EOD
    $(function(){
    	var cptSlide = 0;
    	$('#swiper-container$iteration > .swiper-wrapper > .swiper-slide').each(function(){
    		cptSlide++;
    	});
    	var mySwiper$iteration = $('#swiper-container$iteration').swiper({
            mode:'horizontal',
            loop: false,
            autoplay: 0,
            calculateHeight: true,
            simulateTouch: false,
            onInit: function(){
            	if(mySwiper$iteration.activeIndex == 0 || mySwiper$iteration.activeIndex == -0){
		    		$('#swiper-container$iteration .precedent').addClass('disable');
		    	} else {
		    		$('#swiper-container$iteration .precedent').removeClass('disable');
		    	}
		    	if(mySwiper$iteration.activeIndex == (cptSlide - 1)){
		    		$('#swiper-container$iteration .suivant').addClass('disable');
		    	} else {
		    		$('#swiper-container$iteration .suivant').removeClass('disable');
		    	}
            },
            onSlideChangeStart: function(){
            	if(mySwiper$iteration.activeIndex == 0 || mySwiper$iteration.activeIndex == -0){
		    		$('#swiper-container$iteration .precedent').addClass('disable');
		    	} else {
		    		$('#swiper-container$iteration .precedent').removeClass('disable');
		    	}
		    	if(mySwiper$iteration.activeIndex == (cptSlide - 1)){
		    		$('#swiper-container$iteration .suivant').addClass('disable');
		    	} else {
		    		$('#swiper-container$iteration .suivant').removeClass('disable');
		    	}
            }
        });

        $('.precedent').click(function(){
        	mySwiper$iteration.swipePrev();
        });

        $('.suivant').click(function(){
        	mySwiper$iteration.swipeNext();
        });
    });
EOD;
        
        $returnContent .= '</script>';
        
        return $returnContent;
    }
}
