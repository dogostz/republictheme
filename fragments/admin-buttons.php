<?php 
	if ( !is_user_logged_in() ) {
		return;
	}

	$type = get_post_type();
	$brokers = crb_get_editors();

	$current_broker = crb_get_meta( '_property_broker' );
?>

<div class="admin-buttons">
	<ul>

		<?php if ( $type == 'property-base' ) : 
			$title 	= get_the_title();
			$pid 	= crb_get_id_by_slug( $title );

			if ( !$pid ) :
		?>

			<li>
				<h3>Публикувай обявата в сайта</h3>
				<a href="<?php echo add_query_arg( 'publish-new-property', 1 ); ?>">Публикувай!</a>
			</li>

			<?php endif; ?>
		<?php endif; ?>

		<li class="assoc-broker">
			<h3>Асоцииран брокер</h3>

			<label class="select">
				<select name="property-broker" id="">

					<option value="<?php echo add_query_arg( 'broker-id', 0, get_permalink() ); ?>">N/A</option>

					<?php foreach ($brokers as $broker_id => $broker_name): 
						if ( empty($broker_id) ) {
							continue;
						}

						$active = '';

						if ( $current_broker == $broker_id ) {
							$active = 'selected';
						} 
					?>
						
						<option <?php echo $active; ?> value="<?php echo add_query_arg( 'broker-id', $broker_id, get_permalink() ); ?>"><?php echo $broker_name; ?></option>
						
					<?php endforeach ?>

				</select>
			</label><!-- /.select -->
		</li>

	</ul>
</div>