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
 * @package UI\Widget
 * @method WEditForm create()
 * @method WEditForm setSubmitUrl()
 * @method WEditForm setTplName()
 * @method WEditForm setViewer()
 * @method WEditForm setModel()
 */
class WEditForm extends WFormBegin
{
	protected $tplName = 'editForm';
	protected $map;
	protected $filter;
	protected $body;

	/**
	 * @return WEditForm
	 */
	public function setFieldsMap(array $map)
	{
		$this->map = $map;
		return $this;
	}

	/**
	 * @param IFieldsFilter $filter
	 * @return WidgetTable
	 */
	public function setFieldsFilter(IfaceFieldsFilter $filter)
	{
		$this->filter = $filter;
		return $this;
	}

	/**
	 * @return Model
	 */
	protected function makeModel()
	{
		return parent::makeModel()->
			set('_url', $this->url)->
			set('_fieldMap', $this->map)->
			set('_filter', $this->filter)->
			set('_form', $this->form);
	}

	/**
	 * @return WEditForm
	 */
	public function setForm(Form $form)
	{
		$this->form = $form;

		return $this;
	}
}

