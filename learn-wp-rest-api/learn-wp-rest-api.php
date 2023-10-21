<?php
/**
 * Plugin Name: learn wp rest api
 * Description: this is a plugin
 */

  if(!defined('ABSPATH'))
 {
    die('you are not allowed here');
 }
add_action('wp_enqueue_scripts','load_assets');

function load_assets()
   {
     wp_enqueue_style(
            'simple-contact-form',
            plugin_dir_url( __FILE__ ).'css/simple-contact-form.css',
            array(),
            1,
            'all'
     );
    }

 /**
  * register a custom menu
  */
  function wp_learn_rest_submenu()
  {
   add_menu_page(
    esc_html__('WP Learn Admin Page', 'wp_learn'),
    esc_html__('WP Learn Admin Page', 'wp_learn'),
    'manage_options',
    'wp_learn_admin',
    'wp_learn_rest_render_admin_page',
    'dashicons-admin-site',
    ''
   );
  }
  add_action('admin_menu','wp_learn_rest_submenu');

  function wp_learn_rest_render_admin_page()
  {?>

   <div class="wrap" id="wp_learn_admin">
        <h1>Admin</h1>
        <button id="wp-learn-rest-api-button">Load Posts via REST</button>
        <button id="wp-learn-clear-posts">Clear Posts</button>
        <h2>Posts</h2>
        <textarea name="" id="wp-learn-posts" cols="125" rows="15"></textarea>
    </div>
    <div class="wrap">
        <h2>Add Post</h2>
        <form>
            <div>
            <label for="wp-learn-post-title">Post Title</label>
            <input type="text" name="" id="wp-learn-post-title">
            </div>
            <div>
            <label for="wp-learn-post-content">Post Content</label>
            <textarea name="" id="wp-learn-post-content" cols="125" rows="15"></textarea>
            </div>
            <div>
                <input type="button" id= "wp-learn-submit-post" value="Add Post">
            </div>
  </form>
  </div>
    <!--Update post -->

    <div>
        <h2>Update Post</h2>
        <form>

        <div>
            <label for="wp-learn-post-update-id">Post ID</label>
            <input type="text" name="" id="wp-learn-post-update-id">
            </div>
            <div>
            <label for="wp-learn-post-update-title">Post Title</label>
            <input type="text" name="" id="wp-learn-update-post-title">
            </div>
            <div>
            <label for="wp-learn-update-post-content">Post Content</label>
            <textarea name="" id="wp-learn-update-post-content" cols="125" rows="15"></textarea>
            </div>
            <div>
                <input type="button" id= "wp-learn-update-post" value="Update Post">
            </div>
            
        </form>
    </div>

     <!--Delete post -->

     <div>
        <h2>Delete Post</h2>
        <form>

        <div>
            <label for="wp-learn-delete-post-id">Post ID</label>
            <input type="text" name="" id="wp-learn-delete-post-id">
            </div>
            <div>
                <input type="button" id= "wp-learn-delete-post" value="Delete Post">
            </div>
            
        </form>
    </div>
  

    <?php

  }

  /**
   * enqueque javascript
   */

   add_action('admin_enqueue_scripts', 'wp_learn_rest_enqueue_scripts');
   function wp_learn_rest_enqueue_scripts(){
    wp_enqueue_script('wp_learn_rest_api',plugin_dir_url(__FILE__).'learn-wp-rest-api.js',array('wp-api'),2,true);
   }