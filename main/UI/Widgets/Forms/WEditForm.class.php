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
 */
class WEditForm extends WFormBegin
{
	protected $tplName = 'editForm';
	protected $fields		= array();

	/**
	 * @var IfaceFieldsFilter
	 */
	protected $filter;

	public function __construct(Form $form, $name = null)
	{
		parent::__construct($name);

		$this->setForm($form);
	}

	/**
	 * @param array $map
	 * 	array( 'primitiveName' => function($prm) {...} )
	 *
	 * @return WEditForm
	 */
	public function setFields(array $fields)
	{
		$this->fields = $fields;
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
		$primitives = $this->model->get('form')->getPrimitiveList();

		if($this->filter && $this->fields) {
			$primitives =
				$this->filter->setFields(
					array_keys( $this->fields )
				)->apply($primitives);
		}


		$fields = array();

		foreach($primitives as $name => $prm)
		{
			$callback = $this->fields[$name];

			if($callback instanceof Closure) {
				$w = $callback->__invoke($prm);
			} else {
				$w = WMaker::make($prm);
			}

			$fields[]=$w;

			unset($w);
		}

		$this->model->set('fields', $fields);

		return parent::makeModel();
	}

	/**
	 * @return WEditForm
	 */
	public function setForm(Form $form)
	{
		$this->model->set('form', $form);

		return $this;
	}
}

