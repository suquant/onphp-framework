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
 * @method WCalendar create()
 * @method WCalendar setTplName()
 * @method WCalendar setViewer()
 * @method WCalendar setModel()
 */
class WCalendar extends WFormElement
{
	protected $tplName = 'calendar';
	protected $format = 'd.m.Y';

	/**
	 * @example: d.m.Y
	 * @param string $format
	 * @return WCalendar
	 */
	public function setFormat($format)
	{
		$this->format = $format;
		return $this;
	}

	protected function makeModel()
	{
		return parent::makeModel()->set('format', $this->format);
	}
}
