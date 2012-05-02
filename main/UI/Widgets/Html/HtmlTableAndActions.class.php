<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/
/* $Id: HtmlTableAndActions.class.php 380 2011-05-16 14:44:34Z stev $ */


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

