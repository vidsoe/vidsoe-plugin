<?php

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    defined('Vidsoe_Plugin') or die('No script kiddies please!');

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    add_filter('rwmb_meta_boxes', function($meta_boxes){
		$id = basename(dirname(__FILE__));
		$fields = array();
        $fields[] = array(
            'id' => 'mb_use_date_i18n_instead_of_date',
            'name' => 'Use date_i18n() instead of date() on \'date\' and \'datetime\' fields?',
            'off_label' => 'No',
            'on_label' => 'Yes',
            'std' => 1,
            'style' => 'square',
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
