<section class="wpadpcbu-pcbuilder alignwide">
	<div class="wpadpcbu-breadcrumb">
		<div class="container">
			<div class="row">
				<div class="col-sm-7 col-md-7">
					<ul class="wpadpcbu-nav">
						<li><a href="<?php echo esc_url( site_url() ); ?>" title="<?php _e( 'Home', 'wpappsdev-pcbuilder' ); ?>"><i class="dashicons dashicons-admin-multisite"></i></a></li>
						<li><a class="bclink" data-page="builder" href="#"><?php _e( 'PC Builder', 'wpappsdev-pcbuilder' ); ?></a></li>
					</ul>
					<div class="clear"></div>
				</div>
				<div class="col-sm-5 col-md-5">
					<p class="page-heading"><?php _e( 'PC Builder - Build Your Own Computer', 'wpappsdev-pcbuilder' ); ?></p>
				</div>
			</div>
		</div>
	</div>

	<div class="wpadpcbu-actions">
		<div class="container">
			<div class="row">
				<div class="col-sm-12 col-md-6">
					<div class="right-button">
						<a class="pc-builder-button wpadpcbu-product-cart" href="#" title="<?php esc_attr_e( 'Add To Cart', 'wpappsdev-pcbuilder' ); ?>"><i class="dashicons dashicons-cart"></i></a>
						<a class="pc-builder-button wpadpcbu-save" href="#" title="<?php esc_attr_e( 'Save PC', 'wpappsdev-pcbuilder' ); ?>"><i class="dashicons dashicons-database-add"></i></a>
					</div>
				</div>
				<div class="col-sm-12 col-md-6">
					<div class="top-total-amount">
						<span class="amount"><?php echo wc_clean( $total ); ?></span>
						<!-- <span class="items">4 Items</span> -->
					</div>
					<!-- <a class="button wpadpcbu-get-quote" href="#">Get a Quote</a> -->
				</div>
			</div>
		</div>
	</div>

	<div class="wpadpcbu-component">
		<div class="container">
			<div class="row">
				<div class="wpadpcbu-component-table col-md-12">
					<table class="table table-striped has-background table-responsive-sm">
						<thead>
							<tr>
								<th scope="col"><?php _e( 'Component', 'wpappsdev-pcbuilder' ); ?></th>
								<th scope="col"><?php _e( 'Image', 'wpappsdev-pcbuilder' ); ?></th>
								<th scope="col"><?php _e( 'Product Name', 'wpappsdev-pcbuilder' ); ?></th>
								<th scope="col"><?php _e( 'Price', 'wpappsdev-pcbuilder' ); ?></th>
								<th scope="col"><?php _e( 'Action', 'wpappsdev-pcbuilder' ); ?></th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ( $components as $component ) { ?>
								<?php $key           = "CI{$component['term_id']}"; ?>
								<?php $fixed_height  = isset( $items[ $key ] ) ? '' : ' fixed-height'; ?>
								<?php $has_component = isset( $items[ $key ] ) ? ' has-component' : ''; ?>
								<tr id = "componentid-<?php echo wc_clean( $component['term_id'] ); ?>" class="component-item-row<?php echo wc_clean( $fixed_height ); ?><?php echo wc_clean( $has_component ); ?>">
									<th class="component-name" scope="row"><div><?php echo isset( $component['image'] ) ? wp_kses( $component['image'], wpadpcbu_allowed_html() ) : ''; ?><?php echo wc_clean( $component['name'] ); ?></div></th>
									<td class="component-product-image">
										<?php if ( isset( $items[ $key ] ) ) {?>
											<div class="product-image">
												<a target="_blank" href="<?php echo esc_url( get_permalink( $items[ $key ]['id'] ) ); ?>">
													<?php echo wp_kses( get_the_post_thumbnail( $items[ $key ]['id'], [80, 80] ), wpadpcbu_allowed_html() ); ?>
												</a>
											</div>
										<?php } ?>
									</td>
									<td class="component-product-name">
										<?php
										if ( isset( $items[ $key ] ) ) {
											echo wc_clean( $items[ $key ]['name'] );
										}
										?>
									</td>
									<td class="component-product-price">
										<?php if ( isset( $items[ $key ] ) ) {
											echo wc_clean( $items[ $key ]['fprice'] );
										} ?>
									</td>
									<td class="component-product-action">
										<a class="wpadpcbu-search-product pc-builder-button" data-componentid = "<?php echo wc_clean( $component['term_id'] ); ?>" href="#" title="<?php esc_attr_e( 'Search Product', 'wpappsdev-pcbuilder' ); ?>">
											<i class="dashicons dashicons-code-standards"></i>
										</a>
										<?php if ( isset( $items[ $key ] ) ) { ?>
											<a class="wpadpcbu-remove-product pc-builder-button" data-componentid = "<?php echo wc_clean( $component['term_id'] ); ?>" href="#" title="<?php esc_attr_e( 'Remove Product', 'wpappsdev-pcbuilder' ); ?>">
												<i class="dashicons dashicons-trash"></i>
											</a>
										<?php } ?>
									</td>
								</tr>
							<?php } ?>
							<tr class="total-amount">
								<td colspan="3" class="amount-label text-right"><b><?php _e( 'Total:', 'wpappsdev-pcbuilder' ); ?></b></td>
								<td colspan="2" class="wpadpcbu-total"><?php echo wc_clean( $total ); ?></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
</section>
