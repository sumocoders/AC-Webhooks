<?php

/**
 * on_admin_panel event handler
 *
 * @package    activeCollab.modules.webhooks
 * @subpackage handlers
 */

/**
 * Handle on_admin_panel event
 *
 * @param AdminPanel $admin_panel
 */
function webhooks_handle_on_admin_panel(AdminPanel &$admin_panel)
{
    $admin_panel->addToTools(
        'webhooks',
        lang('Webhooks Settings'),
        Router::assemble('admin_webhooks'),
        AngieApplication::getImageUrl('admin_panel/webhooks-settings.png', WEBHOOKS_MODULE),
        array(
            'onclick' => new FlyoutFormCallback(array(
                    'success_event' => 'webhooks_updated',
                    'success_message' => lang('Webhooks have been updated'),
                ))
        )
    );
} // webhooks_handle_on_admin_panel
