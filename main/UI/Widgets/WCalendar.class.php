<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *   from.stev@gmail.com                                                   *
 ***************************************************************************
 * $Id$ */


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
	 * ÑÐ¾ÑÐ¼Ð°Ñ Ð²ÑÐ²Ð¾Ð´Ð°, Ð½Ð°Ð¿ÑÐ¸Ð¼ÐµÑ: d.m.Y
	 *
	 * @param type $format
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
