<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Expression;

use \Closure;

trait CacheAware {
	/**
	 * @var mixed
	 */
	private $cache = null;

	/**
	 * @var bool
	 */
	private $cached = false;

	/**
	 * @param Closure $func
	 * @return mixed
	 */
	protected function cache(Closure $func) {
		if(!$this->cached) {
			$this->cache = (string) call_user_func($func);
			$this->cached = true;
		}
		return $this->cache;
	}
} 