<?php

function get_wp_retrogaming_custom_fields ($type) {
  if($type == 'accessory') return get_wp_retrogaming_accessory_custom_fields ();
  else if($type == 'device') return get_wp_retrogaming_device_custom_fields ();
}

function wp_retrogaming_show_custom_fields() { //Show box
  global $post;
  $type = get_post_type($post->ID);
	$fields = get_wp_retrogaming_custom_fields ($type); ?>
		<div>
		<?php foreach ($fields as $field => $datos) { ?>
			<?php if($datos['tipo'] != 'repeater') { ?><div style="width: calc(50% - 10px); float: left; padding: 5px;"><?php } else { ?><div style="width: calc(100% - 10px); float: left; padding: 5px;"><?php } ?>
				<p><b><?php echo $datos['titulo']; ?></b></p>
				<?php if($datos['tipo'] == 'text' || $datos['tipo'] == 'link') { ?>
					<input  type="text" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 100%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>" />
				<?php } else if($datos['tipo'] == 'date') { ?>
					<input type="date" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 50%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>" />
				<?php } else if($datos['tipo'] == 'hidden') { ?>
					<input disabled="disabled" type="text" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 50%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>" />
				<?php } else if($datos['tipo'] == 'image') { ?>
					<input type="text" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="input_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 80%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value='<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>' />
					<a href="#" id="button_devide_<?php echo $field; ?>" class="button insert-media add_media" data-editor="input_<?php echo $type; ?>_<?php echo $field; ?>" title="<?php _e("Añadir fichero", 'the7mk2'); ?>"><span class="wp-media-buttons-icon"></span> <?php _e("Añadir fichero", 'the7mk2'); ?></a>
					<script>
						jQuery(document).ready(function () {			
							jQuery("#input_<?php echo $type; ?>_<?php echo $field; ?>").change(function() {
								a_imgurlar = jQuery(this).val().match(/<a href=\"([^\"]+)\"/);
								img_imgurlar = jQuery(this).val().match(/<img[^>]+src=\"([^\"]+)\"/);
								if(img_imgurlar !==null ) jQuery(this).val(img_imgurlar[1]);
								else  jQuery(this).val(a_imgurlar[1]);
							});
						});
					</script>
				<?php } else if($datos['tipo'] == 'text') { ?>
					<input  type="text" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" style="width: 100%;" name="_<?php echo $type; ?>_<?php echo $field; ?>" value="<?php echo get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>" />
				<?php } else if($datos['tipo'] == 'textarea') { ?>
					<?php $settings = array( 'media_buttons' => true, 'quicktags' => true, 'textarea_rows' => 5 ); ?>
					<?php wp_editor( get_post_meta( $post->ID, '_'.$type.'_'.$field, true ), '_'.$type.'_'.$field, $settings ); ?>
				<?php } else if ($datos['tipo'] == 'select') { ?>
					<select name="_<?php echo $type; ?>_<?php echo $field; ?>">
						<?php foreach($datos['valores'] as $key => $value) { ?>
							<option value="<?php echo $key; ?>"<?php if ($key == get_post_meta( $post->ID, '_'.$type.'_'.$field, true )) echo " selected='selected'"; ?>><?php echo $value; ?></option>
						<?php } ?>	
					</select>
				<?php } else if ($datos['tipo'] == 'multiple') { ?>
					<select name="_<?php echo $type; ?>_<?php echo $field; ?>[]" multiple="multiple">
						<?php foreach($datos['valores'] as $key => $value) { ?>
							<option value="<?php echo $key; ?>"<?php if (in_array($key, get_post_meta( $post->ID, '_'.$type.'_'.$field, true ))) echo " selected='selected'"; ?>><?php echo $value; ?></option>
						<?php } ?>	
					</select>
				<?php }  else if ($datos['tipo'] == 'checkbox') { ?>
							<?php $results = get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); ?>
							<?php foreach($datos['valores'] as $key => $value) { ?>
								<input type="checkbox" class="_<?php echo $type; ?>_<?php echo $field; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>" name="_<?php echo $type; ?>_<?php echo $field; ?>[]" value="<?php echo $key; ?>" <?php if(is_array($results) && in_array($key, $results)) { echo "checked='checked'"; } ?> /> <?php echo $value; ?><br/>
						<?php } ?>	
				<?php } else if ($datos['tipo'] == 'repeater') { $rest = get_post_meta( $post->ID, '_'.$type.'_'.$field, true ); if(isset($datos['max'])) $max = $datos['max']; else $max = (count($rest) < 2 ? 2 : (count($rest) + 1)); ?>
      <div id="repeater_<?php echo $field; ?>">
        <?php for ($i = 0; $i < $max; $i ++) { ?>
            <?php foreach($datos['fields'] as $key => $subfields) { ?>
              <?php if($subfields['tipo'] == 'image') { ?>
                <input type="text" class="_<?php echo $type; ?>_<?php echo $field; ?>_<?php echo $key; ?>" id="input_<?php echo $type; ?>_<?php echo $field; ?>_<?php echo $key; ?>_<?php echo $i; ?>" style="width: 80%;" name="_<?php echo $type; ?>_<?php echo $field; ?>[<?php echo $i; ?>][<?php echo $key; ?>]" value="<?php echo $rest[$i][$key]; ?>" placeholder="<?php echo $subfields['titulo']; ?>" />
                <a href="#" id="button_devide_<?php echo $field; ?>_<?php echo $key; ?>_<?php echo $i; ?>" class="button insert-media add_media" data-editor="input_<?php echo $type; ?>_<?php echo $field; ?>_<?php echo $key; ?>_<?php echo $i; ?>" title="<?php _e("Añadir fichero"); ?>"><span class="wp-media-buttons-icon"></span> <?php _e("Añadir fichero"); ?></a>
                <script>
                  jQuery(document).ready(function () {			
                    jQuery("#input_<?php echo $type; ?>_<?php echo $field; ?>_<?php echo $key; ?>_<?php echo $i; ?>").change(function() {
                      a_imgurlar = jQuery(this).val().match(/<a href=\"([^\"]+)\"/);
                      img_imgurlar = jQuery(this).val().match(/<img[^>]+src=\"([^\"]+)\"/);
                      if(img_imgurlar !==null ) jQuery(this).val(img_imgurlar[1]);
                      else  jQuery(this).val(a_imgurlar[1]);
                    });
                  });
                </script>
              <?php } else if($subfields['tipo'] == 'textarea') { ?>
                  <?php $settings = array( 'media_buttons' => false, 'quicktags' => true, 'textarea_rows' => 5 );  ?>
                  <?php wp_editor($rest[$i][$key], '_'.$type.'_'.$field.'['.$i.']['.$key.']', $settings ); ?>
              <?php } else if ($subfields['tipo'] == 'select') { ?>
                <select name="_<?php echo $type; ?>_<?php echo $field; ?>[<?php echo $i; ?>][<?php echo $key; ?>]">
                  <?php foreach($subfields['valores'] as $key => $value) { ?>
                    <option value="<?php echo $key; ?>"<?php if ($key == $rest[$i][$key]) echo " selected='selected'"; ?>><?php echo $value; ?></option>
                  <?php } ?>	
                </select>
              <?php } else { ?>
                <input  type="text" class="_<?php echo $type; ?>_<?php echo $field; ?>_<?php echo $key; ?>" id="_<?php echo $type; ?>_<?php echo $field; ?>_<?php echo $key; ?>_<?php echo $i; ?>" style="width: 100%;" name="_<?php echo $type; ?>_<?php echo $field; ?>[<?php echo $i; ?>][<?php echo $key; ?>]" value="<?php echo $rest[$i][$key]; ?>" placeholder="<?php echo $subfields['titulo']; ?>" />
              <?php } ?>
            <?php } ?>
          <hr style="margin: 30px 0px;"/>
        <?php } ?>
      </div>
    <?php } ?>
		</div>
	<?php } ?>
	<div style="clear: both;"></div>
	</div> <?php
}

function wp_retrogaming_save_custom_fields( $post_id ) { //Save changes
	global $wpdb;
  $type = get_post_type($post_id);
  $fields = get_wp_retrogaming_custom_fields ($type);
	foreach ($fields as $field => $datos) {
		$label = '_'.$type.'_'.$field;
    if ($datos['tipo'] == 'repeater') { //Limpiamos vacios
			if(isset($_POST[$label])) {
		    $temp = array_remove_empty($_POST[$label]);
		    unset($_POST[$label]);
		    $_POST[$label] = array();
		    foreach($temp as $item) {
		      $_POST[$label][] = $item;
		    }
      }
    }
		if (isset($_POST[$label])) update_post_meta( $post_id, $label, $_POST[$label]);
		else if (!isset($_POST[$label]) && $datos['tipo'] == 'checkbox') delete_post_meta( $post_id, $label);
    else if (!isset($_POST[$label]) && $datos['tipo'] == 'multiple') delete_post_meta( $post_id, $label);
	}
}