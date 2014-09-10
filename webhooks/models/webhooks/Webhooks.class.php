<?php

/**
 * webhooks manager class
 *
 * @package    activeCollab.modules.webhooks
 * @subpackage models
 */
class Webhooks extends ApplicationObject
{
    const VERSION = '2.0.0';

    /**
     * Name of the table where records are stored
     *
     * @var string
     */
    protected $table_name = 'webhooks';

    /**
     * All table fields
     *
     * @var array
     */
    protected $fields = array('id', 'event', 'callback');

    /**
     * Primary key fields
     *
     * @var array
     */
    protected $primary_key = array('id');

    /**
     * Name of AI field (if any)
     *
     * @var string
     */
    protected $auto_increment = 'id';

    /**
     * Handle an event
     *
     * @param unknown_type $event
     * @param unknown_type $args
     */
    static function handleEvent($event, $args)
    {
        // grab the webhook
        $webhook = new Webhooks();
        $webhook->findByEventname($event);

        // valid webhook?
        if ($webhook !== null) {
            // set options
            $options[CURLOPT_URL] = $webhook->getCallback();
            $options[CURLOPT_USERAGENT] = 'ActiveCollab/' . APPLICATION_VERSION . ' Webhooks/' . self::VERSION;
            $options[CURLOPT_TIMEOUT] = 5;
            $options[CURLOPT_HTTP_VERSION] = CURL_HTTP_VERSION_1_1;
            $options[CURLOPT_FAILONERROR] = true;
            $options[CURLOPT_FOLLOWLOCATION] = true;
            $options[CURLOPT_SSL_VERIFYPEER] = false;
            $options[CURLOPT_SSL_VERIFYHOST] = false;
            $options[CURLOPT_POST] = true;
            $options[CURLOPT_POSTFIELDS]['event'] = $event;
            if (!empty($args)) {
                $options[CURLOPT_POSTFIELDS]['data'] = @serialize($args);
            }

            // init
            $curl = curl_init();

            // set options
            curl_setopt_array($curl, $options);

            // execute
            curl_exec($curl);

            // close
            curl_close($curl);
        }
    }

    /**
     * Get all events
     *
     * @return array
     */
    static function getEvents()
    {
        return array(
            'on_activity_log_decorator',
            'on_acivity_log_decorator',
            'on_activity_log_callbacks',
            'on_admin_panel',
            'on_admin_tabs',
            'on_after_object_save',
            'on_after_object_validation',
            'on_all_indices',
            'on_asset_types',
            'on_attachment_options',
            'on_available_project_tabs',
            'on_before_object_deleted',
            'on_before_object_insert',
            'on_before_object_save',
            'on_before_object_update',
            'on_before_object_validation',
            'on_build_names_search_index_for_project',
            'on_build_project_search_index',
            'on_calendar_tabs',
            'on_client_invoices_tabs',
            'on_comment_deleted',
            'on_comment_options',
            'on_comments_for_widget_options',
            'on_context_domains',
            'on_daily',
            'on_documents_tabs',
            'on_empty_trash',
            'on_frequently',
            'on_get_completable_project_object_types',
            'on_get_day_project_object_types',
            'on_homescreen_tab_types',
            'on_homescreen_widget_types',
            'on_hourly',
            'on_incoming_mail_actions',
            'on_inline_tabs',
            'on_invoices_tabs',
            'on_label_types',
            'on_main_menu',
            'on_mass_edit',
            'on_master_categories',
            'on_milestone_sections',
            'on_new_gateway',
            'on_notification_inspector',
            'on_object_completed',
            'on_object_context_changed',
            'on_object_deleted',
            'on_object_from_notification_context',
            'on_object_inserted',
            'on_object_inspector',
            'on_object_opened',
            'on_object_options',
            'on_object_updated',
            'on_people_tabs',
            'on_phone_homescreen',
            'on_portal_milestone_add_links',
            'on_portal_milestone_objects',
            'on_portal_object_quick_options',
            'on_project_additional_step',
            'on_project_additional_steps',
            'on_project_assets_new_options',
            'on_project_brief_stats',
            'on_project_deleted',
            'on_project_export',
            'on_project_object_category_copied',
            'on_project_object_copied',
            'on_project_object_moved',
            'on_project_overview_sidebars',
            'on_project_permissions',
            'on_project_subcontext_permission',
            'on_project_tabs',
            'on_project_user_added',
            'on_project_user_removed',
            'on_project_user_replaced',
            'on_project_user_updated',
            'on_projects_tabs',
            'on_quick_add',
            'on_rawtext_to_richtext',
            'on_rebuild_activity_log_actions',
            'on_rebuild_all_indices',
            'on_rebuild_names_search_index_steps',
            'on_rebuild_object_contexts_actions',
            'on_reports_panel',
            'on_reports_tabs',
            'on_reserved_project_slugs',
            'on_search_indices',
            'on_shutdown',
            'on_status_bar',
            'on_subtask_options',
            'on_subtasks_for_widget_options',
            'on_system_notifications',
            'on_system_permissions',
            'on_system_role_options',
            'on_trash_map',
            'on_trash_sections',
            'on_user_cleanup',
            'on_users_tabs',
            'on_visible_contexts',
            'on_wireframe_updates'
        );
    }

    /**
     * Return value of id field
     *
     * @param void
     * @return integer
     */
    function getId()
    {
        return $this->getFieldValue('id');
    } // getId

    /**
     * Set value of id field
     *
     * @param integer $value
     * @return integer
     */
    function setId($value)
    {
        return $this->setFieldValue('id', $value);
    } // setId

    /**
     * Return value of callback field
     *
     * @param void
     * @return string
     */
    function getCallback()
    {
        return $this->getFieldValue('callback');
    } // getCallback

    /**
     * Set value of callback field
     *
     * @param string $value
     * @return string
     */
    function setCallback($value)
    {
        return $this->setFieldValue('callback', $value);
    } // setCallback

    /**
     * Return value of event field
     *
     * @param void
     * @return string
     */
    function getEvent()
    {
        return $this->getFieldValue('event');
    } // getEvent

    /**
     * Set value of event field
     *
     * @param string $value
     * @return string
     */
    function setEvent($value)
    {
        return $this->setFieldValue('event', $value);
    } // setEvent


    /**
     * Return object by eventname
     *
     * @param mixed $event
     * @return SourceRepository
     */
    function findByEventname($event)
    {
        if (empty($event)) {
            return null;
        }

        $row = DB::executeFirstRow(
            'SELECT ' . implode(', ', $this->fields) .
            ' FROM ' . $this->table_name .
            ' WHERE event = ' . DB::escape($event)
        );

        if ($row === null) {
            $this->setEvent($event);
            return null;
        }

        $this->setNew(false);
        $this->setId($row['id']);
        $this->setCallback($row['callback']);
        $this->setEvent($row['event']);
    } // findByEventname

    /**
     * Return name of this model
     *
     * @param boolean $underscore
     * @param boolean $singular
     * @return string
     */
    function getModelName($underscore = false, $singular = false)
    {
        if ($singular) {
            return $underscore ? 'webhook' : 'Webhook';
        } else {
            return $underscore ? 'webhooks' : 'Webhooks';
        } // if
    } // getModelName
}
