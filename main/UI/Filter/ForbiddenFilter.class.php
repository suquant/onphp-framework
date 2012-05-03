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
 * Forbidden only the specified items
 */
class ForbiddenFilter implements IfaceFieldsFilter
{
	protected $list = array();
	protected $complete = false;
	protected $forbidden = array();

	/**
	 * @param array $list
	 * @return ForbiddenFilter
	 */
	static function create()
	{
		return new self();
	}

	/**
	 * @param array $list
	 * @return ForbiddenFilter
	 */
	function setAllFields(array $list)
	{
		$this->complete = false;
		$this->list = $list;

		return $this;
	}

	/**
	 * @param array $list
	 * @return ForbiddenFilter
	 */
	function setFields(array $forbidden)
	{
		$this->forbidden = $forbidden;

		return $this;
	}

	protected function filtering()
	{
		foreach ($this->forbidden as $value) {
			unset($this->list[$value]);
		}
		$this->complete = true;
	}

	/**
	 * @return array
	 */
	function getList()
	{
		if (!$this->complete)
			$this->filtering();

		return $this->list;
	}
}

