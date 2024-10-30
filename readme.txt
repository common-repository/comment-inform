=== Comment Inform ===
Contributors: ivanchenchov
Donate link: http://ivanauto.ru/donate/index.php
Tags: comment, notify, posts
Requires at least: 2.6.0
Tested up to: 2.8.4
Stable tag: trunk

This plugin for sent information about comment to post author. Infromation about authors gets from custom fields. Custom fields keys are "Author email" and "Author name".

== Description ==

This plugin for sent information about comment to post author.
Information about author name and author e-mails sets in custom fields for each post.
In configuration of plugin you can set keys name for custom fields. By default this is "Author name" and "Author email".
Also can set subject and body of notification e-mail.
In body of e-mail you can use macros:

[name]    - name of authr from custom field
[url]     - post url
[title]   - post title
[comment] - comment text


== Installation ==

1. Upload `comminform.php` to the `/wp-content/plugins/` directory or to `/wp-content/plugins/commplugin/`
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Configure plugin throught 'Settings' -> 'Comment Inform'
4. When edit post add custom fields and set value for "Author name" and "Author email"

== Screenshots ==
1. Configure plugin
2. Set custom fields in post

== Changelog ==

= 1.0 =
* Start version


