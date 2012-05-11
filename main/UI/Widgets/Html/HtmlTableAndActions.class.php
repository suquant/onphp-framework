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
 * @method HtmlTableAndActions setObjects()
 * @method HtmlTableAndActions setFieldsFilter()
 * @method HtmlTableAndActions setTplName()
 * @method HtmlTableAndActions setViewer()
 * @method HtmlTableAndActions setModel()
 */
class HtmlTableAndActions extends WidgetTableAction
{
	/**
	 * @param type $name
	 * @return HtmlTableAndActions
	 */
	public static function create($name = null)
	{
		return new self($name);
	}
}

