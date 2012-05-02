<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/
/* $Id: WidgetTableAction.class.php 380 2011-05-16 14:44:34Z stev $ */


abstract class WidgetTableAction extends WidgetTable
{
	protected $tplName = 'tableAndActions';
	protected $actions = array();

	/**
	 * array(
	 *	edit => Href::create();
	 *	save => Href::create();
	 * )
	 * @param array $array
	 */
	public function setActions(array $array)
	{
		$this->actions = $array;

		return $this;
	}

	/**
	 * @return Model
	 */
	protected function makeModel()
	{
		return parent::makeModel()->
			set('_actions', $this->actions);
	}
}

