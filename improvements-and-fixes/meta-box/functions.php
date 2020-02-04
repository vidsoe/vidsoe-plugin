<?php

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    defined('Vidsoe_Plugin') or die('No script kiddies please!');

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    add_filter('rwmb_meta_boxes', function($meta_boxes){
		$id = basename(dirname(__FILE__));
		$fields = array();
        $fields[] = array(
            'id' => 'use_date_i18n_instead_of_date',
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
