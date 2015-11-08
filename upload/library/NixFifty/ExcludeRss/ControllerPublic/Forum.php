<?php

/**
 * @author      Aakif N. <webmaster@nixfifty.com>
 * @copyright   Ⓒ 2015 pixelexit.com. All rights reserved.
 * @link        https://pixelexit.com
 * @package     NixFifty_ExcludeRss
 */

class NixFifty_ExcludeRss_ControllerPublic_Forum extends XFCP_NixFifty_ExcludeRss_ControllerPublic_Forum
{
    public function getGlobalForumRss()
    {
		$response = parent::getGlobalForumRss();

		if ($response instanceof XenForo_ControllerResponse_View)
		{
			foreach ($response->params['threads'] as $threadId => $thread)
			{
				if ($thread['exclude_rss'])
				{
					unset ($response->params['threads'][$threadId]);
				}
			}
		}

		return $response;
    }
}