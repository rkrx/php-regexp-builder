<?php
require dirname(__DIR__).'/vendor/autoload.php';

spl_autoload_register(function ($className) {
	$incl = function ($filename) {
		if(file_exists($filename)) {
			/** @noinspection PhpIncludeInspection */
			require $filename;
		}
	};

	$baseDir = rtrim(str_replace(DIRECTORY_SEPARATOR, '/', dirname(__DIR__)), '/');
	$normalizedClassName = ltrim(str_replace('\\', '/', $className), '/');
	$filename = "{$normalizedClassName}.php";
	$incl("{$baseDir}/src/{$filename}");
	$incl("{$baseDir}/tests/{$filename}");
});