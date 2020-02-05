<?php
/**
 * Author: Vidsoe
 * Author URI: https://vidsoe.com
 * Description: Sitios web con la más alta calidad y la mayor capacidad al menor precio.
 * Domain Path:
 * License: GPL2
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Network:
 * Plugin Name: Vidsoe Plugin
 * Plugin URI: https://vidsoe.com
 * Text Domain: vidsoe-plugin
 * Version: 2020.2.4.11
 *
 */ // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	defined('ABSPATH') or die('No script kiddies please!');

	// ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

	add_action('plugins_loaded', function(){
        if(defined('Vidsoe_Plugin')){
            add_action('admin_notices', function(){
				printf('<div class="notice notice-error"><p><strong>Vidsoe Plugin</strong> already exists.</p></div>');
			});
		} else {
			define('Vidsoe_Plugin', __FILE__);
			define('Vidsoe_Plugin_Version', '2020.2.4.11');
			require_once(plugin_dir_path(Vidsoe_Plugin) . 'includes/plugin-update-checker-4.8.1/plugin-update-checker.php');
			Puc_v4_Factory::buildUpdateChecker('https://github.com/vidsoe/vidsoe-plugin', Vidsoe_Plugin, 'vidsoe-plugin');
			$missing_plugins = array();
			require_once(ABSPATH . 'wp-admin/includes/plugin.php');
	    	if(!is_plugin_active('meta-box/meta-box.php')){
	    		$missing_plugins['meta-box'] = 'Meta Box';
	    	}
	    	if(is_plugin_active('meta-box-aio/meta-box-aio.php')){
	    		$meta_box_aio = get_option('meta_box_aio');
	    		$active_extensions = isset($meta_box_aio['extensions']) ? $meta_box_aio['extensions'] : array();
	    		if(!in_array('mb-settings-page', $active_extensions)){
	    			$missing_plugins['mb-settings-page'] = 'MB Settings Page';
	    		}
	    	} else {
	    		if(!is_plugin_active('mb-settings-page/mb-settings-page.php')){
	    			$missing_plugins['mb-settings-page'] = 'MB Settings Page';
	    		}
	    	}
	    	if($missing_plugins){
				add_action('admin_notices', function() use($missing_plugins){
					$missing_plugins = array_map(function($required_plugin = ''){
		    			return '<strong>' . $required_plugin . '</strong>';
		    		}, $missing_plugins);
		    		$required = '';
		    		$last = array_pop($missing_plugins);
		    		if($missing_plugins){
		    			$required = implode(', ', $missing_plugins) . ' and ';
		    		}
		    		$required .= $last;
		    		printf('<div class="notice notice-error"><p>' . esc_html('%1$s requires %2$s.') . '</p></div>', '<strong>Vidsoe Plugin</strong>', $required);
				});
	    	} else {
				require_once(plugin_dir_path(Vidsoe_Plugin) . 'functions.php');
				foreach(glob(plugin_dir_path(Vidsoe_Plugin) . 'improvements-and-fixes/*', GLOB_ONLYDIR) as $dir){
					$file = $dir . '/functions.php';
					if(is_file($file)){
						require_once($file);
					}
				}
			}
        }
	});
