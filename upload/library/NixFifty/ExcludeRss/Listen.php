<?php

/**
 * @author      Aakif N. <webmaster@nixfifty.com>
 * @copyright   Ⓒ 2015 pixelexit.com. All rights reserved.
 * @link        https://pixelexit.com
 * @package     NixFifty_ExcludeRss
 */

class NixFifty_ExcludeRss_Listen
{
	public static function loadForumController($class, array &$extend)
	{
		$extend[] = 'NixFifty_ExcludeRss_ControllerPublic_Forum';
	}

	public static function loadForumControllerAdmin($class, array &$extend)
	{
		$extend[] = 'NixFifty_ExcludeRss_ControllerAdmin_Forum';
	}

	public static function loadForumDataWriter($class, array &$extend)
	{
		$extend[] = 'NixFifty_ExcludeRss_DataWriter_Forum';
	}
}