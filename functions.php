<?php

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    defined('Vidsoe_Plugin') or die('No script kiddies please!');

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    add_action('admin_head', function(){
        $current_screen = get_current_screen();
        if($current_screen->id == 'toplevel_page_vidsoe-plugin'){ ?>
            <style>
        		.rwmb-label,
        		.rwmb-label ~ .rwmb-input {
        			display: block;
        			width: 100%;
        			padding: 0;
        		}
        		.rwmb-label {
        			margin-bottom: 6px;
        		}
        		.rwmb-settings-no-boxes .rwmb-field {
        			padding-top: 0;
        		}
        	</style><?php
        }
    });

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    add_filter('mb_settings_pages', function($settings_pages){
        $tabs = apply_filters('vidsoe_plugin_tabs', array());
        if($tabs){
            $settings_pages[] = array(
                'columns' => 1,
                'icon_url' => 'data:image/svg+xml;base64,PHN2ZyBpZD0idmlkc29lIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIzNjAiIGhlaWdodD0iMzIwIiB2aWV3Qm94PSIwIDAgMzYwIDMyMCI+CiAgPGRlZnM+CiAgICA8c3R5bGU+CiAgICAgIC5jbHMtMSB7CiAgICAgICAgZmlsbDogI2ZmZjsKICAgICAgICBmaWxsLXJ1bGU6IGV2ZW5vZGQ7CiAgICAgIH0KICAgIDwvc3R5bGU+CiAgPC9kZWZzPgogIDxnIGlkPSJ2Ij4KICAgIDxwYXRoIGlkPSJSb3VuZGVkX1JlY3RhbmdsZV80IiBkYXRhLW5hbWU9IlJvdW5kZWQgUmVjdGFuZ2xlIDQiIGNsYXNzPSJjbHMtMSIgZD0iTTM0NCw0LjExNWEzMiwzMiwwLDAsMSwxMS43MTMsNDMuNzEzbC0xNDgsMjU2LjM0NGEzMiwzMiwwLDEsMS01NS40MjYtMzJsMTQ4LTI1Ni4zNDRBMzIsMzIsMCwwLDEsMzQ0LDQuMTE1WiIvPgogICAgPHBhdGggaWQ9IlJvdW5kZWRfUmVjdGFuZ2xlXzMiIGRhdGEtbmFtZT0iUm91bmRlZCBSZWN0YW5nbGUgMyIgY2xhc3M9ImNscy0xIiBkPSJNMTYsNC4xMTVBMzIsMzIsMCwwLDEsNTkuNzEzLDE1LjgyOGwxNDgsMjU2LjM0NGEzMiwzMiwwLDAsMS01NS40MjYsMzJMNC4yODcsNDcuODI4QTMyLDMyLDAsMCwxLDE2LDQuMTE1WiIvPgogIDwvZz4KPC9zdmc+Cg==',
                'id' => 'vidsoe-plugin',
                'menu_title' => 'Vidsoe',
                'option_name' => 'vidsoe_plugin',
        		'page_title' => 'Improvements and fixes for WordPress core and more',
                'style' => 'no-boxes',
        		'submenu_title' => 'Dashboard',
                'tab_style' => 'left',
        		'tabs' => $tabs,
            );
        }
        return $settings_pages;
    });

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    function v_get_option($field_id = ''){
        return rwmb_meta($field_id, array(
            'object_type' => 'setting',
        ), 'vidsoe_plugin');
    }

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
