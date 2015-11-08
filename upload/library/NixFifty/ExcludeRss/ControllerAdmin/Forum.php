<?php

/**
 * @author      Aakif N. <webmaster@nixfifty.com>
 * @copyright   Ⓒ 2015 pixelexit.com. All rights reserved.
 * @link        https://pixelexit.com
 * @package     NixFifty_ExcludeRss
 */

class NixFifty_ExcludeRss_ControllerAdmin_Forum extends XFCP_NixFifty_ExcludeRss_ControllerAdmin_Forum
{
	public function actionSave()
	{
		$session = false;
		if (XenForo_Application::isRegistered('session'))
		{
			/** @var $session XenForo_Session */
			$session = XenForo_Application::get('session');
		}

		$inputData = $this->_input->filter(array(
				'exclude_rss' => XenForo_Input::UINT
		));
		$session->set('excludeRss', $inputData);

		return parent::actionSave();
	}
}