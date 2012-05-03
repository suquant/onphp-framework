<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/

/**
 * @package UI\Widget
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