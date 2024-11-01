=== WC Discord Invite ===
Contributors: nicolamustone
Tags: discord, email, server, chat, gaming, streaming, twitch, community, woocommerce
Requires at least: 4.4
Tested up to: 4.9.4
Stable tag: 1.0.0
License: GPLv2
License URI: https://www.gnu.org/licenses/gpl-2.0.html

A **WooCommerce** integration that sends an email with a Discord invite link to the customer when the order status changes from one status to another.

== Description ==

WC Discord Invite is a free WooCommerce integration that sends an email to your customers when their order status changes according to the integartion settings. The email sent includes an invite to your Discord server.

You can configure it by going to **WooCommerce > Settings > Integration > WC Discord Invite** and filling in all the details. The fields are all required. Once that is done, configure the email settings in **WooCommerce > Settings > Emails**.

== Installation ==

= Automatic installation =

Automatic installation is the easiest option as WordPress handles the file transfers itself and you don’t need to leave your web browser. To do an automatic install of WC Discord invite, log in to your WordPress dashboard, navigate to the Plugins menu and click Add New.

In the search field type “WC Discord Invite” and click Search Plugins. Once you’ve found the plugin you can view details about it such as the point release, rating and description. Most importantly of course, you can install it by simply clicking “Install Now”.

= Manual installation =

The manual installation method involves downloading this plugin plugin and uploading it to your web-server via your favourite FTP application. The WordPress codex contains [instructions on how to do this here](https://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

= Updating =

Automatic updates should work like a charm; as always though, ensure you backup your site just in case.

== Frequently Asked Questions ==

= How can I customize the email? =

You can completely customize the email template the same way you do for WooCommerce. Copy the template `wp-content/plugins/wc-discord-invite/templates/emails/discord-invite.php` and paste it in your theme in the folder `woocommerce/emails/`, then edit it as you wish. Read more about templates override [here](https://docs.woocommerce.com/document/template-structure/).

= The invite email is not being sent. What do I do? =

Install the free plugin [Email Log](https://wordpress.org/plugins/email-log/) and trigger the Discord invite email with a new order, changing its status to what you chose in the integration settings. Now go to **Email Log > View Logs** and check if the email appears there. If yes, the issue is not with this plugin but most likely with your host.

= The invite has been sent but I want to send it again. How do I do it? =

Edit the order in Orders > All Orders. On the right of the order edit screen find the section **Order actions** and choose the option **Resend Discord invite** from the dropdown. Then click the **>** button.

== Changelog ==

= 1.0.0 =
* First release!
