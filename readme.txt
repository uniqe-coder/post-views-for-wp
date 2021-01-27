=== Post Views for WP ===
Contributors: uniqe-coder
Tags: PostViews, PostCount, PageCount
Requires at least: 3.0
Tested up to: 5.6
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

== Description ==
Post Views for WP will allow you to unveil how many number of times a post or page had been viewed. It is quite easy to use as it has only one step to Set it up and running.

= Features include: =

* You can Opt the post types for which post or page views will be counted and displayed.
* Option to set/reset counts interval
* Excluding users by IPs
* Post views display conditions such as automatic or manual via shortcode as per your requirement
* Shortcode Support added, simply copy/paste [post_viewsfwp] as per requirement

== Installation ==

1. Install Post Views for WP either via the WordPress.org plugin directory, or by uploading the files to your server
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to the PostViews for WP settings and set your options as per requirement.

== How to Use? ==
1. One Step Setup to get up and running, Just Go to `WP-Admin -> Settings -> PostViews for WP` to configure the plugin.
2. Simply enable wherever you want to enable Post/Page Views from the listed options, that's it!
3. Or you can use the function below to directly echo/display it.
Open  the path `wp-content/themes/<YOUR ACTIVE THEME NAME>/index.php`
4. The following Code can be used in many places such as in post.php, page.php, single.php, archive.php as well as per your requirement.
5. Search for: `<?php while (have_posts()) : the_post(); ?>`
6. Once found, Add if(function_exists('post_views_for_wp_above_the_content')) {
	post_views_for_wp_above_the_content($postID);} anywhere Below It (Your concerned position).

== Frequently Asked Questions ==

No questions yet.

== Screenshots ==

1. screenshot-1.png
2. screenshot-2.png


== Changelog ==	

= 1.0.1 ( 27 January 2021) =
* Feature Added: =
* Added support of Shortcode to display Post/Page Views Count. ( You can simply copy and paste [post_viewsfwp] ), Once you paste it in your Post/Page or any Custom Posttype your Views will be displayed.

= 1.0 ( 19 January 2021) =
* Initial Release