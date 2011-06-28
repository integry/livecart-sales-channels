<?php

/**
 * @author Integry Systems
 */

class ReferrerCookies extends ControllerPlugin
{
	public function process()
	{
		$request = $this->controller->getRequest();
		$ref = $request->get('ref');
		if ($ref)
		{
			setcookie("sales-channel-keyword", $ref, 0, '/');
		}
		if (array_key_exists('HTTP_REFERER', $_SERVER) && false === strpos($_SERVER['HTTP_REFERER'], $_SERVER['SERVER_NAME']))
		{
			setcookie("sales-channel-referer", $_SERVER['HTTP_REFERER'], 0, '/');
		}
	}
}
?>