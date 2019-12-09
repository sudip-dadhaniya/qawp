<?php
if ( ! is_object( $wpfp_query ) ) {
	return '';
}
?>
    <div class="wpfp-product-section-product wpfp-product-<?php echo esc_attr( $this->wpfp_identity ); ?>">
        <div id="wpfp-match-products">
            <div class="wpfp-products">
                <div class="wpfp-product-headline"><?php echo esc_html( $this->wpfp_product_headline ); ?></div>
				<?php
				if ( $wpfp_query->have_posts() ) {
					foreach ( $wpfp_query->posts as $wpfp_product_id ) {
						$wpfp_product     = new WC_Product( $wpfp_product_id );
						$variation_data   = $wpfp_product->get_attributes();
						$get_all_prd_attr = $this->wpfp_get_attribute_data_by_product_id( $wpfp_product_id, $variation_data );
						?>
                        <div class="wpfp-product-section" id="wpfp_product_<?php echo esc_attr( $wpfp_product_id ); ?>">
                            <div class="wpfp-product-detail">
                                <div class="wpfp-product-head">
                                    <div class="wpfp-product-title">
                                        <a class="wpfp-product-link" href="<?php echo esc_url( get_the_permalink( $wpfp_product_id ) ); ?>">
											<?php echo esc_html( $wpfp_product->get_name() ); ?>
                                        </a>
                                    </div>
                                </div>
                                <div class="wpfp-product-body">
                                    <div class="wpfp-product-image">
										<?php if ( has_post_thumbnail( $wpfp_product_id ) ) { ?>
                                            <a class="wpfp-product-link" href="<?php echo esc_url( get_the_permalink( $wpfp_product_id ) ); ?>">
												<?php echo get_the_post_thumbnail( $wpfp_product_id, 'shop_thumbnail' ) ?>
                                            </a>
										<?php } else { ?>
                                            <a class="wpfp-product-link" href="<?php echo esc_url( get_the_permalink( $wpfp_product_id ) ); ?>">
                                                <img src="<?php echo esc_url( wc_placeholder_img_src() ); ?>" alt="<?php esc_html_e( 'Awaiting product image', 'woo-product-finder' ); ?>" class="wp-post-image"/>
                                            </a>
										<?php } ?>
                                    </div>
                                    <div class="wpfp-product-attributes">
                                        <div class="wpfp-product-attributes-list">
                                            <div class="wpfp-product-overlay-attributes">
												<?php
												if ( ! empty( $get_all_prd_attr ) && isset( $get_all_prd_attr ) ) {
													foreach ( $get_all_prd_attr as $all_key => $all_value ) {
														if ( $all_key === $wpfp_product_id ) {
															foreach ( $all_value as $key => $value ) {
																if ( strpos( $value, '|' ) !== false ) {
																	$attribute_value_exploded = get_exploded_string( trim( strtolower( str_replace( ' ', '', $value ) ) ), '|' );
																} else {
																	$attribute_value_exploded = array( trim( strtolower( str_replace( ' ', '', $value ) ) ) );
																}
																$class = '';
																foreach ( $this->get_attribute_name_and_value() as $get_attribute_name_and_value ) {
																	foreach ( $get_attribute_name_and_value as $wpfp_attribute_name_key => $wpfp_attribute_values_array ) {
																		$wpfp_attribute_values_array = get_exploded_string( $wpfp_attribute_values_array, ',' );
																		$wpfp_attribute_values_array = array_map( 'strtolower', $wpfp_attribute_values_array );

																		if ( ! empty( $wpfp_attribute_name_key ) &&
																		     ( strtolower( $key ) === $wpfp_attribute_name_key ) &&
																		     array_intersect( $wpfp_attribute_values_array, $attribute_value_exploded ) ) {
																			$class = ' wpfp-product-positive-attribute';
																		} else if ( ! empty( $wpfp_attribute_name_key ) &&
																		            ( strtolower( $key ) === $wpfp_attribute_name_key ) &&
																		            ! array_intersect( $wpfp_attribute_values_array, $attribute_value_exploded ) ) {
																			$class = ' wpfp-product-negative-attribute';
																		}
																	}
																}
																?>
                                                                <div class="wpfp-product-attribute<?php echo esc_attr( $class ) ?>">
                                                                    <span id="<?php echo esc_attr( trim( strtolower( $key ) ) ); ?>" class="wpfp-attribute-text wpfp-product-attribute-name"><?php echo esc_html( $key ) ?> : </span>
                                                                    <span id="<?php echo esc_attr( trim( strtolower( $value ) ) ); ?>" class="wpfp-attribute-text wpfp-product-attribute-value"> <?php echo esc_html( $value ) ?></span>
                                                                </div>
																<?php
															}
														}
													}
												}
												?>
                                            </div>
                                            <div class="wpfp-product-more-attributes">
                                                <a class="wpfp_more" href="javascript:void(0);" id="wpfp-more-id-<?php echo esc_attr( $wpfp_product_id ); ?>" data-attributes-default="<?php echo esc_attr( $this->get_show_attribute() ); ?>">
													<?php esc_html_e( 'View More', 'woo-product-finder' ) ?>
                                                </a>
                                            </div>
                                            <div class="wpfp-product-less-attributes">
                                                <a class="wpfp_less" href="javascript:void(0);" id="wpfp-less-id-<?php echo esc_attr( $wpfp_product_id ); ?>" data-attributes-default="<?php echo esc_attr( $this->get_show_attribute() ); ?>">
													<?php esc_html_e( 'Show Less', 'woo-product-finder' ) ?>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="wpfp-product-price-section">
                                            <div class="wpfp-product-data">
                                                <div class="wpfp-product-price">
                                                    <span class="wpfp-price"><?php echo wp_kses_post( $wpfp_product->get_price_html() ); ?></span>
                                                </div>
                                                <a class="wpfp-button wprw-view-button wpfp-product-link" href="<?php echo esc_url( get_the_permalink( $wpfp_product_id ) ); ?>" target="_blank">
                                                    <span class="wpfp-product-view-text"><?php echo esc_html( $this->get_detail_title() ); ?></span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
						<?php
					}
				}
				?>
            </div>
        </div>
        <div class="wpfp-match-pagination" id="wpfp-match-pagination wpfp-pagination-<?php echo esc_attr( $this->wpfp_identity ); ?>">
            <div class="wpfp-nav-pagination">
				<?php $this->wpfp_product_pagination_html( $wpfp_query, $this->get_backend_per_page_limit() ); ?>
            </div>
        </div>
    </div>
<?php


