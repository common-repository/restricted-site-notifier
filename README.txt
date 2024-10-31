=== Restricted Site Notifier ===
Contributors: fliz, kona
Tags: restricted site access, admin bar, admin icon, restricted site status
Requires at least: 3.8
Tested up to: 6.7
Stable tag: 1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add-on for Restricted Site Access plugin. Displays site's current restriction status in the admin bar.

== Description ==

The [Restricted Site Access](https://wordpress.org/plugins/restricted-site-access/ "Restricted Site Access") plugin allows you to restrict a whole WordPress site to be visible only to logged-in users.  This is very handy for development sites, and for providing members-only sites with no publicly-visible content.

This simple add-on plugin for Restricted Site Access adds a notification icon and message to the admin bar, showing the site's current restriction status.  This notification is only visible to admin-capable users, and means that an admin can always see the site's current restriction status at a glance.  

The plugin shows a locked padlock and a RESTRICTED status message if the Site Visibility setting has been restricted to logged-in or allowed-by-IP users.

It shows an unlocked padlock and an UNRESTRICTED status message for all other settings of Site Visibility.


== Installation ==

1. Install this plugin via the WordPress plugin control panel, 
or by manually downloading it and uploading the extracted folder 
to the `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.
3. That's all! There are no configurable options for this plugin.

== Frequently Asked Questions ==

= I'm not seeing the notification in my admin menu bar - help! =

For the notification to appear, the following things are required:

1. The Restricted Site Access plugin should be both installed and activated.

2. You should be logged in using an account with permission to activate
plugins (e.g. a site admin or multisite admin/super-admin account.)

Check that both of these are true if you're not seeing the notification in
the admin menu bar.

= Can I use this plugin with older versions of Wordpress? =

The plugin may work with older versions of WordPress (for example,
it runs successfully in WP 3.6).  However, the padlock icons will not 
appear in the admin bar for releases before WP 3.8.

= I hate the coloured padlock icons, how do I remove their colour? =

You can use the following CSS to set the padlock icons back to the 
default colour / theme-specified colour:

	#wpadminbar .flizrsn-locked .ab-item:before {
		color: inherit !important;
	}
	#wpadminbar .flizrsn-unlocked .ab-item:before {
		color: inherit !important;
	}

== Screenshots ==

1. Admin bar showing status when site access is restricted

2. Admin bar showing status when site access is unrestricted 

== Changelog ==

= 1.1 =
* Load translations later

= 1.0.1 =
* Loosen capability check to include multisite admins as well as superadmins

= 1.0.0 =
* Initial version

== Upgrade Notice ==

= 1.0.0 =
Initial version
