<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *   from.stev@gmail.com                                                   *
 ***************************************************************************
 * $Id$ */


/**
 * @method WTernary create()
 * @method WTernary setTplName()
 * @method WTernary setViewer()
 * @method WTernary setModel()
 */
class WTernary extends WFormElement
{
	protected $tplName = 'ternary';
	protected $true = 1;
	protected $false = 0;

	/**
	 * @param type $value
	 * @return WTernary
	 */
	public function setTrueValue($value)
	{
		$this->true = $value;
		return $this;
	}

	/**
	 * @param type $value
	 * @return WTernary
	 */
	public function setFalseValue($value)
	{
		$this->false = $value;
		return $this;
	}

	/**
	 * @return Model
	 */
	protected function makeModel()
	{
		return parent::makeModel()->
			set('_trueValue', $this->true)->
			set('_falseValue', $this->false);
	}
}
