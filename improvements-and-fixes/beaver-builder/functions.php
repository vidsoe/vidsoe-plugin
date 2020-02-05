<?php

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    defined('Vidsoe_Plugin') or die('No script kiddies please!');

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    add_filter('rwmb_meta_boxes', function($meta_boxes){
		$id = basename(dirname(__FILE__));
		$fields = array();
        $fields[] = array(
            'id' => 'bb_disable_inline_editing',
            'name' => 'Disable inline editing',
            'on_label' => '<i class="dashicons dashicons-yes"></i>',
            'std' => 1,
            'type' => 'switch',
        );
        $fields[] = array(
            'id' => 'bb_fix_in_the_loop',
            'name' => 'Fix in_the_loop',
            'on_label' => '<i class="dashicons dashicons-yes"></i>',
            'std' => 1,
            'tooltip' => array(
                'content' => 'Useful when using default:post_meta attribute on Contact Form 7 fields',
                'position' => 'right',
            ),
            'type' => 'switch',
        );
        $fields[] = array(
            'attributes' => array(
                'id' => 'bb-reboot',
            ),
            'name' => '',
            'std' => 'Reboot',
            'type' => 'button',
        );
		$meta_boxes[] = array(
			'fields' => $fields,
			'id' => $id,
			'settings_pages' => 'vidsoe-plugin',
			'tab' => $id,
			'title' => 'Improvements and Fixes for Beaver Builder',
		);
		return $meta_boxes;
	});

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    add_filter('vidsoe_plugin_tabs', function($tabs){
        $id = basename(dirname(__FILE__));
		$tabs[$id] = 'Beaver Builder';
		return $tabs;
	});

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
