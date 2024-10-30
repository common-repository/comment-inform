<?php
/*
Plugin Name: Comment Inform
Plugin URI: http://ivanauto.ru/wordpress/
Description: This plugin for sent information about comment to post author. Infromation about authors gets from custom fields. Custom fields keys are "Author email" and "Author name".
Author: Ivan Chenchov
Version: 1.0
Author URI: http://ivanauto.ru/wordpress/
*/

//Install plugin
function comminform_install() {
	add_option("comminform_namekey", "Author name");
	add_option("comminform_emailkey", "Author email");
	add_option("comminform_subject", "New comments on your post");
	add_option("comminform_message", "Hello [name]!\nNew comment:\n[comment]\n\n on your post [title]\n you can see there: [url]");
}
register_activation_hook(__FILE__, 'comminform_install');

//Function for menu and for options page

function comminform_menu() {
	add_options_page('Comment Informator Options', 'Comment Informator', 8, __FILE__, 'comminform_options');
}
add_action('admin_menu', 'comminform_menu');


function comminform_options() {
	global $wpdb;
        
        $comminform_name=get_option("comminform_namekey");
        $comminform_email=get_option("comminform_emailkey");
        $comminform_subject=get_option("comminform_subject");
        $comminform_message=get_option("comminform_message");

        if(isset($_POST) && isset($_POST["comminform"]) && $_POST["comminform"]=="savesettings") {
        	$saved=false;
        	if(isset($_POST["namekey"])) {
        		$comminform_name=trim($_POST["namekey"]);
        		update_option("comminform_namekey", $comminform_name);
        		$saved=true;
        	}
        	if(isset($_POST["emailkey"])) {
        		$comminform_email=trim($_POST["emailkey"]);
        		update_option("comminform_emailkey", $comminform_email);
        		$saved=true;
        	}
 		if(isset($_POST["subject"])) {
 			$comminform_subject=trim($_POST["subject"]);
 			update_option("comminform_subject", $comminform_subject);
 			$saved=true;
 		}
 		if(isset($_POST["message"])) {
 			$comminform_message=trim($_POST["message"]);
 			update_option("comminform_message", $comminform_message);
 			$saved=true;
 		}
 		if($saved) {
?>
                        <div id="message" class="updated fade"><p><strong><?php _e("Settings updated")?></strong></p></div>
<?php
 		}
        }
?>
<div class="wrap">
<h2><?php _e("Comment Informator Options"); ?></h2>
<br class="clear" />
<form method="post">
<table class="widefat">
<tr><td><label for="namekey"><?php echo _e('Meta key for name'); ?></label></td>
<td><input type="text" name="namekey" id="namekey" value="<?php echo ($comminform_name); ?>" size="40"></td></tr>
<tr><td><label for="emailkey"><?php echo _e('Meta key for e-mail'); ?></label></td>
<td><input type="text" name="emailkey" id="emailkey" value="<?php echo ($comminform_email); ?>" size="40"></td></tr>
<tr><td><label for="subject"><?php echo _e('Subject for e-mail'); ?></label></td>
<td><input type="text" name="subject" id="subject" value="<?php echo ($comminform_subject); ?>" size="40"></td></tr>
<td colspan="2"><label for="message"><?php _e('Message for e-mail');?>
 (<small><?php _e('Use macroses:<br>[name] - author name<br>[url] - url of post<br>[title] - post title<br>[comment] - comment text');?></small>)<br>
<textarea name="message" id="message" cols="60" rows="5"><?php echo($comminform_message); ?></textarea></td></tr>
</table>
<p>
<input type="submit" value="Save" class="button">
<input type="hidden" name="comminform" value="savesettings">
</p>
</form>
</div>
<?php
}

//Hook for post comment
function comminform_commentpost($commentid, $status=0) {
	$comment=get_comment($commentid, $postdata);
	if(isset($comment) && is_object($comment)) {
		$postid=$comment->comment_post_ID;
	} else {
		return;
	}
	$comminform_name=get_post_meta($postid, get_option("comminform_namekey"), "");
        $comminform_email=get_post_meta($postid, get_option("comminform_emailkey"), "");
        $subject=get_option("comminform_subject");
        $message=get_option("comminform_message");

        if(is_array($comminform_name) && isset($comminform_name[0]) ) {
        	$commname=$comminform_name[0];
        } else {
        	$commname=$comminform_name;
        }
        if(is_array($comminform_email) && isset($comminform_email[0]) ) {
        	$commemail=$comminform_email[0];
        } else {
        	$commemail=$comminform_email;
        }
        if($commname != "" && $commemail !="") {
        	$post=get_post($postid);
        	$message=str_replace("[name]", $commname, $message);
        	$message=str_replace("[url]", $post->guid, $message);
        	$message=str_replace("[title]", $post->post_title, $message);
        	$message=str_replace("[comment]", $comment->comment_content, $message);
        	wp_mail($commemail, $subject, $message);
        } else {
        	return;
        }
}

add_action("comment_post", "comminform_commentpost");
?>