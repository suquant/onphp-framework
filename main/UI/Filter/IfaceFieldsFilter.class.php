<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/


interface IfaceFieldsFilter
{
	/**
	 * @abstract
	 * @param array $fields
	 * @return IfaceFieldsFilter
	 */
	public function setFields(array $fields);

	/**
	 * @abstract
	 * @param array $list
	 * @return IfaceFieldsFilter
	 */
	public function setList(array $list);

	/**
	 * @abstract
	 * @return array
	 */
	public function getList();
}
