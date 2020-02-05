<?php

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    defined('Vidsoe_Plugin') or die('No script kiddies please!');

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    add_action('admin_footer', function(){
        $current_screen = get_current_screen();
        if($current_screen->id == 'toplevel_page_vidsoe-plugin'){ ?>
            <script>
                jQuery(function($){
                    $('#bb-reboot').on('click', function(){
                        var confirmation = confirm('Are you sure?');
                        if(confirmation){
                            $.post('<?php echo rest_url('vp/v1/bb/'); ?>', {
                                reboot: true
                            }, function(data){
                                alert('Rebooted!');
                            });
                        }
                    });
                });
        	</script><?php
        }
    });

    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    add_filter('rwmb_meta_boxes', function($meta_boxes){
		$id = basename(dirname(__FILE__));
		$fields = array();
		$fields[] = array(
            'attributes' => array(
                'id' => 'bb-reboot',
            ),
            'name' => '',
            'std' => 'Reboot',
            'type' => 'button',
        );
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
            'type' => 'switch',
        );
		$fields[] = array(
            'id' => 'bb_fix_styles',
            'name' => 'Fix styles',
            'on_label' => '<i class="dashicons dashicons-yes"></i>',
            'std' => 1,
            'type' => 'switch',
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
