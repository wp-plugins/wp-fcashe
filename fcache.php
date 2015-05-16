<?php
/* Plugin Name: WP Fcashe
Description: Fragment caching for WordPress themes and plugins
Version: 0.1
*/

/*
Usage:
	if ( !f_cache_start('key', 180) ) {

		//printing data

		f_cache_end(); // IMPORTANT don`t forgot this
	}
*/

// phpFastCache Library
require_once( dirname(__FILE__) . '/lib/phpfastcache/phpfastcache/3.0.4/phpfastcache.php' );
require_once( dirname( __FILE__ ) . '/lib/admin-page-framework/admin-page-framework.php' );

if ( is_admin() )
{
    require_once(dirname(__FILE__) . '/lib/settings.php');
}

//TODO: check $key length. Max 40 chars

class FCache {
	private $key;
    private $prefix;
	private $ttl = 30;
	private $time_start = 0;
    private $cache;

	public function __construct($prefix = '')
    {
        $this->prefix = $prefix;
        $this->cache = phpFastCache();
	}

	public function start($key, $ttl = 0)
    {
        if(is_int($ttl) && $ttl > 0)
        {
            $this->ttl = $ttl;
        }

        $key = trim($key);
        if(!empty($key))
        {
            $this->key = $key;
            $output = $this->cache->get($this->prefix.'_'.$this->key);
            if ( !empty( $output ) )
            {
                echo '<!-- From cache start -->'.$output.'<!-- From cache end -->';
                return true;
            }
            else
            {
                $this->time_start = microtime(true);
                ob_start();
                return false;
            }
        }

        return false;
	}

	public function end()
    {
        $output = ob_get_flush();
        $output .= '<!-- Fragment generation time: '.(microtime(true) - $this->time_start).' -->';
        $this->time_start = 0;
        $this->cache->set($this->prefix.'_'.$this->key, $output , $this->ttl);
	}

    public function clear_all()
    {
        return $this->cache->clean();
    }

    public function delete($key)
    {
        return $this->cache->delete($this->prefix.'_'.$key);
    }
}

//set config
function f_cache_init()
{
    // OK, setup your cache
    phpFastCache::$config = array(
        "storage"   =>  Fcache_AdminPageFramework::getOption( 'Fcache_Admin', 'storage', 'auto' ), // auto, files, sqlite, apc, cookie, memcache, memcached, predis, redis, wincache, xcache
        "default_chmod" => 0777, // For security, please use 0666 for module and 0644 for cgi.

        // create .htaccess to protect cache folder
        // By default the cache folder will try to create itself outside your public_html.
        // However an htaccess also created in case.
        "htaccess"      => (bool)Fcache_AdminPageFramework::getOption( 'Fcache_Admin', 'files_htaccess', true ),

        // path to cache folder, leave it blank for auto detect
        "path"      =>  Fcache_AdminPageFramework::getOption( 'Fcache_Admin', 'files_path', '' ),
        "securityKey"   =>  Fcache_AdminPageFramework::getOption( 'Fcache_Admin', 'security_key', 'auto' ), // auto will use domain name, set it to 1 string if you use alias domain name

        // MEMCACHE
        "memcache"        =>  array(
            array(Fcache_AdminPageFramework::getOption( 'Fcache_Admin', 'memcache_host', '127.0.0.1' ), (int)Fcache_AdminPageFramework::getOption( 'Fcache_Admin', 'memcache_port', '11211' ), 1),
        ),

        // REDIS
        "redis"         =>  array(
            "host"  => Fcache_AdminPageFramework::getOption( 'Fcache_Admin', 'redis_host', '127.0.0.1' ),
            "port"  =>  Fcache_AdminPageFramework::getOption( 'Fcache_Admin', 'redis_port', '6379' ),
            "password"  =>  Fcache_AdminPageFramework::getOption( 'Fcache_Admin', 'redis_pass', '' ),
            "database"  =>  Fcache_AdminPageFramework::getOption( 'Fcache_Admin', 'redis_database', '' ),
            "timeout"   =>  Fcache_AdminPageFramework::getOption( 'Fcache_Admin', 'redis_timeout', '' )
        ),

        "extensions"    =>  array(),

        /*
         * Fall back when old driver is not support
         */
        "fallback"  => "files",

    );
}

$f_cache_prefix = '';

/**
 * Detect multilangual site (common multilanguage plugin detection) and return language to use as prefix for caching key
 * @return string
 */
function f_cache_detect_prefix()
{
    global $f_cache_prefix;
    if(!empty($f_cache_prefix)) return $f_cache_prefix;

    if(defined('ICL_LANGUAGE_CODE')) //WPML
    {
        return ICL_LANGUAGE_CODE;
    }
    elseif(function_exists('pll_current_language')) //Polylang
    {
        return pll_current_language();
    }

    return '';
}

/**
 * Manually set prefix if automatic detection cant detect prefix
 * @param string $prefix
 */
function f_cache_set_prefix($prefix = '')
{
    global $f_cache_prefix;
    if(is_string($prefix)) $f_cache_prefix = $prefix;
}

f_cache_init();
$f_cache = new FCache(f_cache_detect_prefix());

/**
 * Output already cached content or start new output caching
 * @param $key
 * @param int $ttl
 * @return bool
 */
function f_cache_start($key, $ttl = 0)
{
    global $f_cache;
    return $f_cache->start($key, $ttl);
}

/**
 * Store generated output
 */
function f_cache_end()
{
    global $f_cache;
    $f_cache->end();
}

/**
 * Clear all cache
 */
function f_cache_clear()
{
    global $f_cache;
    return $f_cache->clear_all();
}

/**
 * Delete cache
 * @param $key
 * @return
 */
function f_cache_delete($key)
{
    global $f_cache;
    return $f_cache->delete($key);
}

/**
 * Alias for function f_cache_start
 * @param $key
 * @param int $ttl
 */
if(!function_exists('c_start'))
{
    function c_start($key, $ttl = 0)
    {
        return f_cache_start($key, $ttl = 0);
    }
}

/**
 * Alias for function f_cache_end
 */
if(!function_exists('c_end'))
{
    function c_end()
    {
        f_cache_end();
    }
}

/**
 * Alias for function f_cache_delete
 */
if(!function_exists('c_delete'))
{
    function c_delete($key)
    {
        return f_cache_delete($key);
    }
}

//TODO: add cache clearing on post edit
//TODO: add cache clearing on comments add/edit
//TODO: add cache clearing on user edit (for dynamic user specific widget caching)
//TODO: add clear cache button in admin