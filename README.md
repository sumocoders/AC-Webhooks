# AC Webhooks module

The Webhooks module enables you to call an external page on an event-base.

## Install

* Upload the folder webhooks into the custom-folder on your AC-install.
* Log in as an administrator
* Open the administration page
* Click on "Module"
* Click "install" next to "Webhooks"

## Howto use

* Decide on which event you want to hook
* Create a page that will handle the call, each call will have two POST-variables:
	* event: the event that was called
	* data: the data that was passed through the listener, it is [serialized](http://php.net/serialize) as an PHP-array.
* Enter the url of the page next to the event and check the checkbox to enable it
* Done