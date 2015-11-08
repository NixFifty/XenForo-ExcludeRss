<?php

/**
 * @author      Aakif N. <webmaster@nixfifty.com>
 * @copyright   Ⓒ 2015 pixelexit.com. All rights reserved.
 * @link        https://pixelexit.com
 * @package     NixFifty_ExcludeRss
 */

class NixFifty_ExcludeRss_DataWriter_Forum extends XFCP_NixFifty_ExcludeRss_DataWriter_Forum
{
	protected function _getFields()
	{
		$fields = parent::_getFields();
		$fields['xf_forum']['exclude_rss'] = array('type' => self::TYPE_BOOLEAN, 'default' => 0);
		return $fields;
	}

	protected function _preSave()
	{
		$session = false;
		if (XenForo_Application::isRegistered('session'))
		{
			/** @var $session XenForo_Session */
			$session = XenForo_Application::get('session');
		}

		if ($session && $session->get('excludeRss'))
		{
			$this->bulkSet($session->get('excludeRss'));

			$session->remove('excludeRss');
		}

		return parent::_preSave();
	}
}