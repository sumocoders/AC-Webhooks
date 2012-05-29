<?php
  // We need admin controller
  AngieApplication::useController('admin');

  /**
   * Manages webhooks settings
   *
   * @package activeCollab.modules.webhooks
   * @subpackage controllers
   */
  class WebhooksAdminController extends AdminController {

    /**
     * Prepare controller
     */
    function __before() {
      parent::__before();
      $this->wireframe->breadcrumbs->add('webhooks_admin', lang('Webhooks'),Router::assemble('admin_webhooks'));
    } // __construct

    /**
     * Control panel for webhooks module
     */
    function index() {
      $webhooks_data = array();

      // initialize
      foreach(Webhooks::getEvents() as $eventname)
      {
        $webhook = Webhooks::findByEventname($eventname);

        $webhooks_data['events'][$eventname] = array(
          'name' => $eventname,
          'enabled' => ($webhook !== null),
          'callback' => ($webhook !== null) ? $webhook->getCallback() : null
        );
      }

      if($this->request->isSubmitted())
      {
        try {
          foreach(Webhooks::getEvents() as $eventname)
          {
            $webhooks_data['events'][$eventname]['enabled'] = ($this->request->post('enable_' . $eventname, 0) == 1);

            // is the webhook enabled
            if($webhooks_data['events'][$eventname]['enabled'])
            {
              // get callback
              $callback = $this->request->post('callback_' . $eventname, '');

              // validate data
              if(!filter_var($callback, FILTER_VALIDATE_URL)) throw new Exception('invalid callback for '. $eventname);

              // store valid callback
              else $webhooks_data['events'][$eventname]['callback'] = $callback;
            }
          }

          // loop validated data again
          foreach(Webhooks::getEvents() as $eventname)
          {
            // get the webhook
            $webhook = Webhooks::findByEventname($eventname);

            // we found a webhook
            if ($webhook != null)
            {
              if(isset($webhooks_data['events'][$eventname]['enabled']) && $webhooks_data['events'][$eventname]['enabled'])
              {
                $webhook->setCallback($webhooks_data['events'][$eventname]['callback']);
                $webhook->save();
              }

              // the webhook isn't active anymore, so delete it
              else $webhook->delete();
            }

            // new webhook
            elseif(isset($webhooks_data['events'][$eventname]['enabled']) && $webhooks_data['events'][$eventname]['enabled'])
            {
              $webhook = new Webhooks();
              $webhook->setEvent($eventname);
              $webhook->setCallback($webhooks_data['events'][$eventname]['callback']);
              $webhook->save();
            }
          }

          $this->response->ok();
         }
         catch (Exception $e)
         {
           die(JSON::encode(array(
           'ajax_error' => true,
           'ajax_message' => $e->getMessage()
          )));
         }
      }

      $this->smarty->assign(array(
        'webhooks_data' => $webhooks_data,
      ));
    } // index
  } // WebhooksAdminController