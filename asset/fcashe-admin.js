jQuery( document ).ready(function() {

    swich_display(jQuery(".storage:checked").val());

    jQuery(".storage").change(function() {
        swich_display(jQuery(this).val());
    });

    function swich_display(value)
    {
        if(value == 'files')
        {
            jQuery("#fieldrow-files_htaccess").show();
            jQuery("#fieldrow-files_path").show();
            jQuery("#fieldrow-memcache_host").hide();
            jQuery("#fieldrow-memcache_port").hide();
            jQuery("#fieldrow-redis_host").hide();
            jQuery("#fieldrow-redis_port").hide();
            jQuery("#fieldrow-redis_pass").hide();
            jQuery("#fieldrow-redis_database").hide();
            jQuery("#fieldrow-redis_timeout").hide();
        }

        if(value == 'sqlite')
        {
            jQuery("#fieldrow-files_htaccess").hide();
            jQuery("#fieldrow-files_path").hide();
            jQuery("#fieldrow-memcache_host").hide();
            jQuery("#fieldrow-memcache_port").hide();
            jQuery("#fieldrow-redis_host").hide();
            jQuery("#fieldrow-redis_port").hide();
            jQuery("#fieldrow-redis_pass").hide();
            jQuery("#fieldrow-redis_database").hide();
            jQuery("#fieldrow-redis_timeout").hide();
        }

        if(value == 'sqlite' || value == 'apc')
        {
            jQuery("#fieldrow-files_htaccess").hide();
            jQuery("#fieldrow-files_path").hide();
            jQuery("#fieldrow-memcache_host").hide();
            jQuery("#fieldrow-memcache_port").hide();
            jQuery("#fieldrow-redis_host").hide();
            jQuery("#fieldrow-redis_port").hide();
            jQuery("#fieldrow-redis_pass").hide();
            jQuery("#fieldrow-redis_database").hide();
            jQuery("#fieldrow-redis_timeout").hide();
        }

        if(value == 'memcache' || value == 'memcached')
        {
            jQuery("#fieldrow-files_htaccess").hide();
            jQuery("#fieldrow-files_path").hide();
            jQuery("#fieldrow-memcache_host").show();
            jQuery("#fieldrow-memcache_port").show();
            jQuery("#fieldrow-redis_host").hide();
            jQuery("#fieldrow-redis_port").hide();
            jQuery("#fieldrow-redis_pass").hide();
            jQuery("#fieldrow-redis_database").hide();
            jQuery("#fieldrow-redis_timeout").hide();
        }

        if(value == 'redis' || value == 'predis')
        {
            jQuery("#fieldrow-files_htaccess").hide();
            jQuery("#fieldrow-files_path").hide();
            jQuery("#fieldrow-memcache_host").hide();
            jQuery("#fieldrow-memcache_port").hide();
            jQuery("#fieldrow-redis_host").show();
            jQuery("#fieldrow-redis_port").show();
            jQuery("#fieldrow-redis_pass").show();
            jQuery("#fieldrow-redis_database").show();
            jQuery("#fieldrow-redis_timeout").show();
        }
    }
});