<?php
/*
Plugin Name: Woo Product Variations
Plugin URI: https://github.com/RaheesAhmed/Woo-Product-Variation-Plugin
Description: Bulk Sets variations and prices for all products
Version: 1.0
Author: Rahees Ahmed
Author URI: https://github.com/raheesahmed
*/

// Add a menu item for the plugin page
add_action('admin_menu', 'product_variations_menu');
function product_variations_menu() {
    add_menu_page('Product Variations', 'Product Variations', 'manage_options', 'product_variations', 'product_variations_page');
}

// Display the plugin page
function product_variations_page() {
    // Check if the form has been submitted
    if (isset($_POST['submit'])) {
        // Save the variations and prices
        update_option('variation_1_en', $_POST['variation_1_en']);
        update_option('variation_1_fr', $_POST['variation_1_fr']);
        update_option('variation_2_en', $_POST['variation_2_en']);
        update_option('variation_2_fr', $_POST['variation_2_fr']);
        update_option('variation_3_en', $_POST['variation_3_en']);
        update_option('variation_3_fr', $_POST['variation_3_fr']);
        update_option('variation_4_en', $_POST['variation_4_en']);
        update_option('variation_4_fr', $_POST['variation_4_fr']);
        update_option('variation_5_en', $_POST['variation_5_en']);
        update_option('variation_5_fr', $_POST['variation_5_fr']);
        echo '<div class="notice notice-success"><p>Variations and prices saved.</p></div>';
    }
    ?>
    <div class="wrap">
        <h1>Product Variations</h1>
        <form method="post">
            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><label for="variation_1_en">90x90 [en]</label></th>
                        <td><input name="variation_1_en" type="text" id="variation_1_en" style="width:200px" value="<?php echo get_option('variation_1_en'); ?>" class="regular-text"></td>
                        <th scope="row"><label for="variation_1_fr">90x90 [fr]</label></th>
                        <td><input name="variation_1_fr" type="text" id="variation_1_fr" style="width:200px" value="<?php echo get_option('variation_1_fr'); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="variation_2_en">110x110 [en]</label></th>
                        <td><input name="variation_2_en" type="text" id="variation_2_en" style="width:200px" value="<?php echo get_option('variation_2_en'); ?>" class="regular-text"></td>
                        <th scope="row"><label for="variation_2_fr">110x110 [fr]</label></th>
                        <td><input name="variation_2_fr" type="text" id="variation_2_fr" style="width:200px" value="<?php echo get_option('variation_2_fr'); ?>" class="regular-text"></td>
                    </tr>
                    <tr>
                        <th scope="row"><label for="variation_3_en">120x80 [en]</label></th>
                        <td><input name="variation_3_en" type="text" id="variation_3_en" style="width:200px" value="<?php echo get_option('variation_3_en'); ?>" class="regular-text"></td>
                        <th scope="row"><label for="variation_3_fr">120x80 [fr]</label></th>
<td><input name="variation_3_fr" type="text" id="variation_3_fr" style="width:200px" value="<?php echo get_option('variation_3_fr'); ?>" class="regular-text"></td>
</tr>
<tr>
<th scope="row"><label for="variation_4_en">150x80 [en]</label></th>
<td><input name="variation_4_en" type="text" id="variation_4_en" style="width:200px" value="<?php echo get_option('variation_4_en'); ?>" class="regular-text"></td>
<th scope="row"><label for="variation_4_fr">150x80 [fr]</label></th>
<td><input name="variation_4_fr" type="text" id="variation_4_fr" style="width:200px" value="<?php echo get_option('variation_4_fr'); ?>" class="regular-text"></td>
</tr>
<tr>
<th scope="row"><label for="variation_5_en">130x100 [en]</label></th>
<td><input name="variation_5_en" type="text" id="variation_5_en" style="width:200px" value="<?php echo get_option('variation_5_en'); ?>" class="regular-text"></td>
<th scope="row"><label for="variation_5_fr">130x100 [fr]</label></th>
<td><input name="variation_5_fr" type="text" id="variation_5_fr" style="width:200px" value="<?php echo get_option('variation_5_fr'); ?>" class="regular-text"></td>
</tr>
</tbody>
</table>
<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="Save Changes"></p>
</form>
</div>
<?php
}

// Set variations and prices for all products
add_action('woocommerce_product_options_pricing', 'product_variations');
function product_variations() {
global $post;
$product = wc_get_product($post->ID);
$variations = array(
array('size' => '90x90', 'price' => get_option('variation_1_' . $product->get_attribute('pa_language'))),
array('size' => '110x110', 'price' => get_option('variation_2_' . $product->get_attribute('pa_language'))),
array('size' => '120x80', 'price' => get_option('variation_3_' . $product->get_attribute('pa_language'))),
array('size' => '150x80', 'price' => get_option('variation_4_' . $product->get_attribute('pa_language'))),
array('size' => '130x100', 'price' => get_option('variation_5_' . $product->get_attribute('pa_language'))),
);
foreach ($variations as $variation) {
$product->add_variation(
array(
'attributes' => array(
'pa_size' => $variation['size'],
),
'regular_price' => $variation['price'],
'sale_price' => $variation['price'],
)
);
}
}

// Save variations and prices when a product is saved
add_action('woocommerce_process_product_meta', 'save_product_variations');
function save_product_variations($post_id) {
if (isset($_POST['variable_post_id'])) {
$product = wc_get_product($post_id);
$variations = array(
array('size' => '90x90', 'price' => $_POST['variation_1_en']),
array('size' => '110x110', 'price' => $_POST['variation_2_en']),
array('size' => '120x80', 'price' => $_POST['variation_3_en']),
array('size' => '150x80', 'price' => $_POST['variation_4_en']),
array('size' => '130x100', 'price' => $POST['variation_5_en']),
);
foreach ($variations as $variation) {
$variation_id = $product->get_child_by_sku($product->get_sku() . '' . $variation['size']);
if ($variation_id) {
$variation_product = wc_get_product($variation_id);
$variation_product->set_regular_price($variation['price']);
$variation_product->set_sale_price($variation['price']);
$variation_product->save();
}
}
$variations = array(
array('size' => '90x90', 'price' => $_POST['variation_1_fr']),
array('size' => '110x110', 'price' => $_POST['variation_2_fr']),
array('size' => '120x80', 'price' => $_POST['variation_3_fr']),
array('size' => '150x80', 'price' => $_POST['variation_4_fr']),
array('size' => '130x100', 'price' => $POST['variation_5_fr']),
);
foreach ($variations as $variation) {
$variation_id = $product->get_child_by_sku($product->get_sku() . '' . $variation['size']);
if ($variation_id) {
$variation_product = wc_get_product($variation_id);
$variation_product->set_regular_price($variation['price']);
$variation_product->set_sale_price($variation['price']);
$variation_product->save();
}
}
}
}

// Display variations and prices in the product table
add_filter('manage_edit-product_columns', 'add_product_variations_column');
function add_product_variations_column($columns) {
$new_columns = array();
foreach ($columns as $key => $value) {
if ($key == 'sku') {
$new_columns['variations'] = __('Variations', 'woocommerce');
}
$new_columns[$key] = $value;
}
return $new_columns;
}

add_action('manage_product_posts_custom_column', 'populate_product_variations_column');
function populate_product_variations_column($column) {
global $post;
if ($column == 'variations') {
$product = wc_get_product($post->ID);
$variations = array(
array('size' => '90x90', 'price' => $product->get_variation_price('min', true)),
array('size' => '110x110', 'price' => $product->get_variation_price('max', true)),
array('size' => '120x80', 'price' => $product->get_variation_price('130x100', true)),
array('size' => '150x80', 'price' => $product->get_variation_price('150x80', true)),
array('size' => '130x100', 'price' => $product->get_variation_price('120x80', true)),
);
foreach ($variations as $variation) {
echo '<p><strong>' . $variation['size'] . ': </strong>' . wc_price($variation['price']) . '</p>';
}
}
}

?>
