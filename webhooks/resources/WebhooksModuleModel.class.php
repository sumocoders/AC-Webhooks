<?php

  // Include applicaiton specific model base
  require_once APPLICATION_PATH . '/resources/ActiveCollabModuleModel.class.php';

  /**
   * Webhooks module model definition
   *
   * @package activeCollab.modules.webhooks
   * @subpackage resources
   */
  class WebhooksModuleModel extends ActiveCollabModuleModel {

    /**
     * Construct webhooks module model definition
     *
     * @param WebhooksModule $parent
     */
    function __construct(WebhooksModule $parent) {
      parent::__construct($parent);

      $this->addModel(DB::createTable('webhooks')->addColumns(array(
        DBIdColumn::create(),
        DBStringColumn::create('event', 255, ''),
        DBTextColumn::create('callback'),
      )));
    } // __construct
  }