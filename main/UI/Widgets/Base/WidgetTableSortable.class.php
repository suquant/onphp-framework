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
 * Description of tableSortable
 */
abstract class WidgetTableSortable extends WidgetTableAction
{
	protected $tplName = 'tableSortable';
	protected $sortField;
	protected $sortMode;

	/**
	 *
	 * @param type $field
	 * @param type $mode
	 * @return WidgetTableSortable 
	 */
	public function setSortedFieldName($field, $mode)
	{
		$this->sortField = $field;
		$this->sortMode = $mode;

		return $this;
	}

	protected function makeModel()
	{
		return parent::makeModel()->
			set('_sortField', $this->sortField)->
			set('_sortMode', $this->sortMode);
	}
}

