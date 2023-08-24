<?php

/**
 * Test projects plugin
 */
class TestProjectsPlugin extends MantisPlugin
{
    /**
     * A method that populates the plugin information and minimum requirements.
     * @return void
     */
    function register()
    {
        $this->name = 'Test projects';
        $this->description = 'Create projects, bugs and users';
        $this->page = '';

        $this->version = MANTIS_VERSION;
        $this->requires = array(
            'MantisCore' => '2.25.0',
        );

        $this->author = 'Andrii Dats';
    }

    /**
     * Plugin initialization
     * @return void
     */
    function init()
    {
        plugin_require_api('core/graph_api.php');
        plugin_require_api('core/Period.php');
        require_api('summary_api.php');
    }

    /**
     * Default plugin configuration.
     * @return array
     */
    function config()
    {
        return array();
    }

    /**
     * Plugin events
     * @return array
     */
    function events()
    {
        return array();
    }

    /**
     * plugin hooks
     * @return array
     */
    function hooks()
    {
        $t_hooks = array();
        return $t_hooks;
    }
}
