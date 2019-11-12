<?php
/**
* Widget Product 1
* 
* 
* @package WP_Store
*/
if(wp_store_woocommerce_available()):
  add_action('widgets_init', 'wp_store_register_product_widget');

function wp_store_register_product_widget(){
  register_widget('wp_store_product');
}

class wp_store_product extends WP_Widget {
/**
* Register Widget with Wordpress
* 
*/
public function __construct() {
  parent::__construct(
    'wp_store_product', __('WP Store: WC Product','wp-store'), array(
      'description' => __('Slider with woocommerce products', 'wp-store')
      )
    );
}

/**
* Helper function that holds widget fields
* Array is used in update and form functions
*/
private function widget_fields() {

  $prod_type = array(
    'category' => __('Category', 'wp-store'),
    'latest_product' => __('Latest Product', 'wp-store'),
    'upsell_product' => __('UpSell Product', 'wp-store'),
    'feature_product' => __('Feature Product', 'wp-store'),
    'on_sale' => __('On Sale Product', 'wp-store'),
    );
  $taxonomy     = 'product_cat';
  $empty        = 1;
  $orderby      = 'name';  
$show_count   = 0;      // 1 for yes, 0 for no
$pad_counts   = 0;      // 1 for yes, 0 for no
$hierarchical = 1;      // 1 for yes, 0 for no  
$title        = '';  
$empty        = 0;
$args = array(
  'taxonomy'     => $taxonomy,
  'orderby'      => $orderby,
  'show_count'   => $show_count,
  'pad_counts'   => $pad_counts,
  'hierarchical' => $hierarchical,
  'title_li'     => $title,
  'hide_empty'   => $empty

  );
$woocommerce_categories = array();
$woocommerce_categories_obj = get_categories($args);
$woocommerce_categories[''] = 'Select Product Category:';
foreach ($woocommerce_categories_obj as $category) {
  $woocommerce_categories[$category->term_id] = $category->name;
}

$fields = array(
  'product_title' => array(
    'wp_store_widgets_name' => 'product_title',
    'wp_store_widgets_title' => __('Title', 'wp-store'),
    'wp_store_widgets_field_type' => 'text',

    ),
  'product_list_desc' => array(
    'wp_store_widgets_name' => 'product_list_desc',
    'wp_store_widgets_title' => __('Description', 'wp-store'),
    'wp_store_widgets_field_type' => 'textarea',

    ),
  'product_type' => array(
    'wp_store_widgets_name' => 'product_type',
    'wp_store_widgets_title' => __('Select Product Type', 'wp-store'),
    'wp_store_widgets_field_type' => 'select',
    'wp_store_widgets_field_options' => $prod_type

    ),
  'product_category' => array(
    'wp_store_widgets_name' => 'product_category',
    'wp_store_widgets_title' => __('Select Product Category', 'wp-store'),
    'wp_store_widgets_field_type' => 'select',
    'wp_store_widgets_field_options' => $woocommerce_categories

    ),

  'product_number' => array(
    'wp_store_widgets_name' => 'number_of_prod',
    'wp_store_widgets_title' => __('Select the number of Product to show', 'wp-store'),
    'wp_store_widgets_field_type' => 'number',
    ),


  );
return $fields;
}

public function widget($args, $instance){
  extract($args);
  if($instance){
    $product_title      =   $instance['product_title'];
    if(isset($instance['product_list_desc'])){
      $product_list_desc      =   $instance['product_list_desc'];
    }else{
      $product_list_desc = "";
    }
    $product_type       =   $instance['product_type'];
    $product_category   =   $instance['product_category'];
    $product_args       =   '';
    if(isset($instance['number_of_prod'])){
      $product_number      =   $instance['number_of_prod'];
    }else{
      $product_number = "4";
    }
    if($product_type == 'category'){
      $product_args = array(
        'post_type' => 'product',
        'tax_query' => array(array('taxonomy'  => 'product_cat',
          'field'     => 'id', 
          'terms'     => $product_category                                                                 
          )),
        'posts_per_page' => $product_number
        );
    }

    elseif($product_type == 'latest_product'){
      $product_args = array(
        'post_type' => 'product',
        'posts_per_page' => $product_number
        );
    }

    elseif($product_type == 'upsell_product'){
      $product_args = array(
        'post_type'         => 'product',
        'posts_per_page'    => 10,
        'meta_key'          => 'total_sales',
        'orderby'           => 'meta_value_num',
        'posts_per_page'    => $product_number
        );
    }

    elseif($product_type == 'feature_product'){
      $product_args = array(
        'post_type'        => 'product',  
        'meta_key'         => '_featured',  
        'meta_value'       => 'yes',
        'posts_per_page'   => $product_number
        );
    }

    elseif($product_type == 'on_sale'){
      $product_args = array(
        'post_type'      => 'product',
        'meta_query'     => array(
          'relation' => 'OR',
            array( // Simple products type
              'key'           => '_sale_price',
              'value'         => 0,
              'compare'       => '>',
              'type'          => 'numeric'
              ),
            array( // Variable products type
              'key'           => '_min_variation_sale_price',
              'value'         => 0,
              'compare'       => '>',
              'type'          => 'numeric'
              )
            )
        );
    }

    ?>
    <?php echo $before_widget; ?>
      <?php echo $before_title.esc_html($product_title).$after_title; ?>
      <p class="prod-title-desc"><?php echo esc_textarea($product_list_desc); ?></p>

      <ul class="new-prod-slide">
        <?php
        $count=0;
        $product_loop = new WP_Query( $product_args );
        while ( $product_loop->have_posts() ) : $product_loop->the_post(); 
          woocommerce_get_template_part( 'content', 'product' );
        endwhile; ?>
      <?php wp_reset_query(); ?>
    </ul>
  <?php echo $after_widget;?>
  <?php
}
}

/**
* Sanitize widget form values as they are saved.
*
* @see WP_Widget::update()
*
* @param	array	$new_instance	Values just sent to be saved.
* @param	array	$old_instance	Previously saved values from database.
*
* @uses	wp_store_widgets_updated_field_value()		defined in widget-fields.php
*
* @return	array Updated safe values to be saved.
*/
public function update($new_instance, $old_instance) {
  $instance = $old_instance;

  $widget_fields = $this->widget_fields();

// Loop through fields
  foreach ($widget_fields as $widget_field) {

    extract($widget_field);

// Use helper function to get updated field values
    $instance[$wp_store_widgets_name] = wp_store_widgets_updated_field_value($widget_field, $new_instance[$wp_store_widgets_name]);
  }

  return $instance;
}

/**
* Back-end widget form.
*
* @see WP_Widget::form()
*
* @param	array $instance Previously saved values from database.
*
* @uses	wp_store_widgets_show_widget_field()		defined in widget-fields.php
*/
public function form($instance) {
  $widget_fields = $this->widget_fields();

// Loop through fields
  foreach ($widget_fields as $widget_field) {

// Make array elements available as variables
    extract($widget_field);
    $wp_store_widgets_field_value = !empty($instance[$wp_store_widgets_name]) ? esc_attr($instance[$wp_store_widgets_name]) : '';
    wp_store_widgets_show_widget_field($this, $widget_field, $wp_store_widgets_field_value);
  }
}
}
endif;