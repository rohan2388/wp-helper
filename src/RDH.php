<?php
namespace RD\WP;
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
class RDH {
    /**
     * Stringify css properties
     */
    static private function css_stringify( $prop, $value, $pattern = "%s: %s;" ) {
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
    static function inline_styles( $styles = array() ){
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
    static function classes( $classes ) {
        return implode( " ", $classes );
    }

}
