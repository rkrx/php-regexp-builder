<?php
namespace Kir\RegExp\Builder\RegExpBuilder\Builder;

use Kir\RegExp\Builder\RegExpBuilder\Builder;

class Multipliers {
	/**
	 * @var Stream
	 */
	private $stream = null;

	/**
	 * @var \Kir\RegExp\Builder\RegExpBuilder\Builder
	 */
	private $builder = null;

	/**
	 * @param \Kir\RegExp\Builder\RegExpBuilder\Builder $builder
	 * @param Stream $stream
	 */
	public function __construct(Builder $builder, Stream $stream) {
		$this->builder = $builder;
		$this->stream = $stream;
	}

	/**
	 * @return \Kir\RegExp\Builder\RegExpBuilder\Builder
	 */
	public function once() {
		return $this->builder;
	}

	/**
	 * @return \Kir\RegExp\Builder\RegExpBuilder\Builder
	 */
	public function zeroOrOnce() {
		return $this->write('?');
	}

	/**
	 * @return \Kir\RegExp\Builder\RegExpBuilder\Builder
	 */
	public function onceOrMore() {
		return $this->write('+?');
	}

	/**
	 * @return \Kir\RegExp\Builder\RegExpBuilder\Builder
	 */
	public function zeroOrMore() {
		return $this->write('*?');
	}

	/**
	 * @params int $count
	 */
	public function exactly($length) {
		return $this->write('{'."{$length}".'}');
	}

	/**
	 * @params int $min
	 * @params int $max
	 */
	public function limit($min = null, $max = null) {
		return $this->write('{'."{$min},{$max}".'}');
	}

	/**
	 * @param string $content
	 * @return \Kir\RegExp\Builder\RegExpBuilder\Builder
	 */
	private function write($content) {
		$this->stream->add($content);
		return $this->builder;
	}
}