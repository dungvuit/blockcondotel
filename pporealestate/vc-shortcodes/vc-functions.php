<?php

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

if ( ! function_exists( 'sky_vc_field_type_product_categories' ) ) :

	function sky_vc_field_type_product_categories( $settings, $value ) {
		$categories = get_categories( array( 'parent' => 0,'hide_empty' => 0, 'taxonomy'=>'product_category' ) );
		$class = 'wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '_field';
		$selected_values = explode( ',', $value );
		$html = array( '<div class="sky_vc_custom_param post_categories">' );
		$html[] = '  <input type="hidden" name="' . $settings['param_name'] . '" value="' . $value .
		          '" class="wpb_vc_param_value" />';
		$html[] = '  <select name="' . $settings['param_name'] . '-select" class="' . $class . '">';
		$html[] = '    <option value="all" ' . ( in_array( 'all', $selected_values ) ? 'selected="true"' : '' ) . '>' .
		          esc_html__( 'All', 'sky-game' ) . '</option>';
		foreach ( $categories as $category ) {
                    $html[] = '<option value="' . $category->term_id . '" ' .
                              ( in_array( $category->term_id, $selected_values ) ? 'selected="true"' : '' ) . '>';
                    $html[] = $category->name;
                    $html[] = '</option>';
                    $childrens = get_term_children($category->term_id, $category->taxonomy);
                    if ($childrens) {
                        foreach ($childrens as $children) {
                            $child = get_term_by('id', $children, $category->taxonomy);
                            $html[] = '<option value="' . $child->term_id . '" ' .
                                        ( in_array( $child->term_id, $selected_values ) ? 'selected="true"' : '' ) . '>';
                            $html[] = '-- ' . $child->name;
                            $html[] = '</option>';
                        }
                    }
		}

		$html[] = '  </select>';
		$html[] = '</div>';
		$html[] = '<script>';
		$html[] = '  jQuery("document").ready( function() {';
		$html[] = '	   jQuery( "select[name=\'' . $settings['param_name'] . '-select\']" ).click( function() {';
		$html[] = '      var selected_values = jQuery(this).find("option:selected").map(function(){ return this.value; }).get().join(",");';
		$html[] = '      jQuery( "input[name=\'' . $settings['param_name'] . '\']" ).val( selected_values );';
		$html[] = '	   } );';
		$html[] = '  } );';
		$html[] = '</script>';

		return implode( "\n", $html );
	}
	vc_add_shortcode_param( 'ppo_product_category', 'sky_vc_field_type_product_categories' );

endif;

if ( ! function_exists( 'sky_vc_field_type_project_categories' ) ) :

	function sky_vc_field_type_project_categories( $settings, $value ) {
		$categories = get_categories( array( 'parent' => 0,'hide_empty' => 0, 'taxonomy'=>'project_category' ) );
		$class = 'wpb-input wpb-select ' . $settings['param_name'] . ' ' . $settings['type'] . '_field';
		$selected_values = explode( ',', $value );
		$html = array( '<div class="sky_vc_custom_param post_categories">' );
		$html[] = '  <input type="hidden" name="' . $settings['param_name'] . '" value="' . $value .
		          '" class="wpb_vc_param_value" />';
		$html[] = '  <select name="' . $settings['param_name'] . '-select" class="' . $class . '">';
		$html[] = '    <option value="all" ' . ( in_array( 'all', $selected_values ) ? 'selected="true"' : '' ) . '>' .
		          esc_html__( 'All', 'sky-game' ) . '</option>';
		foreach ( $categories as $category ) {
                    $html[] = '<option value="' . $category->term_id . '" ' .
                              ( in_array( $category->term_id, $selected_values ) ? 'selected="true"' : '' ) . '>';
                    $html[] = $category->name;
                    $html[] = '</option>';
                    $childrens = get_term_children($category->term_id, $category->taxonomy);
                    if ($childrens) {
                        foreach ($childrens as $children) {
                            $child = get_term_by('id', $children, $category->taxonomy);
                            $html[] = '<option value="' . $child->term_id . '" ' .
                                        ( in_array( $child->term_id, $selected_values ) ? 'selected="true"' : '' ) . '>';
                            $html[] = '-- ' . $child->name;
                            $html[] = '</option>';
                        }
                    }
		}

		$html[] = '  </select>';
		$html[] = '</div>';
		$html[] = '<script>';
		$html[] = '  jQuery("document").ready( function() {';
		$html[] = '	   jQuery( "select[name=\'' . $settings['param_name'] . '-select\']" ).click( function() {';
		$html[] = '      var selected_values = jQuery(this).find("option:selected").map(function(){ return this.value; }).get().join(",");';
		$html[] = '      jQuery( "input[name=\'' . $settings['param_name'] . '\']" ).val( selected_values );';
		$html[] = '	   } );';
		$html[] = '  } );';
		$html[] = '</script>';

		return implode( "\n", $html );
	}
	vc_add_shortcode_param( 'ppo_project_category', 'sky_vc_field_type_project_categories' );

endif;

/**
 * Get post categories array
 *
 * @return array
 */
function ppo_sc_get_categories() {
    $args = array(
        'orderby' => 'id',
        'parent' => 0
    );
    $items = array();
    $items[esc_html__('All', SHORT_NAME)] = 'all';
    $categories = get_categories($args);
    if (isset($categories)) {
        foreach ($categories as $key => $cat) {
            $items[$cat->cat_name] = $cat->cat_ID;
            $childrens = get_term_children($cat->term_id, $cat->taxonomy);
            if ($childrens) {
                foreach ($childrens as $key => $children) {
                    $child = get_term_by('id', $children, $cat->taxonomy);
                    $items['-- ' . $child->name] = $child->term_id;
                }
            }
        }
    }

    return $items;
}

function ppo_sc_get_list_image_size() {
    global $_wp_additional_image_sizes;

    $sizes = array();
    $get_intermediate_image_sizes = get_intermediate_image_sizes();

    // Create the full array with sizes and crop info
    foreach ($get_intermediate_image_sizes as $_size) {

        if (in_array($_size, array('thumbnail', 'medium', 'large'))) {

            $sizes[$_size]['width'] = get_option($_size . '_size_w');
            $sizes[$_size]['height'] = get_option($_size . '_size_h');
            $sizes[$_size]['crop'] = (bool) get_option($_size . '_crop');
        } elseif (isset($_wp_additional_image_sizes[$_size])) {

            $sizes[$_size] = array(
                'width' => $_wp_additional_image_sizes[$_size]['width'],
                'height' => $_wp_additional_image_sizes[$_size]['height'],
                'crop' => $_wp_additional_image_sizes[$_size]['crop']
            );
        }
    }

    $image_size = array();
    $image_size[esc_html__("No Image", 'eduma')] = 'none';
    $image_size[esc_html__("Custom Image", 'eduma')] = 'custom_image';
    if (!empty($sizes)) {
        foreach ($sizes as $key => $value) {
            if ($value['width'] && $value['height']) {
                $image_size[$value['width'] . 'x' . $value['height']] = $key;
            } else {
                $image_size[$key] = $key;
            }
        }
    }

    return $image_size;
}