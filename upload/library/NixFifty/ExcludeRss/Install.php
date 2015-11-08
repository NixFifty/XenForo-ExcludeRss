<?php

/**
 * @author      Aakif N. <webmaster@nixfifty.com>
 * @copyright   Ⓒ 2015 pixelexit.com. All rights reserved.
 * @link        https://pixelexit.com
 * @package     NixFifty_ExcludeRss
 */

class NixFifty_ExcludeRss_Install
{
	protected static $_db = null;
	protected static $_version = 0;

	protected static $_contentTypes = array();
	protected static $_contentTypeTables = array();

	public static function install($installedAddon)
	{
		if (!self::_canBeInstalled($error))
		{
			throw new XenForo_Exception($error, true);
		}

		if (!$installedAddon)
		{
			self::stepTables();
		}
		else
		{
			// upgrades
			$version = self::$_version = $installedAddon['version_id'];
		}

		self::stepCoreAlters();
		self::stepData();
		self::stepDeleteObsolete();
	}

	public static function uninstall()
	{
		self::stepDeleteTables();
		self::stepDeleteCoreAlters();
		self::stepDeleteData();
		self::stepDeletePermissions();
	}

	public static function stepTables()
	{
		foreach (self::_getTables() AS $tableSql)
		{
			self::_runQuery($tableSql);
		}
	}

	public static function stepDeleteTables()
	{
		foreach (self::_getTables() AS $tableName => $tableSql)
		{
			self::_runQuery("DROP TABLE IF EXISTS $tableName");
		}
	}

	public static function stepDeleteCoreAlters()
	{
		foreach (self::_getCoreAlters() AS $tableName => $columnSql)
		{
			foreach ($columnSql AS $columnName => $sql)
			{
				self::_runQuery("ALTER TABLE $tableName DROP $columnName");
			}
		}
	}

	public static function stepData()
	{
		foreach (self::_getData() AS $dataSql)
		{
			self::_runQuery($dataSql);
		}
	}

	public static function stepDeleteData()
	{
		$db = self::_getDb();

		$contentTypes = $db->quote(self::$_contentTypes);
		foreach (self::$_contentTypeTables AS $table)
		{
			$db->delete($table, 'content_type IN (' . $contentTypes . ')');
		}
	}

	public static function stepDeletePermissions()
	{
		$db = self::_getDb();
	}

	public static function stepCoreAlters()
	{
		foreach (self::_getCoreAlters() AS $tableName)
		{
			foreach ($tableName AS $alterSql)
			{
				self::_runQuery($alterSql);
			}
		}
	}

	public static function stepDeleteObsolete()
	{
		list ($files, $directories) = self::_getFilesToDelete();

		foreach ($files AS $file)
		{
			try
			{
				unlink($file);
			}
			catch (Exception $e) {}
		}

		foreach ($directories AS $dir)
		{
			try
			{
				rmdir($dir);
			}
			catch (Exception $e) {}
		}
	}

	protected static function _getTables()
	{
		$tables = array();

		return $tables;
	}

	protected static function _getData()
	{
		$data = array();

		return $data;
	}

	protected static function _getCoreAlters()
	{
		$alters = array();

		$alters['xf_forum']['exclude_rss'] = "
			ALTER TABLE `xf_forum`
				ADD COLUMN `exclude_rss` TINYINT(3) UNSIGNED NOT NULL DEFAULT '0' AFTER `allowed_watch_notifications`
		";

		return $alters;
	}

	protected static function _getFilesToDelete()
	{
		$files = array();

		$directories = array();

		return array($files, $directories);
	}

	protected static function _runQuery($sql)
	{
		$db = self::_getDb();

		try
		{
			$db->query($sql);
		}
		catch (Zend_Db_Exception $e) {}
	}

	protected static function _canBeInstalled(&$error)
	{
		if (XenForo_Application::$versionId < 1030070)
		{
			$error = 'This add-on requires XenForo 1.3.0 or higher.';
			return false;
		}

		return true;
	}

	/**
	 * @return Zend_Db_Adapter_Abstract
	 */
	protected static function _getDb()
	{
		if (!self::$_db)
		{
			self::$_db = XenForo_Application::getDb();
		}

		return self::$_db;
	}
}