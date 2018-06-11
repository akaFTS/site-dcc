<?php
/**
 * List View Template
 * The wrapper template for a list of events. This includes the Past Events and Upcoming Events views
 * as well as those same views filtered to a specific category.
 *
 * Override this template in your own theme by creating a file at [your-theme]/tribe-events/list.php
 *
 * @package TribeEventsCalendar
 *
 */

if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
} ?>

	<div id="main">

		<?php
		if (!is_active_sidebar('sidebar-left')) { $no_side_left = true; }
		$no_side_right = true;
		?>

		<div class="wrapper">

			<?php if (!isset($no_side_left)) { ?>
			<div class="column column-narrow">

				<?php dynamic_sidebar('Sidebar: Left Column'); ?>

				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-narrow -->
			<?php } ?>

			<div class="column <?php
			if (isset($no_side_left) && !isset($no_side_right)) {
				echo 'column-wide';
			} elseif (!isset($no_side_left) && isset($no_side_right)) {
				echo 'column-wide column-last';
			} elseif (isset($no_side_left) && isset($no_side_right)) {
				echo 'column-full column-last';
			} else {
				echo 'column-medium';
			} ?>">

				<div class="content-block widget-tribe-events">

					<div class="inner-wrap">
					    <?php do_action( 'tribe_events_before_template' ); ?>

					    	<!-- Tribe Bar -->
					    <?php tribe_get_template_part( 'modules/bar' ); ?>

					    	<!-- Main Events Content -->
					    <?php tribe_get_template_part( 'list/content' ); ?>

					    	<div class="tribe-clear"></div>

					    <?php do_action( 'tribe_events_after_template' ) ?>
					</div><!-- .inner-wrap -->

				</div><!-- .content-block .widget-tribe-events -->

				<div class="cleaner">&nbsp;</div>

			</div><!-- end .column .column-medium -->

			<div class="cleaner">&nbsp;</div>

		</div><!-- end .wrapper -->

	</div><!-- end #main -->