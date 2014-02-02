<?php
namespace Kir\RegExp\Builder\RegExpBuilder;

class Builder {
	/**
	 * @var Builder\Modifiers
	 */
	private $modifiers = null;

	/**
	 * @var Builder\Multipliers
	 */
	private $multipliers = null;

	/**
	 * @var Builder\Stream
	 */
	private $stream = null;

	/**
	 * @param Builder\Modifiers $modifiers
	 * @param Builder\Stream $stream
	 */
	public function __construct(Builder\Modifiers $modifiers, Builder\Stream $stream) {
		$this->modifiers = $modifiers;
		$this->multipliers = new Builder\Multipliers($this, $stream);
		$this->stream = $stream;
	}

	/**
	 * @return $this
	 */
	public function lineStart() {
		$this->add(new Objects\LineStart());
		return $this;
	}

	/**
	 * @return $this
	 */
	public function lineEnd() {
		$this->add(new Objects\LineEnd());
		return $this;
	}

	/**
	 * @param string $string
	 * @return Builder\Multipliers
	 */
	public function expect($string) {
		$expression = new Objects\MixedExpression($string);
		$group = new Objects\NonCapturingGroup($expression);
		$this->add($group);
		return $this->multipliers;
	}

	/**
	 * @throws Builder\InvalidCharacterException
	 * @return Builder\Multipliers
	 */
	public function expectAny() {
		$expression = new SpecialCharacter\Any();
		$group = new Objects\NonCapturingGroup($expression);
		$this->add($group);
		return $this->multipliers;
	}

	/**
	 * @param array $characters
	 * @throws Builder\InvalidCharacterException
	 * @return Builder\Multipliers
	 */
	public function expectAnyOf($characters) {
		$characters = new Objects\CharacterList($characters);
		$this->add($characters);
		return $this->multipliers;
	}

	/**
	 * @param array|string $characters
	 * @throws Builder\InvalidCharacterException
	 * @return Builder\Multipliers
	 */
	public function expectNoneOf($characters) {
		$characters = new Objects\NegativeCharacterList($characters);
		$this->add($characters);
		return $this->multipliers;
	}

	/**
	 * @param array $expressions
	 * @return Builder\Multipliers
	 */
	public function expectOneOf(array $expressions) {
		$expression = new Objects\OrExpression($expressions);
		$group = new Objects\NonCapturingGroup($expression);
		$this->add($group);
		return $this->multipliers;
	}

	/**
	 * @param string $string
	 * @param string|null $alias
	 * @return Builder\Multipliers
	 */
	public function group($string, $alias = null) {
		$expression = new Objects\MixedExpression($string);
		$this->add(new Objects\Group($expression, $alias));
		return $this->multipliers;
	}

	/**
	 * @param string $string
	 * @return $this
	 */
	public function assertPrecededBy($string) {
		$expression = new Objects\MixedExpression($string);
		$this->add(new Objects\PositiveLookBehind($expression));
		return $this;
	}

	/**
	 * @param string $string
	 * @return $this
	 */
	public function assertNotPrecededBy($string) {
		$expression = new Objects\MixedExpression($string);
		$this->add(new Objects\NegativeLookBehind($expression));
		return $this;
	}

	/**
	 * @param string $string
	 * @return $this
	 */
	public function assertFollowedBy($string) {
		$expression = new Objects\MixedExpression($string);
		$this->add(new Objects\PositiveLookAhead($expression));
		return $this;
	}

	/**
	 * @param string $string
	 * @return $this
	 */
	public function assertNotFollowedBy($string) {
		$expression = new Objects\MixedExpression($string);
		$this->add(new Objects\NegativeLookAhead($expression));
		return $this;
	}

	/**
	 * @param string $expression
	 * @return $this
	 */
	public function caseSensitive($expression) {
		$expression = new Objects\MixedExpression($expression);
		$this->add(new Objects\CaseSensitive($expression));
		return $this;
	}

	/**
	 * @param string $expression
	 * @return $this
	 */
	public function caseInsensitive($expression) {
		$expression = new Objects\MixedExpression($expression);
		$this->add(new Objects\CaseInsensitive($expression));
		return $this;
	}

	/**
	 * @return Builder\CompiledExpression
	 */
	public function compile() {
		$pattern = $this->__toString();
		return new Builder\CompiledExpression($pattern);
	}

	/**
	 * @return Builder\Stream
	 */
	public function getStream() {
		return $this->stream;
	}

	/**
	 * @return string
	 */
	public function getPlainExpression() {
		return (string) $this->getStream();
	}

	/**
	 * @return string
	 */
	public function __toString() {
		$expression = $this->getPlainExpression();
		$modifiers = (string) $this->modifiers;
		return sprintf('/%s/%s', $expression, $modifiers);
	}

	/**
	 * @param string $token
	 * @return $this
	 */
	private function add($token) {
		$this->stream->add((string) $token);
		return $this;
	}
}
