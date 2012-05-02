<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/



abstract class WidgetTable extends BaseWidget
{
	protected $headerFields = array();
	protected $objects = array();
	protected $filter = null;
	protected $tplName = 'table';
	protected $tplPrefix = 'table';

	/**
	 * @return WidgetTable
	 */
	public function setObjects(array $objects)
	{
		$this->objects = $objects;

		return $this;
	}

	/**
	 * @return Model
	 */
	protected function makeModel()
	{
		Assert::isNotEmpty($this->objects, "array 'objects' is empty");

		$object = current($this->objects);

		Assert::isTrue($object instanceof Prototyped, 'Object is not Proto contents.');

		if (empty($this->headerFields)) {
			if ($object instanceof Prototyped) {
				$fields = $object->proto()->getPropertyList();
			}
		} else {
			$fields = $this->headerFields;
		}

		Assert::isNotEmpty($fields, "array 'fields of header' is empty. Set it or can use Prototyped 'objects'");

		if ($this->filter instanceof IfaceFieldsFilter) {
			$fields	= $this->filter->setAllFields($fields)->
				getList();
		}

		$name = get_class($object);

		return parent::makeModel()->
			set('_objectName', $name)->
			set('_fields', $fields)->
			set('_filter', $this->filter)->
			set('_objects', $this->objects);
	}

	/**
	 *	Ð¼Ð¾Ð¶Ð½Ð¾ ÑÐºÐ°Ð·Ð°ÑÑ ÐºÐ°ÐºÐ¸Ðµ Ð¿Ð¾Ð»Ñ Ð²ÑÐ²Ð¾Ð´Ð¸ÑÑ Ð¸Ð»Ð¸ Ð½Ðµ Ð²ÑÐ²Ð¾Ð´Ð¸ÑÑ.
	 *
	 * @param IFieldsFilter $filter
	 * @return WidgetTable
	 */
	public function setFieldsFilter(IfaceFieldsFilter $filter)
	{
		$this->filter = $filter;
		return $this;
	}
}

