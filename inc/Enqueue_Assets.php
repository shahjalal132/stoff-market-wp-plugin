<?php

class Enqueue_Asstes {
    public function __construct() {
        $this->setup_hooks();
    }

    public function setup_hooks() {
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_css' ] );
        add_action( 'wp_enqueue_scripts', [ $this, 'enqueue_js' ] );
    }

    public function enqueue_css() {
        wp_enqueue_style( "stoff-bootstrap", STOFF_PLUGIN_URI . "/assets/css/bootstrap.min.css", [], false, "all" );
        wp_enqueue_style( "stoff-style", STOFF_PLUGIN_URI . "/assets/css/style.css", [ 'stoff-bootstrap' ], false, "all" );
    }

    public function enqueue_js() {
        wp_enqueue_script( "stoff-bootstrap-js", STOFF_PLUGIN_URI . "/assets/js/bootstrap.bundle.min.js", [], false, true );
        wp_enqueue_script( "stoff-app", STOFF_PLUGIN_URI . "/assets/js/app.js", [ 'jquery' ], false, true );
    }
}

new Enqueue_Asstes();