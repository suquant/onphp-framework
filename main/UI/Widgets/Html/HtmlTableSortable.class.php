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
 * @method HtmlTableSortable setObjects()
 * @method HtmlTableSortable setFieldsFilter()
 * @method HtmlTableSortable setTplName()
 * @method HtmlTableSortable setViewer()
 * @method HtmlTableSortable setModel()
 * @method HtmlTableSortable setSortedFieldName($field, $mode)
 */
class HtmlTableSortable extends WidgetTableSortable
{
	/**
	 * @param type $name
	 * @return HtmlTableSortable
	 */
	public static function create($name = null)
	{
		return new self($name);
	}
}

