<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *   from.stev@gmail.com                                                   *
 ***************************************************************************
 * $Id$ */


/**
 * @method WMultiSelect create()
 * @method WMultiSelect setTplName()
 * @method WMultiSelect setViewer()
 * @method WMultiSelect setModel()
 */
class WSelect extends WFormElement
{
	protected $tplName = 'oneSelect';
	protected $items = array();
	protected $getter;
	protected $value;

	/**
	 * @param array $array
	 * @return WSelect
	 */
	public function setArray(array $array)
	{
		$this->items = $array;
		return $this;
	}

	/**
	 * @param type $getter
	 * @return WSelect
	 */
	public function setGetter($getter)
	{
		$this->getter = $getter;
		return $this;
	}

	/**
	 * @return Model
	 */
	protected function makeModel()
	{
		return parent::makeModel()->
			set('_arrayItems', $this->items)->
			set('_getter', $this->getter);
	}

}