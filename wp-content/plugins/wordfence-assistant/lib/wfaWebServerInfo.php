<?php
class wfaWebServerInfo {
	
	const APACHE = 1;
	const NGINX = 2;
	const LITESPEED = 4;
	const IIS = 8;
	
	private $handler;
	private $software;
	private $softwareName;
	
	/**
	 *
	 */
	public static function createFromEnvironment() {
		$serverInfo = new self;
		if (stripos($_SERVER['SERVER_SOFTWARE'], 'apache') !== false) {
			$serverInfo->setSoftware(self::APACHE);
			$serverInfo->setSoftwareName('apache');
		}
		if (stripos($_SERVER['SERVER_SOFTWARE'], 'litespeed') !== false) {
			$serverInfo->setSoftware(self::LITESPEED);
			$serverInfo->setSoftwareName('litespeed');
		}
		if (strpos($_SERVER['SERVER_SOFTWARE'], 'nginx') !== false) {
			$serverInfo->setSoftware(self::NGINX);
			$serverInfo->setSoftwareName('nginx');
		}
		if (strpos($_SERVER['SERVER_SOFTWARE'], 'Microsoft-IIS') !== false || strpos($_SERVER['SERVER_SOFTWARE'], 'ExpressionDevServer') !== false) {
			$serverInfo->setSoftware(self::IIS);
			$serverInfo->setSoftwareName('iis');
		}
		
		$serverInfo->setHandler(php_sapi_name());
		
		return $serverInfo;
	}
	
	/**
	 * @return bool
	 */
	public function isApache() {
		return $this->getSoftware() === self::APACHE;
	}
	
	/**
	 * @return bool
	 */
	public function isNGINX() {
		return $this->getSoftware() === self::NGINX;
	}
	
	/**
	 * @return bool
	 */
	public function isLiteSpeed() {
		return $this->getSoftware() === self::LITESPEED;
	}
	
	/**
	 * @return bool
	 */
	public function isIIS() {
		return $this->getSoftware() === self::IIS;
	}
	
	/**
	 * @return bool
	 */
	public function isApacheModPHP() {
		return $this->isApache() && function_exists('apache_get_modules');
	}
	
	/**
	 * Not sure if this can be implemented at the PHP level.
	 * @return bool
	 */
	public function isApacheSuPHP() {
		return $this->isApache() && $this->isCGI() &&
			function_exists('posix_getuid') &&
			getmyuid() === posix_getuid();
	}
	
	/**
	 * @return bool
	 */
	public function isCGI() {
		return !$this->isFastCGI() && stripos($this->getHandler(), 'cgi') !== false;
	}
	
	/**
	 * @return bool
	 */
	public function isFastCGI() {
		return stripos($this->getHandler(), 'fastcgi') !== false || stripos($this->getHandler(), 'fpm-fcgi') !== false;
	}
	
	/**
	 * @return mixed
	 */
	public function getHandler() {
		return $this->handler;
	}
	
	/**
	 * @param mixed $handler
	 */
	public function setHandler($handler) {
		$this->handler = $handler;
	}
	
	/**
	 * @return mixed
	 */
	public function getSoftware() {
		return $this->software;
	}
	
	/**
	 * @param mixed $software
	 */
	public function setSoftware($software) {
		$this->software = $software;
	}
	
	/**
	 * @return mixed
	 */
	public function getSoftwareName() {
		return $this->softwareName;
	}
	
	/**
	 * @param mixed $softwareName
	 */
	public function setSoftwareName($softwareName) {
		$this->softwareName = $softwareName;
	}
}