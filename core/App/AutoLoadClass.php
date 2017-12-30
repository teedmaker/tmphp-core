<?php

class AutoLoadClass
{
	protected static $path = '';
	protected static $class = '';

	public static function register(string $class) {
		$trace = debug_backtrace();
		$file = $trace[2]['args'][0];
		$file = str_replace('\\', '/', $file);

		$core = preg_quote(CORE, '/');
		$path = preg_match("/^{$core}/", $file)? CORE: BASE;

		$class = str_replace('TMPHP\\', '', $class);
		self::$class  = $class;
		$class .= '.php';
		self::$path  .= $path . $class;

		self::getFileClass();
	}

	protected static function getFileClass() {
		if(!file_exists(self::$path)) {
			ob_clean();
			exit('Classe `'.self::$class.'` não existe.');
		}
		require_once self::$path;
	}
}
