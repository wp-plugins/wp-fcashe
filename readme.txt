=== WP Fcashe ===
Contributors: veisis
Tags: cache, caching, fragment cache, partial cache, output caching, optimize, performance, speed,  page cache
Requires at least: 3.3
Tested up to: 4.2.2
Stable tag: 0.1.1

Fragment caching for WordPress themes and plugins

== Description ==
Warning: This plugin on it's own don't do anything. Integrate it in your theme or plugin.

Usage:
`if ( !f_cache_start('key', 180) ) {

	//printing data

	f_cache_end(); // IMPORTANT don't forgot this
}`

= Function reference: =

- **f_cache_start(key, TTL)** - output cache content or start new cache record.
- **c_start(key, TTL)** - alias to f_cache_start.
- **f_cache_end** - store cache.
- **c_end** - alias to f_cache_end.
- **f_cache_delete(key)** - delete cached content by key.
- **c_delete(key)** - alias to f_cache_delete.
- **f_cache_clear** - delete all cached content.

== Installation ==
1. Install plugin via WordPress plugin manager and activate it (https://codex.wordpress.org/Managing_Plugins).
2. Go to WP Fcashe settings page and configure plugin.
3. Integrate caching functions to optimize your theme and plugins.

== Changelog ==
= 0.1.1 =
Fix admin framework include.

= 0.1 =
Initial release.