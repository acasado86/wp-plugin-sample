<?php

/*
Plugin Name: wp-plugin-sample
Plugin URI: 
Description: Simple plugin that tell you user_id by email.
Version: 1.0.0
Author: acasado
Author URI: 
License: GPLv2
*/

/* 
Copyright (C) 2016 acasado

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place - Suite 330, Boston, MA  02111-1307, USA.
*/

class WP_Plugin_Sample{
    protected static $instance = null;
    var $slug = 'wp-plugin-sample';
    
    static function & getInstance() {
        if ( is_null(self::$instance) ) {
            self::$instance = new self();
        }

        return self::$instance;
    }
    
    function __construct() {
        // If instance is null, create it. Prevent creating multiple instances of this class
        if ( is_null( self::$instance ) ) {
            self::$instance = $this;
            
            add_action( 'admin_menu', array( $this, 'add_menu'));
            
            add_action('admin_enqueue_scripts', array($this, 'admin_enqueue_scripts') );
            
            add_action( 'wp_ajax_wp_sample_plugin_email_search', array( $this, 'ajax_wp_sample_plugin_email_search' ) );
        }
    }
    
    static function activate_plugin() {
        //TODO
    }
    
    static function deactivate_plugin() {
        //TODO
    }
    
    function add_menu(){
        add_menu_page(__('WP Sample Plugin', 'wp_plugin_sample'), __('WP Sample Plugin', 'wp_plugin_sample'), 'manage_options', $this->slug, array( $this, 'simple_form'));
    }
    
    function simple_form(){
        include_once( 'templates/simple-form.php' );
    }
    
    function admin_enqueue_scripts($hook) {
        //Custom JS for refunds
        if( "toplevel_page_wp-plugin-sample" == $hook ){
            wp_enqueue_script('wp-plugin-sample-email-search', plugins_url("js/ajax-email-search.js", __FILE__), array('jquery'), '20160627');
        }
    }
    
    function ajax_wp_sample_plugin_email_search(){
        $email = filter_input(INPUT_POST, 'email');
        $user = WP_User::get_data_by('email', $email);
        if (!is_null($user->ID)){
            $response = array(
                'user_id'   =>  $user->ID
            );
            wp_send_json($response);
        }
        echo "{}";
        die();
    }
    
}

$oWpPluginSample = WP_Plugin_Sample::getInstance();
register_activation_hook(__FILE__, array('WP_Plugin_Sample', 'activate_plugin'));
register_deactivation_hook(__FILE__, array( 'WP_Plugin_Sample', 'deactivate_plugin'));