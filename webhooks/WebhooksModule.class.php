<?php

/**
 * Webhooks module definition
 *
 * @package    activeCollab.modules.webhooks
 * @subpackage models
 */
class WebhooksModule extends AngieModule
{

    /**
     * Plain module name
     *
     * @var string
     */
    protected $name = 'webhooks';

    /**
     * Module version
     *
     * @var string
     */
    protected $version = '2.0';

    // ---------------------------------------------------
    //  Events and Routes
    // ---------------------------------------------------

    /**
     * Define module routes
     */
    function defineRoutes()
    {
        // Admin
        Router::map(
            'admin_webhooks',
            '/admin/tools/webhooks',
            array('controller' => 'webhooks_admin', 'action' => 'index')
        );
    } // defineRoutes

    /**
     * Define event handlers
     */
    function defineHandlers()
    {
        EventsManager::listen('on_admin_panel', 'on_admin_panel');

        foreach (Webhooks::getEvents() as $eventname) {
            EventsManager::listen($eventname, 'callback_' . $eventname);

            // grab content
            $content = file_get_contents(ENVIRONMENT_PATH . '/custom/modules/webhooks/resources/callback_template.php');

            $path = ENVIRONMENT_PATH . '/custom/modules/webhooks/handlers/callback_' . $eventname . '.php';

            // create handler if needed
            if (!is_file($path)) {
                if (!is_writable(dirname($path))) {
                    throw new Exception($path . ' is not writable!');
                }

                // alter template
                $fileContent = str_replace('{$eventname}', $eventname, $content);

                // store file
                file_put_contents($path, $fileContent);
            }
        }
    } // defineHandlers

    // ---------------------------------------------------
    //  Name
    // ---------------------------------------------------

    /**
     * Get module display name
     *
     * @return string
     */
    function getDisplayName()
    {
        return lang('Webhooks');
    } // getDisplayName

    /**
     * Return module description
     *
     * @return string
     */
    function getDescription()
    {
        return lang('Enables you to call an external url on an event-base');
    } // getDescription

    /**
     * Return module uninstallation message
     *
     * @return string
     */
    function getUninstallMessage()
    {
        return lang('Module will be deactivated. All data generated using it will be deleted');
    } // getUninstallMessage

}
