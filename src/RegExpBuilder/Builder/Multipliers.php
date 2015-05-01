<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Builder;

use Kir\RegExp\Builder\RegExpBuilder\Builder;

class Multipliers {
	/** @var Stream */
	private $stream = null;
	/** @var Builder */
	private $builder = null;

	/**
	 * @param Builder $builder
	 * @param Stream $stream
	 */
	public function __construct(Builder $builder, Stream $stream) {
		$this->builder = $builder;
		$this->stream = $stream;
	}

	/**
	 * @return Builder
	 */
	public function once() {
		return $this->builder;
	}

	/**
	 * @return Builder
	 */
	public function zeroOrOnce() {
		return $this->write('?');
	}

	/**
	 * @return Builder
	 */
	public function onceOrMore() {
		return $this->write('+?');
	}

	/**
	 * @return Builder
	 */
	public function zeroOrMore() {
		return $this->write('*?');
	}

	/**
	 * @params int $count
	 * @param int $length
	 * @return Builder
	 */
	public function exactly($length) {
		return $this->write('{'."{$length}".'}');
	}

	/**
	 * @param int $min
	 * @param int $max
	 * @return Builder
	 */
	public function limit($min = null, $max = null) {
		return $this->write('{'."{$min},{$max}".'}');
	}

	/**
	 * @param string $content
	 * @return Builder
	 */
	private function write($content) {
		$this->stream->add($content);
		return $this->builder;
	}
}
