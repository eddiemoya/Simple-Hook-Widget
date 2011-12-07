<?php
/*
Plugin Name: Simple Hook Widget
Description: Creates a custom hook within a sidebar in place of a widget
Version: 1
Author: Eddie Moya
*/

/*
Copyright (C) 2011 Eddie Moya (eddie.moya+wp[at]gmail.com)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 3 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program. If not, see <http://www.gnu.org/licenses/>.
*/

class Simple_Hook_Widget extends WP_Widget {
    
    /**
     * @author Eddie Moya
     */
    function register_widget(){
        add_action('widgets_init', array( __CLASS__, '_register_widget' ) );
    }
    
    /**
     * @author Eddie Moya
     */
    function _register_widget(){
       register_widget(__CLASS__);
    }

	/**
	 * Widget setup.
	 */
	function Simple_Hook_Widget() {
		/* Widget settings. */
		$widget_ops = array( 
            'classname' => 'simple-hook', 
            'description' => 'Creates a custom hook within a sidebar in place of a widget' );

        /* Widget control settings. */
		$control_ops = array( 'width' => 200, 'height' => 350 );

		/* Create the widget. */
		parent::WP_Widget( 'simple-hook', 'Simple Hook', $widget_ops, $control_ops );
	}

	function widget( $args, $instance ) {
		extract( $args );

		$hookname = str_replace(' ', '-', strtolower( htmlspecialchars(strip_tags( $instance['hookname'])) ));
        
        //Do the damn thing.
        do_action($hookname);
        
	}

	/**
	 * Update the widget settings.
	 */
	function update( $new_instance, $old_instance ) {
        
		$instance = $old_instance;
        
		$instance['hookname'] = str_replace(' ', '-', strtolower( htmlspecialchars(strip_tags( $new_instance['hookname'])) ));
        do_action('simplehook_' . $instance['hookname']);
      
		return $instance;
	}

	function form( $instance ) {

		/* Set up some default widget settings. */
		$defaults = array( 'hookname' => '' );
		$instance = wp_parse_args( (array) $instance, $defaults ); ?>
        
       
		<p>
			<label for="<?php echo $this->get_field_id( 'hookname' ); ?>">Hook Name: </label>
			<input id="<?php echo $this->get_field_id( 'hookname' ); ?>" name="<?php echo $this->get_field_name( 'hookname' ); ?>" value="<?php echo $instance['hookname']; ?>" style="width:80%;" />
		</p>


	<?php
	}
}

Simple_Hook_Widget::register_widget();