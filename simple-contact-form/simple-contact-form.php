<?php
/**
 * Plugin Name: simple contact form
 */

 if (!defined('ABSPATH'))
{
    echo "what are you trying to do";
    exit;
}

class SimpleContactForm {

   public function __construct()
   {

    //create custom post type
    add_action('init',array( $this, 'create_custom_post_type'));

    // add assets(css, js etc)
    add_action('wp_enqueue_scripts', array($this, 'load_assets'));
    
    // Add shortcode
    add_shortcode('contact-form', array($this, 'load_shortcode' ));

    // add jquery/load javascript
    add_action('wp_footer',array($this, 'load_scripts' ));

    //register REST API
    add_action('rest_api_init',array($this, 'register_rest_api'));
   }

   public function create_custom_post_type()
   {
        $args= array(

            'public'=> true,
            'has_archive'=>true,
            'supports'=> array('title'),
            'exclude_from_search'=> true,
            'publicly_queryable'=> false,
            'capability'=> 'manage_options',
            'labels'=> array(
                'name'=> 'Contact Form',
                'singular_name'=> 'Contact Form Entry'
            ),
            'menu_icon'=> 'dashicons-media-text',
        );

        register_post_type('simple_contact_form',$args);
        
   }

   public function load_assets()
   {
     wp_enqueue_style(
            'simple-contact-form',
            plugin_dir_url( __FILE__ ).'css/simple-contact-form.css',
            array(),
            1,
            'all'
     );

     wp_enqueue_script(
            'simple-contact-form',
            plugin_dir_url( __FILE__ ).'js/simple-contact-form.js',
            array('jquery'),
            1,
            true
     );
   }

   public function load_shortcode()
   {?>
       <div class="simple-contact-form">
        <h1> Send us an email</h1>
        <p>Please fill the form below</p>

        <form id="simple-contact-form__form">
        <div class="form-group mb-2">
        <input type="text" placeholder="Name" name = "name" class="form-control">
        </div>
        <div class="form-group mb-2">
        <input type="email" name="email" placeholder="Email" class="form-control">
         </div>
         <div class="form-group mb-2">
        <input type="tel" name="phone" placeholder="Phone" class="form-control">
        </div>
        <div class="form-group mb-2">
        <textarea placeholder="Type your message" name="message" class="form-control"></textarea>
        </div>
        <div class="form-group mb-2">
        <button class="btn btn-success btn-block w-100">Send Message</button>
        </div>
   </form>
   </div>
  <?php }

public function load_scripts()
{?>
    <script>

      var nonce = '<?php echo wp_create_nonce('wp_rest'); ?>';

      (function ($){

        $('#simple-contact-form__form').submit(function(event){

          event.preventDefault();
         var form = $(this).serialize();

        //  console.log(form);

         $.ajax ({
          method :'POST',
          url : '<?php echo get_rest_url(null, 'simple-contact-form/v1/send_email'); ?>',
          headers: { 'x-wp-nonce': nonce},
          data: form
         })
      });


      })(jQuery)

      
      </script>
<?php }

public function  register_rest_api()
{
    register_rest_route('simple-contact-form/v1', 'send_email', array(
      'method'=>'POST',
      'callback'=>array($this,'handle_contact_form')

    ));
}

public function handle_contact_form($data){
  $headers = $data->get_headers();
  $params= $data->get_params();

  echo json_encode($headers);
}

  

}

new SimpleContactForm;
