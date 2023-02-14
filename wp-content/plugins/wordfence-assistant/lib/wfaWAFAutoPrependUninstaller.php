<?php
require_once(dirname(__FILE__) . '/wfaWebServerInfo.php');

class wfaWAFAutoPrependUninstaller {
	public function getHtaccessPath() {
		return get_home_path() . '.htaccess';
	}

	public function getUserIniPath() {
		$userIni = ini_get('user_ini.filename');
		if ($userIni) {
			return get_home_path() . $userIni;
		}
		return get_home_path() . 'php.ini'; //SiteGround and similar
	}

	public static function isPressable() {
		return (defined('IS_ATOMIC') && IS_ATOMIC) || (defined('IS_PRESSABLE') && IS_PRESSABLE);
	}

	public static function isWpEngine() {
		return array_key_exists('IS_WPE', $_SERVER) && $_SERVER['IS_WPE'];
	}

	public function getWAFBootstrapPath() {
		if (self::isPressable()) {
			return WP_CONTENT_DIR . '/wordfence-waf.php';
		}
		return ABSPATH . 'wordfence-waf.php';
	}
	
	public function bootstrapFileIsActive() {
		$includes = get_included_files();
		return array_search(realpath($this->getWAFBootstrapPath()), $includes) !== false; 
	}
	
	public function usesUserIni() {
		$userIni = ini_get('user_ini.filename');
		if (!$userIni) {
			return false;
		}
		
		$serverInfo = wfaWebServerInfo::createFromEnvironment();
		return ($serverInfo->isApache() && !$serverInfo->isApacheSuPHP() && ($serverInfo->isCGI() || $serverInfo->isFastCGI()));
	}

	private function initializeFilesystem() {
		global $wp_filesystem;

		$adminURL = admin_url('/');
		$allow_relaxed_file_ownership = true;
		$homePath = get_home_path();

		ob_start();
		if (false === ($credentials = request_filesystem_credentials($adminURL, '', false, $homePath,
				array('version', 'locale'), $allow_relaxed_file_ownership))
		) {
			ob_end_clean();
			return false;
		}

		if (!WP_Filesystem($credentials, $homePath, $allow_relaxed_file_ownership)) {
			// Failed to connect, Error and request again
			request_filesystem_credentials($adminURL, '', true, ABSPATH, array('version', 'locale'),
				$allow_relaxed_file_ownership);
			ob_end_clean();
			return false;
		}

		if ($wp_filesystem->errors->get_error_code()) {
			ob_end_clean();
			return false;
		}
		ob_end_clean();
	}

	public function uninstall($removeBootstrap = null) {
		/** @var WP_Filesystem_Base $wp_filesystem */
		global $wp_filesystem;

		$this->initializeFilesystem();

		$htaccessPath = $this->getHtaccessPath();
		$userIniPath = $this->getUserIniPath();

		if ($wp_filesystem->is_file($htaccessPath)) {
			$htaccessContent = $wp_filesystem->get_contents($htaccessPath);
			$regex = '/# Wordfence WAF.*?# END Wordfence WAF/is';
			if (preg_match($regex, $htaccessContent, $matches)) {
				$htaccessContent = preg_replace($regex, '', $htaccessContent);
				if (!$wp_filesystem->put_contents($htaccessPath, $htaccessContent)) {
					return false;
				}
			}
		}

		if ($wp_filesystem->is_file($userIniPath)) {
			$userIniContent = $wp_filesystem->get_contents($userIniPath);
			$regex = '/; Wordfence WAF.*?; END Wordfence WAF/is';
			if (preg_match($regex, $userIniContent, $matches)) {
				$userIniContent = preg_replace($regex, '', $userIniContent);
				if (!$wp_filesystem->put_contents($userIniPath, $userIniContent)) {
					return false;
				}
			}
		}

		if ($removeBootstrap === null) {
			$removeBootstrap = !$this->usesUserIni(); //Default to removing bootstrap file except when user.ini in use
		}

		if ($removeBootstrap)
			$this->removeBootstrap();
		
		return true;
	}

	public function removeBootstrap() {	
		global $wp_filesystem;
		$this->initializeFilesystem();
		$bootstrapPath = $this->getWAFBootstrapPath();
		if ($wp_filesystem->is_file($bootstrapPath)) {
			$wp_filesystem->delete($bootstrapPath);
			return true;
		}
		return false;
	}
}