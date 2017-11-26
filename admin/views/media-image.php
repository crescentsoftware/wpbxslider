<?php
/**
 * The media image view (a simple text box for now)
 * 
 * @param mixed $args is global here passed from the renderer
 *                    which contains the name and value pairs
 */

 /**
  * The field name to be used for storing data for our settings.
  * Note that the name of the option is saved as a dictionary of option_name[field_name]
  * Making a mistake here can be confusing since data will not save, without error
  */
 $field_name = $args['option_name']."[".$args['name']."]";

 /**
  * The value stored for this setting
  */
 $field_val = $args['value'];

?>
<input name="<?php echo $field_name; ?>" type="text" value="<?php echo $field_val; ?>" class="regular-text">
