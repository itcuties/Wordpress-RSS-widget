<?php
/*
Plugin Name: ITCUTIES RSS Plugin
Plugin URI: http://www.itcuties.com/itcuties-rss-plugin
Description: Display ITCUTIES RSS data
Version: 1
Author: ITCUTIES
Author URI: http://www.itcuties.com
*/

	class ITCRssWidget extends WP_Widget {
  		function ITCRssWidget() {
    			parent::WP_Widget( false, $name = 'ITCRss Widget' );
  		}

		function widget( $args, $instance ) {
			extract( $args );
    			$title = apply_filters( 'widget_title', $instance['title'] );
    
			echo $before_widget;

      			if ($title) {
				echo $before_title . $title . $after_title;
      			}
		
			// Display RSS info
			itcRssDisplay();
	
       			echo $after_widget;
   
  		}

  		function update( $new_instance, $old_instance ) {
    			return $new_instance;
  		}

		
		function form( $instance ) {
	    		$title = esc_attr( $instance['title'] );
			echo '<input class="widefat" id="'.$this->get_field_id( 'title' ).'" name="'.$this->get_field_name( 'title' ).'" type="text" value="'.$title.'" />';
	 	}
  		
	}

	function itcRssDisplay() {
		$doc = new DOMDocument();
  		$doc->load('http://www.itcuties.com/feed/');
 
  		foreach ($doc->getElementsByTagName('item') as $node) {
			$postTitle 	= $node->getElementsByTagName('title')->item(0)->nodeValue;
			$postLink 	= $node->getElementsByTagName('link')->item(0)->nodeValue;
			$postDate 	= $node->getElementsByTagName('pubDate')->item(0)->nodeValue;

			echo '<strong><a href="'.$postLink.'">'.$postTitle.'</a></strong><br/>';
			echo '<i>'.$postDate.'</i><br/><br/>';		
		}
	}

	add_action( 'widgets_init', 'ITCRssWidgetInit' );

	function ITCRssWidgetInit() {
		register_widget( 'ITCRssWidget' );
	}

?>
