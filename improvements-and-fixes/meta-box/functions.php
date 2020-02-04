<?php

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    defined('Vidsoe_Plugin') or die('No script kiddies please!');

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    add_filter('rwmb_meta_boxes', function($meta_boxes){
		$id = basename(dirname(__FILE__));
		$fields = array();
        $fields[] = array(
            'id' => 'mb_add_bootstrap_to_fields',
            'name' => 'Add Bootstrap',
            'on_label' => '<i class="dashicons dashicons-yes"></i>',
            'std' => 1,
            'type' => 'switch',
        );
        $fields[] = array(
            'id' => 'mb_add_custom_fields',
            'name' => 'Add custom fields',
            'on_label' => '<i class="dashicons dashicons-yes"></i>',
            'std' => 1,
            'type' => 'switch',
        );
        $fields[] = array(
            'id' => 'mb_add_floating_labels_to_fields',
            'name' => 'Add floating labels',
            'on_label' => '<i class="dashicons dashicons-yes"></i>',
            'std' => 1,
            'type' => 'switch',
        );
        $fields[] = array(
            'id' => 'mb_use_date_i18n_instead_of_date',
            'name' => 'Use date_i18n',
            'on_label' => '<i class="dashicons dashicons-yes"></i>',
            'std' => 1,
            'type' => 'switch',
        );
		$meta_boxes[] = array(
			'fields' => $fields,
			'id' => $id,
			'settings_pages' => 'vidsoe-plugin',
			'tab' => $id,
			'title' => 'Improvements and Fixes for Meta Box',
		);
		return $meta_boxes;
	});

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    add_filter('vidsoe_plugin_tabs', function($tabs){
		$tabs['meta-box'] = 'Meta Box';
		return $tabs;
	});

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    if(v_get_option('mb_use_date_i18n_instead_of_date')){
        add_filter('rwmb_the_value', 'v_mb_the_value', 20, 4);
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    function v_mb_format_single_value($field, $value, $args, $post_id){
        if($field['timestamp']){
            $value = v_mb_from_timestamp($value, $field);
        } else {
            $value = array(
                'timestamp' => strtotime($value),
                'formatted' => $value,
            );
        }
        return empty($args['format']) ? $value['formatted'] : date_i18n($args['format'], $value['timestamp']);
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    function v_mb_format_value($field, $value, $args, $post_id){
        if(!$field['multiple']){
            return v_mb_format_single_value($field, $value, $args, $post_id);
        }
        $output = '<ul>';
        foreach($value as $single){
            $output .= '<li>' . v_mb_format_single_value($field, $single, $args, $post_id) . '</li>';
        }
        $output .= '</ul>';
        return $output;
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    function v_mb_from_timestamp($meta, $field){
        return array(
            'timestamp' => $meta ? $meta : null,
            'formatted' => $meta ? date_i18n($field['php_format'], intval($meta)) : '',
        );
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    function v_mb_the_value($value, $field, $args, $object_id){
        $types = array(
            'date' => 'RWMB_Date_Field',
            'datetime' => 'RWMB_Datetime_Field',
        );
        if(array_key_exists($field['type'], $types)){
            $value = call_user_func(array($types[$field['type']], 'get_value'), $field, $args, $object_id);
            if(false === $value){
                return '';
            }
            return v_mb_format_value($field, $value, $args, $object_id);
        }
        return $value;
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    if(v_get_option('mb_add_custom_fields')){
        if(class_exists('RWMB_Field')){
            class RWMB_Row_Open_Field extends RWMB_Field {
                public static function html($meta, $field){
                    return '';
                }
            }
        	class RWMB_Row_Close_Field extends RWMB_Field {
                public static function html($meta, $field){
                    return '';
                }
            }
        	class RWMB_Col_Open_Field extends RWMB_Field {
                public static function html($meta, $field){
                    return '';
                }
            }
        	class RWMB_Col_Close_Field extends RWMB_Field {
                public static function html($meta, $field){
                    return '';
                }
            }
        	class RWMB_Raw_Html_Field extends RWMB_Field {
                public static function html($meta, $field){
                    return '';
                }
            }
            add_filter('rwmb_row_open_outer_html', function($outer_html, $field){
            	 if(is_admin()){
            		return '';
            	}
                $classes = 'form-row';
                if(!empty($field['class'])){
            		$classes .= ' ' . $field['class'];
            	}
            	return '<div class="' . $classes . '">';
            }, 20, 2);
            add_filter('rwmb_row_close_outer_html', function($outer_html){
            	 if(is_admin()){
            		return '';
            	}
            	return '</div>';
            }, 20);
            add_filter('rwmb_col_open_outer_html', function($outer_html, $field){
            	if(is_admin()){
            		return '';
            	}
            	$classes = array();
            	foreach(array('col', 'col-sm', 'col-md', 'col-lg', 'col-xl', 'offset', 'offset-sm', 'offset-md', 'offset-lg', 'offset-xl') as $class){
            		if(isset($field[$class])){
            			if(is_numeric($field[$class])){
            				if(intval($field[$class]) >= 1 and intval($field[$class]) <= 12){
            					$classes[] = $class . '-' . $field[$class];
            				}
            			}
            		}
            	}
            	if(!$classes){
            		$classes[] = 'col';
            	}
                $classes = implode(' ', $classes);
                if(!empty($field['class'])){
            		$classes .= ' ' . $field['class'];
            	}
            	return '<div class="' . $classes . '">';
            }, 20, 2);
            add_filter('rwmb_col_close_outer_html', function($outer_html){
            	 if(is_admin()){
            		return '';
            	}
            	return '</div>';
            }, 20);
            add_filter('rwmb_raw_html_outer_html', function($outer_html, $field){
            	 if(is_admin()){
            		return '';
            	}
            	if(!empty($field['hide_on_mobile']) and wp_is_mobile()){
            		return '';
            	}
            	if(!isset($field['std'])){
            		$field['std'] = '';
            	}
            	return $field['std'];
            }, 20, 2);
        }
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
