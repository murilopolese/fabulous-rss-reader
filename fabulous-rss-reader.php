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
    
    public function Fabulous_RSS_Reader() {
        parent::WP_Widget(
            false, 
            $name = __('Fabulous RSS Reader', 'fabulous_rss_reader') 
        );
    }
    
    public function form($instance) {
        if( $instance ) {
             $title = esc_attr( $instance['title'] );
             $feed_url = esc_attr( $instance['feed_url'] );
             $max_itens_to_show = esc_attr( $instance['max_itens_to_show'] );
        } else {
            $title = 'Fabulous RSS';
            $feed_url = '';
            $max_itens_to_show = 4;
        }
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>">
                <?php _e('Widget title', 'fabulous_rss_reader'); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
            name="<?php echo $this->get_field_name('title'); ?>" type="text" 
            value="<?php echo $title; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('feed_url'); ?>">
                <?php _e('RSS feed url', 'fabulous_rss_reader'); ?>
            </label>
            <input class="widefat" id="<?php echo $this->get_field_id('feed_url'); ?>" 
            name="<?php echo $this->get_field_name('feed_url'); ?>" type="text" 
            value="<?php echo $feed_url; ?>" />
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('max_itens_to_show'); ?>">
                <?php _e('How many itens to show?', 'fabulous_rss_reader'); ?>
            </label>
            <input class="widefat" type="text"
            id="<?php echo $this->get_field_id('max_itens_to_show'); ?>" 
            name="<?php echo $this->get_field_name('max_itens_to_show'); ?>"  
            value="<?php echo $max_itens_to_show; ?>" />
        </p>
        <?php
    }

    // Save changes
    public function update( $new_instance, $old_instance ) {
        $instance = $old_instance;
        $instance['feed_url'] = strip_tags( $new_instance['feed_url'] );
        $instance['max_itens_to_show'] = strip_tags( $new_instance['max_itens_to_show'] );
        $instance['title'] = strip_tags( $new_instance['title'] );
        return $instance;
    }

    public function widget($args, $instance) {
        extract( $args );
        $items = $this->get_feed($instance['feed_url']);
        $output = '';
        $output .= '<div class="widget widget_fabulous_rss_reader">';
        $output .= '<h3 class="widget-title">' . $instance['title'] . '</h3>';
        $output .= '<ul class="fabulous-rss-reader">';
        for ( $i = 0; $i < (int) $instance['max_itens_to_show']; $i++ ) {
            $output .= $this->render_item($items[$i], $instance['item_template']);
        }
        $output .= '</ul>';
        $output .= '</div>';
        echo $output;
    }

    public function get_feed($feed_url = '') {
        $feed_xml = $this->get_feed_content($feed_url);
        $items = $this->get_feed_items($feed_xml);
        return $items;
    }

    public function get_feed_content($feed_url = '') {
        // If there is no url, return false
        if(empty($feed_url)) {
            return false;
        }
        $feed_content = file_get_contents($feed_url);
        $feed = simplexml_load_string($feed_content);
        return $feed;
    }

    public function get_feed_items(SimpleXMLElement $feed) {
        // If there is no url, return an empty array
        if(empty($feed->channel)){
            return array();
        }
        return $feed->channel->item;
    }

    public function render_item(SimpleXMLElement $item) {
        return '<li><a href="' . $item->link . '">' . $item->title . '</a></li>';
    }

}

add_action(
    'widgets_init', 
    create_function('','return register_widget("fabulous_rss_reader");')
);