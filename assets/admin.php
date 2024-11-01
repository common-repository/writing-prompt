<?php

// Add feed as admin notice
add_action( 'admin_notices', 'writing_prompt_notice' );
function writing_prompt_notice() {
	global $pagenow;
	if ( $pagenow == 'post-new.php' ) {
		include_once( ABSPATH . WPINC . '/feed.php' );

		// Create refresh time filter
		function refresh_interval( $seconds ) {
			return 7200;
		}

		// Add refresh time filter
		add_filter( 'wp_feed_cache_transient_lifetime' , 'refresh_interval' );

		// Fetch RSS feed
		$rss = fetch_feed( 'http://thewritepractice.com/feed/rss' );

		// Parse RSS feed
		if ( ! is_wp_error( $rss ) )  {
			$maxitems = $rss->get_item_quantity( 1 );
			$rss_items = $rss->get_items( 0, $maxitems );
		}

		function get_string_between($string, $start, $end){
			$string = " ".$string;
			$ini = strpos($string,$start);
			if ($ini == 0) return "";
			$ini += strlen($start);   
			$len = strpos($string,$end,$ini) - $ini;
			return substr($string,$ini,$len);
		}

		foreach ( $rss_items as $item ) {

			$title = $item->get_title();
			$content = $item->get_content();
			$practice = get_string_between($content, '<h2>PRACTICE</h2>', '</div>');
			echo "<div class='writing-prompt'><h2>The Write Practice's Daily Prompt</h2>";
			echo $practice;
			echo '<strong><a href="' . $item->get_permalink() . '">' . $title . '</a></strong>';
			echo '</div>';
		}

		// Remove refresh time filter
		remove_filter( 'wp_feed_cache_transient_lifetime' , 'refresh_interval' );
	}
}

