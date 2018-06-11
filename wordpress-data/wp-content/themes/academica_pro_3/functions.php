<?php
/**
 * WPZOOM Theme Functions
 *
 * Don't edit this file until you know what you're doing. If you want to add
 * custom functions in your theme please create a Child Theme and add the code
 * in the functions.php file of it. In this way your changes will never
 * be overwritten in case of a theme update.
 */

/**
 * Paths to WPZOOM Theme Functions
 */
define("FUNC_INC", get_template_directory() . "/functions");

define("WPZOOM_INC", FUNC_INC . "/wpzoom");
define("THEME_INC", FUNC_INC . "/theme");

/** WPZOOM Framework Core */
require_once WPZOOM_INC . "/init.php";

/** WPZOOM Theme */
require_once FUNC_INC . "/functions.php";
require_once FUNC_INC . "/sidebar.php";
require_once FUNC_INC . "/custom-post-types.php";
require_once FUNC_INC . "/template-tags.php";
require_once FUNC_INC . "/post-options.php";

/* Theme widgets */
require_once FUNC_INC . "/widgets/custommenu.php";
require_once FUNC_INC . "/widgets/featured-category.php";
require_once FUNC_INC . "/widgets/recentposts.php";
require_once FUNC_INC . "/widgets/testimonials.php";
require_once FUNC_INC . "/widgets/textwidget.php";
require_once FUNC_INC . "/widgets/image-box.php";

/** WooCommerce */
require_once FUNC_INC . "/woocommerce.php";