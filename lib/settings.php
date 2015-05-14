<?php
include( dirname( __FILE__ ) . '/admin-page-framework/admin-page-framework.php' );
if ( ! class_exists( 'Fcache_AdminPageFramework' ) ) {
    return;
}

class Fcache_Admin extends Fcache_AdminPageFramework {

    public function setUp() {

        // Create the root menu - specifies to which parent menu to add.
        // the available built-in root menu labels: Dashboard, Posts, Media, Links, Pages, Comments, Appearance, Plugins, Users, Tools, Settings, Network Admin
        $this->setRootMenuPage( 'Settings' );

        // Add the sub menus and the pages
        $this->addSubMenuItems(
            array(
                'title'     => 'WP Fcache',        // the page and menu title
                'page_slug' => 'wp_fcache',         // the page slug
            )
        );
    }

    public function load_wp_fcache( $oAdminPage ) {    // load_{page slug}

        $this->addSettingFields(
            array(
                'field_id'      => 'storage',
                'type'          => 'radio',
                'default'       => 'files',
                'label'         => array(
                    'files'     => __( 'files', 'fcache' ),
                    'sqlite'    => __( 'sqlite', 'fcache' ),
                    'apc'       => __( 'apc', 'fcache' ),
                    'memcache'  => __( 'memcache', 'fcache' ),
                    'memcached' => __( 'memcached', 'fcache' ),
                    'redis'     => __( 'redis', 'fcache' ),
                    //'predis'    => __( 'predis', 'fcache' ),
                ),
                'attributes'    => array(
                    'class'     => 'storage',
                ),
                'title'         => __( 'Storage engine', 'fcache' ),
                'description' => __( 'Will silently fall back to files engine if chosen engine configurations is not working.', 'fcache' ),
            ),
            array(
                'field_id'      => 'security_key',
                'type'          => 'radio',
                'title'         => __( 'Security key mode', 'fcache' ),
                'default'       => 'auto',
                'label'         => array(
                    'auto'      => __( 'Single domain name', 'fcache' ),
                    '1'         => __( 'Alias domain name', 'fcache' ),
                ),
            ),
            array(
                'field_id'      => 'files_htaccess',
                'type'          => 'radio',
                'default'       => 1,
                'label'         => array(
                    0           => __( 'No', 'fcache' ),
                    1           => __( 'Yes', 'fcache' ),
                ),
                'title'         => __( 'Create .htaccess to protect cache folder?', 'fcache' ),
            ),
            array(
                'field_id'      => 'files_path',
                'type'          => 'text',
                'title'         => __( 'Path to cache folder', 'fcache' ),
                'attributes'    => array(
                    'size'      => 60,
                ),
                'description' => __( 'Leave it blank for auto detect. By default will try to create cache folder outside your public_html.', 'fcache' ),
            ),
            array(
                'field_id'      => 'memcache_host',
                'type'          => 'text',
                'default'       => '127.0.0.1',
                'title'         => __( 'Memcache / Memcached host', 'fcache' ),
                'attributes'    => array(
                    'size'      => 40,
                ),
                'description' => __( 'Default: 127.0.0.1', 'fcache' ),
            ),
            array(
                'field_id'      => 'memcache_port',
                'type'          => 'text',
                'default'       => '11211',
                'title'         => __( 'Memcache / Memcached port', 'fcache' ),
                'attributes'    => array(
                    'size'      => 20,
                ),
                'description' => __( 'Default: 11211', 'fcache' ),
            ),
            array(
                'field_id'      => 'redis_host',
                'type'          => 'text',
                'default'       => '127.0.0.1',
                'title'         => __( 'Redis / Predis host', 'fcache' ),
                'attributes'    => array(
                    'size'      => 40,
                ),
                'description' => __( 'Default: 127.0.0.1', 'fcache' ),
            ),
            array(
                'field_id'      => 'redis_port',
                'type'          => 'text',
                'default'       => '6379',
                'title'         => __( 'Redis / Predis port', 'fcache' ),
                'attributes'    => array(
                    'size'      => 20,
                ),
                'description' => __( 'Default: 6379', 'fcache' ),
            ),
            array(
                'field_id'      => 'redis_pass',
                'type'          => 'text',
                'title'         => __( 'Redis / Predis password', 'fcache' ),
                'attributes'    => array(
                    'size'      => 40,
                ),
            ),
            array(
                'field_id'      => 'redis_database',
                'type'          => 'text',
                'title'         => __( 'Redis / Predis database', 'fcache' ),
                'attributes'    => array(
                    'size'      => 40,
                ),
            ),
            array(
                'field_id'      => 'redis_timeout',
                'type'          => 'text',
                'title'         => __( 'Redis / Predis timeout', 'fcache' ),
                'attributes'    => array(
                    'size'      => 10,
                ),
            ),
            array( // Submit button
                'field_id'      => 'submit_button',
                'type'          => 'submit',
            )
        );

        $this->enqueueScripts(  dirname( __FILE__ ) . '/../asset/fcashe-admin.js', 'wp_fcache' ); // a path can be used
    }
}

new Fcache_Admin;