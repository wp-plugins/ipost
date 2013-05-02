<?php
/*
Plugin Name: iPost
Plugin URI: http://wordpress.org/extend/plugins/ipost/
Description: Super simple plugin to include posts in other post via a shortcode.
Author: Sebastian Österberg
Version: 1.0
Author URI: http://www.sebastianosterberg.se/
*/
add_shortcode('ipost', 'ipost_include');

function ipost_include($atts)
{
	$silent = true;

	if (isset($atts["silent"]) && $atts["silent"] == false)
		$silent = false;

	if (isset($atts["permalink"]) && !isset($atts["id"]))
		$atts["id"] = url_to_postid($atts["permalink"]);

	if (!isset($atts["id"]))
		return $silent ? null : "Missing id parameter";

	$id = (int)$atts["id"];
	$content_post = get_post($id);
	if ($content_post)
	{
		$content = $content_post->post_content;
		$content = apply_filters('the_content', $content);
		$content = str_replace(']]>', ']]&gt;', $content);
		return $content;
	}

	return $silent ? null : "Could not find post.";
}
?>
