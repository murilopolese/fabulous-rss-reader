<?php
/*
Plugin Name: Fabulous Rss Reader
Plugin URI: http://github.com/murilopolese/fabulous-rss-reader
Description: Show and link to the articles from a RSS feed.
Version: 0.1
Author: Murilo Polese
Author URI: http://www.murilopolese.com.br/
License: WTFPL
*/

class Fabulous_RSS_Reader extends WP_Widget {
    
    // Constructor method
    public function Fabulous_RSS_Reader() {
        parent::WP_Widget(
            false, 
            $name = __('Fabulous RSS Reader', 'fabulous_rss_reader') 
        );
    }
    
    // widget form creation
    function form($instance) {  
        echo 'Bitch, I\'m fabulous.';
    }

    // widget update
    function update($new_instance, $old_instance) {
        /* ... */
    }

    // How it will be printed on front end
    function widget($args, $instance) {

    }

}

add_action(
    'widgets_init', 
    create_function('','return register_widget("fabulous_rss_reader");')
);