<?php defined( 'ABSPATH' ) || exit; ?>
<table class="woocommerce-orders-table woocommerce-MyAccount-orders shop_table shop_table_responsive my_account_orders account-orders-table">
	<thead>
		<tr>
			<?php foreach ( $columns as $column_id => $column_name ) { ?>
				<th class="woocommerce-orders-table__header woocommerce-orders-table__header-<?php echo esc_attr( $column_id ); ?>"><span class="nobr"><?php echo esc_attr( $column_name ); ?></span></th>
			<?php } ?>
		</tr>
	</thead>

	<tbody>
		<?php foreach ( $items as $key => $item ) { ?>
			<?php
			$component_id = str_replace( 'CI', '', $key );
			$product_id   = $item['id'];
			$_product     = wc_get_product( $product_id );
			$_component   = get_component_data( $key );
			$com_name     = isset( $_component['name'] ) ? $_component['name'] : '';

			?>
			<tr class="woocommerce-orders-table__row order">
				<?php foreach ( $columns as $column_id => $column_name ) { ?>
					<td class="woocommerce-orders-table__cell woocommerce-orders-table__cell-<?php echo esc_attr( $column_id ); ?>" data-title="<?php echo esc_attr( $column_name ); ?>">
						<?php
						switch ( $column_id ) {
							case 'id':
								echo  wc_clean( $_product->get_id() );
								break;

							case 'info':
								echo '<a href="' . esc_url( get_permalink( wc_clean( $_product->get_id() ) ) ) . '">' . esc_attr( wc_clean( $_product->get_name() ) ) . '</a>';
								echo '<p><b>' . esc_html__( 'Component', 'wpappsdev-pcbuilder' ) . ' : </b>' . esc_attr( wc_clean( $com_name ) ) . '</p>';
								break;

							case 'price':
								echo wc_price( $_product->get_price() );
								break;

							case 'stock':
								echo ucwords( wc_clean( $_product->get_stock_status() ) );
								break;

							case 'image':
								echo wp_kses( $_product->get_image(), wpadpcbu_allowed_html() );
								break;
							default:
								// code...
								break;
						}
						?>
					</td>
				<?php } ?>
			</tr>
		<?php } ?>
	</tbody>
</table>
<style>
	/* Customer dashboard css */
	td.woocommerce-orders-table__cell.woocommerce-orders-table__cell-image {
		padding: 0px;
	}
	td.woocommerce-orders-table__cell.woocommerce-orders-table__cell-image img {
		width: 150px;
	}
</style>
