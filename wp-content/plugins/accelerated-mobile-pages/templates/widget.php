<?php class AMPFORWP_Categories_Widget extends WP_Widget {

  // Set up the widget name and description.
  public function __construct() {
    $widget_options = array(
      'classname' => 'ampforwp_categories_widget',
       'description' => 'This Widget adds categories where necessary in AMP Pages'
     );
    parent::__construct( 'ampforwp_categories_widget', 'AMP Categories', $widget_options );
  }


// args for the output of the form
  public $args = array(
          'before_title'  => '<h4 class="widgettitle">',
          'after_title'   => '</h4>',
          'before_widget' => '<div class="widget-wrap">',
          'after_widget'  => '</div>'
      );

// Create the widget output.
  public function widget( $args, $instance ) {
    $ampforwp_title = apply_filters( 'widget_title', $instance[ 'title' ] );
    $ampforwp_category_count = $instance[ 'count' ];
    $ampforwp_category_id = $instance[ 'category' ];
    $ampforwp_category_link = $instance[ 'showButton' ];

 //   echo . $args['before_title'] .  . $args['after_title']; ?>

    <?php
    $exclude_ids = get_option('ampforwp_exclude_post');

    $args = array(
        'cat' => $ampforwp_category_id,
        'posts_per_page' => $ampforwp_category_count,
        'post__not_in' => $exclude_ids,
        'has_password' => false,
        'post_status'=> 'publish'
    );
    // The Query
    $the_query = new WP_Query( $args );

    // The Loop

    if ( $the_query->have_posts() ) {
        echo '<div class="amp-category-block"><ul>';
        echo '<li class="amp-category-block-title">'.$ampforwp_title .'</li>';
        while ( $the_query->have_posts() ) {
            $the_query->the_post();
            $ampforwp_post_url = get_permalink(); ?>
            <li class="amp-category-post">
              <?php if ( has_post_thumbnail() ) { ?>
                  <?php
                  $thumb_id = get_post_thumbnail_id();
                  $thumb_url_array = wp_get_attachment_image_src($thumb_id, 'thumbnail', true);
                  $thumb_url = $thumb_url_array[0];
                  ?>
                  <a href="<?php echo trailingslashit($ampforwp_post_url) . AMPFORWP_AMP_QUERY_VAR ;?>"><amp-img src=<?php echo $thumb_url ?> width=150 height=150 layout=responsive></amp-img></a>
              <?php } ?>

              <a href="<?php echo trailingslashit($ampforwp_post_url) . AMPFORWP_AMP_QUERY_VAR ;?>">
                  <?php echo get_the_title(); ?>
              </a>
            </li> <?php
        }

        //show more
        if( $ampforwp_category_link === 'yes' && $ampforwp_category_id !== '' ) {
          global $redux_builder_amp;
          echo '<a class="amp-category-block-btn" href="'.trailingslashit(get_category_link($ampforwp_category_id)).'amp'.'">'.$redux_builder_amp['amp-translator-show-more-text'].'</a>';
        }
        echo '</ul></div>';

    } else {
        // no posts found
    }
    /* Restore original Post Data */
    wp_reset_postdata();
//   echo $args['after_widget'];
  }


  // Create the admin area widget settings form.
  public function form( $instance ) {

    // Declarations for all the values to be stored
    $ampforwp_title = ! empty( $instance['title'] ) ? $instance['title'] : 'Category Title';
    $selected_category = ! empty( $instance['category'] ) ? $instance['category'] : '';
    $ampforwp_category_count = ! empty( $instance['count'] ) ? $instance['count'] : 3 ;
    $radio_buttons = ! empty( $instance['showButton'] ) ? $instance['showButton'] : 'yes';

    ?>
    <!-- Form Ends Here -->
        <p>
        <!-- text Start Here -->
          <label for="<?php echo $this->get_field_id( 'title' ); ?>">Title:
          <input class="widefat" type="text" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( $ampforwp_title ); ?>" />
          </label><br>
        <!-- text End Here -->
        </p>
        <!-- select Start Here -->
         <p>
          <label for="<?php echo esc_attr( $this->get_field_id( 'category' ) ); ?>">Category:
          <select id="<?php echo $this->get_field_id('category'); ?>" name="<?php echo $this->get_field_name('category'); ?>" class="widefat" value>
            <?php

              $categories = get_categories( array(
                  'orderby' => 'name',
                  'order'   => 'ASC'
              ) );

              echo '<option selected value="none">Recent Posts </option>';
              foreach( $categories as $category ) {
                 echo '<option '. selected( $instance['category'], $category->term_id) . ' value="'. $category->term_id . '">' . $category->name . '</option>';
               } ?>
          </select>
          </label>
         </p>
        <!-- select End Here -->

        <p>
        <!-- text starts Here -->
          <label for="<?php echo $this->get_field_id( 'count' ); ?>">Number of Posts:
          <input class="widefat" type="number" id="<?php echo $this->get_field_id( 'count' ); ?>" name="<?php echo $this->get_field_name( 'count' ); ?>" value="<?php echo esc_attr( $ampforwp_category_count ); ?>" />
          </label>
        </p>
        <!-- text End Here -->
        <p>
        <!-- radio buttons starts Here -->
          <label for="<?php echo $this->get_field_id( 'showButton' ); ?>" value="<?php  echo esc_attr( $ampforwp_title );?>">Show View more Button:</label><br>
          <label for="<?php echo $this->get_field_id('show_button_1'); ?>">
              <input class="widefat" id="<?php echo $this->get_field_id('show_button_1'); ?>" name="<?php echo $this->get_field_name('showButton'); ?>" type="radio" value="yes" <?php if($radio_buttons === 'yes'){ echo 'checked="checked"'; } ?> /><?php _e('Yes '); ?>
          </label>
           <label for="<?php echo $this->get_field_id('show_button_2'); ?>">
              <input class="widefat" id="<?php echo $this->get_field_id('show_button_2'); ?>" name="<?php echo $this->get_field_name('showButton'); ?>" type="radio" value="no" <?php if($radio_buttons === 'no'){ echo 'checked="checked"'; } ?> /><?php _e(' No'); ?>
          </label>
        <!-- radio buttons Ends Here -->

</p>
    <!-- Form Ends Here -->

    <?php
  }



  // Apply settings to the widget instance.
  public function update( $new_instance, $old_instance ) {
    $instance = $old_instance;
    $instance[ 'title' ] = strip_tags( $new_instance[ 'title' ] );
    $instance[ 'count' ] = strip_tags( $new_instance[ 'count' ] );

    if( strip_tags( $new_instance[ 'category' ] ) !== 'none' ) {
      $instance[ 'category' ] = strip_tags( $new_instance[ 'category' ] );
    } else {
      $instance[ 'category' ] = '';
    }
    $instance['showButton'] = strip_tags($new_instance['showButton']);
    return $instance;
  }

}

// Register the widget.
function ampforwp_register_categories_widget() {
  register_widget( 'AMPFORWP_Categories_Widget' );
}
add_action( 'widgets_init', 'ampforwp_register_categories_widget' );

?>