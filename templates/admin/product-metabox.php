<?php //wpadpcbu_print( $pcbu_settings );?>
<div class="options_group">
	<?php if ( is_array( $pcbu_settings ) && ! empty( $pcbu_settings ) ) {?>
		<p class="form-field wpadpcbu_component_field">
			<label for="wpadpcbu_component"><?php echo esc_attr__( 'PC Component', 'wpappsdev-pcbuilder' ); ?></label>
			<select id="wpadpcbu_component" name="pcbu_settings[pcbucomp]" class="select short">
				<option value="-1"><?php echo esc_attr__( 'Select Component', 'wpappsdev-pcbuilder' ); ?></option>
				<?php echo generating_select_options( get_tax_terms_list( 'pcbucomp' ), 'term_id', 'name', $pcbu_settings['pcbucomp'] ); ?>
			</select>
		</p>
		<div id="wpadpcbu_filters_div">
		<?php
			if ( is_array( $filter_items ) ) {
				foreach ( $filter_items as $item ) {
					$taxonomy = 'cf-' . $item['filter_slug'];
					echo "<p class='form-field wpadpcbu_{$taxonomy}_field'>";
					echo "<label for='wpadpcbu_{$taxonomy}'>{$item['filter_name']}</label>";
					echo "<select id=\"wpadpcbu_{$taxonomy}\" name=\"pcbu_settings[filters][{$taxonomy}]\" class=\"select short\">";
					echo "<option value=\"-1\">Select {$item['filter_name']}</option>";
					echo generating_select_options( get_tax_terms_list( $taxonomy ), 'term_id', 'name', $filters[$taxonomy] );
					echo '</select>';
					echo '</p>';
				}
			}
		?>
		</div>
	<?php } else { ?>
		<p class="form-field wpadpcbu_component_field">
			<label for="wpadpcbu_component"><?php echo esc_attr__( 'PC Component', 'wpappsdev-pcbuilder' ); ?></label>
			<select id="wpadpcbu_component" name="pcbu_settings[pcbucomp]" class="select short">
				<option value="-1"><?php echo esc_attr__( 'Select Component', 'wpappsdev-pcbuilder' ); ?></option>
				<?php echo generating_select_options( get_tax_terms_list( 'pcbucomp' ), 'term_id', 'name', '' ); ?>
			</select>
		</p>
		<div id="wpadpcbu_filters_div"></div>
	<?php } ?>
	<input type="hidden" name="save_pcbu_settings">
</div>

<style>
	#side-sortables .form-field label{
		display: block;
		width: 100%;
		margin-bottom: 5px;
		font-size: 15px;
		font-weight: 600;
	}
	#side-sortables .form-field select{
		display: block;
		width: 100%;
	}
</style>
