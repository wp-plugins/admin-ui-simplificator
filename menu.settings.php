<?php
$settings_key = $orb_wp_simple_ui_obj->get('plugin_settings_key');
$opts = $orb_wp_simple_ui_obj->get_options();
$current_user = $orb_wp_simple_ui_obj->get_user();

?>
<div class="wrap">
    <div class="webweb_wp_admin_ui_simplificator_admin">
        <div class="main_content">
            <h2>Settings</h2>
            <p>

            </p>
            <form method="post" action="options.php">
                <?php settings_fields($orb_wp_simple_ui_obj->get('plugin_dir_name')); ?>
                <table class="form-table">
                    <tr valign="top">
                        <th scope="row" colspan="2"><h2>General</h2></th>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Status</th>
                        <td>
                            <label for="radio1">
                                <input type="radio" id="radio1" name="<?php echo $settings_key; ?>[status]"
                                    value="1" <?php echo empty($opts['status']) ? '' : 'checked="checked"'; ?> /> Enabled
                            </label>
                            <br/>
                            <label for="radio2">
                                <input type="radio" name="<?php echo $settings_key; ?>[status]"  id="radio2"
                                    value="0" <?php echo!empty($opts['status']) ? '' : 'checked="checked"'; ?> /> Disabled
                            </label>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th scope="row">Skip Simplification for User ID:</th>
                        <td><input type="text" name="<?php echo $settings_key; ?>[skip_simplification_for_id]"
                                   value="<?php echo $opts['skip_simplification_for_id']; ?>" class="input_field" />
                            <br/> Your User ID: <?php echo $current_user->ID; ?>
                        </td>
                    </tr>
                    <tr valign="top" class="app_hide"> <!-- TODO -->
                        <th scope="row">Allow users to switch between simple and default Admin UI</th>
                        <td>
                            <label for="allow_switch_on_off">
                                <input type="checkbox" id="allow_switch_on_off" name="<?php echo $settings_key; ?>[allow_switch_to_default_ui_on_off]"
                                    value="1" <?php echo empty($opts['allow_switch_to_default_ui_on_off']) ? '' : 'checked="checked"'; ?> /> Enable
                            </label>
                        </td>
                    </tr>
                </table>
                
                <p class="submit">
                    <input type="submit" class="button-primary" value="<?php _e('Save') ?>" />
                </p>
            </form>
        </div> <!-- /main_content -->

        <?php include_once(dirname(__FILE__) . '/zzz_admin_sidebar.php'); ?>
    </div> <!-- /webweb_wp_admin_ui_simplificator_admin -->
</div> <!-- /wrap -->
