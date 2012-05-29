<?php

  /**
   * {$eventname} event handler
   *
   * @package activeCollab.modules.webhooks
   * @subpackage handlers
   */

  /**
   * Handle {$eventname} event
   */
  function webhooks_handle_callback_{$eventname}() {
  	$args = func_get_args();
  	Webhooks::handleEvent('{$eventname}', $args);
  }