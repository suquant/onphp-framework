<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/
/* $Id: AllowedFilter.class.php 365 2011-03-03 14:02:48Z andrew $ */



/**
 * ÑÐ°Ð·ÑÐµÑÐ¸ÑÑ ÑÐ¾Ð»ÑÐºÐ¾ ÑÐºÐ°Ð·Ð°Ð½Ð½ÑÐµ ÑÐ»ÐµÐ¼ÐµÐ½ÑÑ
 */
class AllowedFilter implements IfaceFieldsFilter
{
	protected $list = array();
	protected $allowed = array();

	/**
	 * @param array $list
	 * @return AllowedFilter
	 */
	static function create()
	{
		return new self();
	}

	/**
	 * @param array $list
	 * @return AllowedFilter
	 */
	function setAllFields(array $list)
	{
		$this->list = $list;

		return $this;
	}

	/**
	 * set allowed
	 *
	 * @param array $list
	 * @return AllowedFilter
	 */
	function setFields(array $list) {
		$this->allowed = $list;

		return $this;
	}

	/**
	 * @return array
	 */
	function getList()
	{
		$res = array();

		foreach($this->allowed as $name) {
			if (isset($this->list[$name])) {
				$res[$name] = $this->list[$name];
			}
		}
		return $res;
	}
}

?>
