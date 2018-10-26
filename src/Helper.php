<?php
namespace RD\WP;


/**
 * Define constants
 */

if ( ! \defined( 'RDWP_RDH_TEMPLATES' ) && \function_exists( 'get_template_directory' ) ) {
    define( "RDWP_RDH_TEMPLATES", get_template_directory() . '/templates' );
}
if ( ! \defined('RDWP_RDH_TEMPLATES') ) return;



/**
 * Helper functions
 *
 * css_stringify:
 * inline_styles:
 *      Array to css string
 * classes:
 *      Array of html class to string
 *
 *
 */
class Helper {

    /**
     * Stringify css properties
     */
    private static function css_stringify( $prop, $value, $pattern = "%s: %s;" ) {
        $css = '';
        if ( $value ) {
        	if (is_array($value)){
        		foreach( $value as $v ){
        			$css .= sprintf($pattern, $prop, $v);
        		}
        	}else{
        		$css .= sprintf($pattern, $prop, $value);
        	}
        }
    	return $css;
    }

    /**
     * Return html ready css style
     */
    public static function inline_styles( $styles = array() ){
    	if( empty( $styles ) || ! is_array( $styles ) )
    		return '';
    	$output = '';
    	$i = 0;

    	foreach ( $styles as $key => $val ) {
    		$i++;
    		switch ($key) {
    			case 'background-image':
    				$search = 'url(';
    				if (substr(trim($val), 0, strlen($search)) === $search){
    					$output .= self::css_stringify($key, $val);
    				}else{
    					$output .= self::css_stringify($key, $val,"%s: url('%s');");
    				}
    				break;
    			default:
    				$output .= self::css_stringify($key, $val);
    				break;
    		}
    	}
    	return $output;
    }

    /**
     * Merge array of classes to string
     */
    public static function classes( $classes, $prepend = '' ) {
        return $prepend . ' ' . implode( " ", $classes );
    }

    /**
     * Load a template file.
     * @param   string  $file   Name of the template. No need to include .php
     * @param   array   $args   Args to be available on template
     * @return  string
     */
    public static function template( $file, $args = array() ) {
        if(is_array($args))
    		extract($args);
    	ob_start();


    	$path =  RDWP_RDH_TEMPLATES . '/' . preg_replace("/\.php$/", '', $file) . '.php' ;
        require($path);
    	return ob_get_clean();
    }


    /**
     * Generate 2x img tag from attachment
     * @param   integer     $id     WP Attachment ID
     * @param   string      $size   Default: full
     * @return  string
     */
    public static function img2x( $id, $size = 'full') {
        $URL = wp_get_attachment_image_src( $id, $size );
        if ( $URL ) {
            $tag = sprintf( '<img src="%1$s" srcset="%1$s 2x" width="%2$s" height="%3$s">', $URL[0], $URL[1]/2, $URL[2]/2);
            return $tag;
        }
        return false;
    }



    /**
     * Collect printed text and return it as string
     * @param   mixed   $function
     * @param   array   $variables  array of variables that needs to available
     * @return  string
     */
    public static function echo2string( $__function, $__variables = array() ) {
        ob_start();
        if ( is_callable( $__function ) ) {            
            $__function( $__variables );
        }
        return ob_get_clean();
    }

    /**
     * Insert array in given position
     * @param   array   $array
     * @param   integer|string   $position
     * @param   mixed   $insert
     * @return  array
     */
    public static function array_insert(&$array, $position, $insert) {
        if (is_int($position)) {
            array_splice($array, $position, 0, $insert);
        } else {
            $pos   = array_search($position, array_keys($array));
            $array = array_merge(
                array_slice($array, 0, $pos),
                $insert,
                array_slice($array, $pos)
            );
        }
        return $array;
    }
}
