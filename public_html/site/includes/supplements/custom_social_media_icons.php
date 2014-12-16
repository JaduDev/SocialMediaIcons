<?php

	require_once 'custom/CustomHelper.php';

	if (isset($record)) {
		$title = trim(array_pop(explode('|', $record->title, 2)));
		$url_facebook = trim(array_pop(explode('|', $record->url_facebook, 2)));
		$url_twitter = trim(array_pop(explode('|', $record->url_twitter, 2)));
		$url_vimeo = trim(array_pop(explode('|', $record->url_vimeo, 2)));
		$url_youtube = trim(array_pop(explode('|', $record->url_youtube, 2)));
		$url_googleplus = trim(array_pop(explode('|', $record->url_googleplus, 2)));
		$url_linkedin = trim(array_pop(explode('|', $record->url_linkedin, 2)));
		$url_wordpress = trim(array_pop(explode('|', $record->url_wordpress, 2)));
		$url_blogspot = trim(array_pop(explode('|', $record->url_blogspot, 2)));

		# facebook
		if ($url_facebook != "") {
			$has_http = stripos($url_facebook, "http",0);

			if (substr($url_facebook, 0,4) != "http") {
				$url_facebook = "https://" . $url_facebook;
			}


			print "<a href='".$url_facebook."' target='_blank' title='Facebook'><img src='/images/social_media_supplement/facebook_supp.png' title='Twitter' /></a>";
		}

		#twitter
		if ($url_twitter != "") {
			$has_http = stripos($url_twitter, "http",0);

			if (substr($url_twitter, 0,4) != "http") {
				$url_twitter = "https://" . $url_twitter;
			}

			print "<a href='".$url_twitter."' target='_blank' title='Twitter'><img src='/images/social_media_supplement/twitter2_supp.png' alt='Twitter' /></a>";
		}

		#vimeo
		if ($url_vimeo != "") {
			$has_http = stripos($url_vimeo, "http",0);

			if (substr($url_vimeo, 0,4) != "http") {
				$url_vimeo = "https://" . $url_vimeo;
			}

			print "<a href='".$url_vimeo."' target='_blank' title='vimeo'><img src='/images/social_media_supplement/vimeo_supp.png' alt='vimeo' /></a>";
		}


		#youtube
		if ($url_youtube != "") {
			$has_http = stripos($url_youtube, "http",0);

			if (substr($url_youtube, 0,4) != "http") {
				$url_youtube = "https://" . $url_youtube;
			}

			print "<a href='".$url_youtube."' target='_blank' title='youtube'><img src='/images/social_media_supplement/youtube_supp.png' alt='youtube' /></a>";
		}

		#googleplus
		if ($url_googleplus != "") {
			$has_http = stripos($url_googleplus, "http",0);

			if (substr($url_googleplus, 0,4) != "http") {
				$url_googleplus = "https://" . $url_googleplus;
			}

			print "<a href='".$url_googleplus."' target='_blank' title='googleplus'><img src='/images/social_media_supplement/googlepluscolor_supp.png' alt='googleplus' /></a>";
		}

		#linkedin
		if ($url_linkedin != "") {
			$has_http = stripos($url_linkedin, "http",0);

			if (substr($url_linkedin, 0,4) != "http") {
				$url_linkedin = "https://" . $url_linkedin;
			}

			print "<a href='".$url_linkedin."' target='_blank' title='linkedin'><img src='/images/social_media_supplement/linkedin_supp.png' alt='linkedin' /></a>";
		}

		#wordpress
		if ($url_wordpress != "") {
			$has_http = stripos($url_wordpress, "http",0);

			if (substr($url_wordpress, 0,4) != "http") {
				$url_wordpress = "https://" . $url_wordpress;
			}

			print "<a href='".$url_wordpress."' target='_blank' title='wordpress'><img src='/images/social_media_supplement/wordpress_supp.png' alt='wordpress' /></a>";
		}

		#blogspot
		if ($url_blogspot != "") {
			$has_http = stripos($url_blogspot, "http",0);

			if (substr($url_blogspot, 0,4) != "http") {
				$url_blogspot = "https://" . $url_blogspot;
			}

			print "<a href='".$url_blogspot."' target='_blank' title='blogspot'><img src='/images/social_media_supplement/blogspot_supp.png' alt='blogspot' /></a>";
		}



	} else {
		print "error";
	}