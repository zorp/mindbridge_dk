=== Iframely Responsive Embeds ===
Contributors: psergeev, ivanp
Tags: iframely, oembed, embed, responsive, video, youtube, vimeo, instagram, gist, fitvids, mu
Requires at least: 3.5.1
Tested up to: 4.0
Stable tag: trunk
License: MIT


Iframely converts URLs in your posts into responsive embed widgets for 1600+ domains and providers summary cards for others. No API Key is required.

== Description ==

[Iframely](https://iframely.com?from=wp) brings you the responsive embeds and support of over 1600 domains. It means the embeds will resize, if possible, if you are on responsive theme. 


Iframely will detect URLs in your posts and replace it with embed codes for *over 1600 domains*. Supports all usual suspects such as YouTube, Vimeo, Instagram, GitHub Gists, Google +, Facebook Posts, Storify, SlideShare, well, you know, over 1.6 thousand of them and keeps growing. [Here's some samples](https://iframely.com/try).

Iframely will also generate and host summary cards for general links, such as articles. API Key is not required, though you can optionally connect your Iframely account, if you need.


_How to use_: 

The plugin works the same way the standard oEmbed is supported by WordPress: URL on a separate line. 

For example, 


`
Check out this cool video:

http://iframe.ly/fquGGl

That was a cool video.
`


Iframely also has its own shortcode `[iframely]http://your.url/here[/iframely]`.


_Note of caution_: 

Some people expect Iframely to wrap URLs with <code>&lt;iframe src=...&gt;</code> code. That's not what Iframely is for. The plugin converts original URLs into native embed codes itself.


_Tell Iframely not to override default embed providers._: 

By default, Iframely will inject itself to be the first embeds provider in the list, thus intercepting all URLs. It means that the default providers that are later in the list won't get called and will thus be disabled. 

For example, default YouTube, Vimeo, Twitter, other oEmbed plugins that you have (like JetPack), etc. 

Although, we should support the same providers and output the same code, just make it responsive, you can still disable such behavior and tell Iframely to only process links that otherwise don't have embed provider. 

Just configure this option in your settings. It will essentially put Iframely to be the last in the list, be "a catcher", rather then "an interceptor".


_API Key_: 

API key is not required. You can leave this field empty in your settings. If you'd like to connect your Iframely account though - configure your API key. [https://iframely.com](https://iframely.com?from=wp). 



The source code of the plugin is published [on GitHub](https://github.com/itteco/iframely-wordpress), if you'd like to tweak it yourself. With no API Key, it will use our [open oEmbed API](http://oembedapi.com). Make sure to tell about this free API to your developer friends.




== Installation ==

The installation is pretty standard:

1. Upload the package contents to to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Go to plugin settings to configure Iframely the way you want to use it.
4. If you'd like Iframely to process _all_ URLs, [get your FREE API Key here](http://iframe.ly).


== Screenshots ==

Here's some samples of what Iframely supports. 

1. Instagram sample
2. Vimeo sample
3. GitHub Gists
4. Google+ Posts
5. Imgur & Galleries
6. Facebook Statues
7. And many-many others

[Here's some more samples](https://iframely.com/try).

== Frequently Asked Questions ==

= Oh, the Facebook! = 

Yes, Iframely knows the embed codes for Facebook posts, photos and videos. However, some of the posts can be private and not accesssible to our parsers. For those, we can not convert the URL into embed code. Also, Facebook pages and events don't have native embed codes and so Iframely doesn't support these too. 

= I thought Iframely would wrap my URL into iframe? =

That's not a purpose of the plugin. Iframely works with original URLs and will detect the frame's `src` itself. If you just want to use `<iframe>`, switch your editor to HTML format and past iframe code in there.

= How do I resize my widgets? = 

Well, that's the point of responsive embeds. You don't have to. 

Iframely widgets will take 100% available width. If you need to limit it, just define your CSS styles for `iframely-widget-container`.

Please, note that not all the embeds codes will be responsive. Some of hosting domains can not be converted responsively. In those cases, Iframely will left-align the embeds. You might want to consider padding and alignment styles, if you don't have generic ones for `iframes` and `images` yet.

= Is it compatible with other embeds plugins I have? =

* Iframely works in the same WordPress embeds framework as other plugins would. 
* Since default WordPress embeds are not responsive, Iframely can disable the standard code and replaces it with the responsive embeds. Otherwise, you might be wondering why is some widgets are not responsive 
* You can conifugure Iframely to only work in its own shortcode, thus leaving other plugins intact.

= What about embeds in my previous posts? =

Iframely works in native WordPress embeds framework. All your new posts should start seeing responsive widgets. The older posts will be re-cached via WordPress logic itself (usually when you edit and save the post), and should granually get the new embeds code too. However, we do not interfere into this default process and do not re-cache older posts upon install. 

If there's a specific post you'd like to update, just go to Edit and Save it again. It should re-cache it and trigger Iframely.

= Will my other shortcodes work? =

Iframely does not change behavior of other shortcode plugins. Everything should work the old way, except for `[embed]` shortcode, which will now start producing responsive widgets unless limited in size.

= Does it support WordPress MU? =

Iframely will work well with multisite installations. Iframely options page is available for super admins only, and the settings will be the same for all blogs on your WPMU setup. 


== Changelog ==

= 0.2.5 =

 - We know you'll be happy about it. Our "No API Key is required" stance is back. API Key is now optional for Iframely WordPress plugin.



= 0.2.4 =

 - Makes Iframely work with WordPress 4.0 real-time previews


= 0.2.3 =

 - We enabled the hosted widgets. With it, we now can give you embed codes for videos that autoplay. We also handle SSL well, and provide graceful fallbacks for Flash videos for your iOS/mobile visitors. To enable this option, turn it on in Iframely settings.

 - We also fixed the broken link to Iframely settings. The one that was on plugins list page, so it properly links to the same settings you have in main (left) menu.


= 0.2.2 =

This version includes fixes for WordPress Multisite. Iframely plugin options page will be available only for the super admins. 

The regular WP installations should remain intact and do not require an instant upgrade. 


= 0.2.0 =

There are 3 main changes: API Key, Shortcode, and Options page.

 - In order to keep our servers up and running, we need to secure the API with the API Key. Get your [FREE API Key here](http://iframe.ly?from=wp). 
 - If you don't want the hastle of configuring API Key, just shorten your links manually at [http://iframe.ly](http://iframe.ly?from=wp) first, before pasting it into your post. The short URL will come with the embed codes attached to it.
 - Also, Iframely now has the options page where you can configure the way you'd like to use it.
 - For example, you can opt to use Iframely in `[iframely]` shortcode only, leaving all the other default oEmbed providers intact.
 - `[iframely]http://your.url/here[/iframely]` shortcode itself was introduced in this version.



= 0.1.0 =

This is our initial release. Please, rate if you like the plugin. 

And please, help do submit issues if you see any.



== Upgrade Notice ==

= 0.2.5 =

Hey, we know you'll be happy about it. Our "No API Key is required" stance is back. API Key is now optional for Iframely WordPress plugin.


= 0.2.4 =

Makes Iframely work with WordPress 4.0 (sigh)

= 0.2.3 =

This version enables the "hosted widgets" option (to properly handle autoplay videos, SSL, Flash-on-iOS and also improve load times). 

= 0.2.2 =

This is a patch for WordPress MU. If you are on a single site installations, you can safely skip this version.

= 0.2.0 =

In order to keep our API servers up and running, we need to secure the API with the API Key. Get your FREE API Key at iframe.ly. The previous (open) API will be available until August 1st, 2014 only. 