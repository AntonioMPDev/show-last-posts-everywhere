<?php
/**
 * Plugin Name: Show Last Posts Everywhere
 * Description: To display last posts wherever   you want in your site.
 * Plugin URI: https://www.antoniomartinezperez.com/
 * Author: Antonio Martinez Perez
 * Version: 1.0.0
 * Author URI: https://www.antoniomartinezperez.com/
 */


//define( 'CD_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

 //Register Scripts to use 
    function func_load_vuescripts() {

        wp_register_script( 'wpvue_vuejs', 'https://cdn.jsdelivr.net/npm/vue/dist/vue.js');
        wp_register_script( 'wpvue_axios', 'https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js');


        wp_register_script('my_vuecode', plugin_dir_url( __FILE__ ).'vuecode.js','wpvue_axios', 'wpvue_vuejs', true );
    }
    
    add_action('wp_enqueue_scripts', 'func_load_vuescripts');

 //Register Styles to use 

    function machi_own_style(){
    
        wp_register_style( 'everywhere_style', get_site_url() . '/wp-content/plugins/show-last-posts-everywhere/everywhere_style_style.css', array(), false, 'all');
           
    }
    
    add_action( 'wp_enqueue_scripts', 'machi_own_style');

//Add shortscode
    function func_wp_vue(){

        wp_enqueue_script('wpvue_vuejs');

        wp_enqueue_script('wpvue_axios');

        wp_enqueue_script('my_vuecode');

        wp_enqueue_style( 'everywhere_style');
        
        $siteurl = get_site_url();
        
        $str =  "
        <div id='divWpVue' >

            <posts-comp site-url=".$siteurl."> </posts-comp>
    
        </div>
        ";
        
        return $str;

    }
    add_shortcode( 'show-last-posts', 'func_wp_vue' );


    ///Add featurede image to the rest api

    add_action('rest_api_init', 'register_rest_images' );

    function register_rest_images(){
        register_rest_field( array('post'),
            'the_f_img_url',
            array(
                'get_callback'    => 'get_rest_featured_image',
                'update_callback' => null,
                'schema'          => null,
            )
        );
    }
    function get_rest_featured_image( $object, $field_name, $request ) {
        if( $object['featured_media'] ){
            $img = wp_get_attachment_image_src( $object['featured_media'], 'app-thumb' );
            return $img[0];
        }
        return false;
    }