<?php

/**
 * Test projects plugin
 */
class TestProjectsPlugin extends MantisPlugin
{
    /**
     * A method that populates the plugin information and minimum requirements.
     *
     * @return void
     */
    function register()
    {
        $this->name = 'Test projects';
        $this->description = 'Create projects, bugs and users';
        $this->page = plugin_page('generate_data');

        $this->version = MANTIS_VERSION;
        $this->requires = array(
            'MantisCore' => '2.25.0',
        );

        $this->author = 'Andrii Dats';
    }

    /**
     * Plugin initialization
     *
     * @return void
     */
    function init()
    {
        plugin_require_api('core/generate_api.php');
    }

    /**
     * Default plugin configuration.
     *
     * @return array
     */
    function config()
    {
        return array();
    }

    /**
     * plugin hooks
     *
     * @return array
     */
    function hooks()
    {
        $t_hooks = array(
            'EVENT_MENU_MANAGE' => 'manageMenu',
        );
        return $t_hooks;
    }

    /**
     * Add page for partially generate data
     *
     * @return array
     */
    public function manageMenu()
    {
        return [
            '<a href="' . plugin_page('generate_data') . '">Generate Data</a>',
        ];
    }
}
