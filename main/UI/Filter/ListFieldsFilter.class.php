<?php
/***************************************************************************
 *   Copyright (C) by Georgiy T. Kutsurua                                  *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/

	/**
	 * List filter
	 * Its need when list is array( array('field'=>value) ... )
	 * Execute filter each array element in the list
	 */
	class ListFieldsFilter extends BaseFieldsFilter
	{
		/**
		 * @var IfaceFieldsFilter
		 */
		protected $filter			= null;

		/**
		 * @param IfaceFieldsFilter $filter
		 * @return ListFilter
		 */
		public function setFilter(IfaceFieldsFilter $filter)
		{
			$this->filter = $filter;

			return $this;
		}

		/**
		 * @return BaseFieldsFilter
		 */
		public function apply()
		{
			Assert::isNotNull($this->filter, 'before you nedd set filter for array!');

			foreach($this->list as &$value)
			{
				Assert::isArray($value, 'value must be array, gived "'.gettype($value).'"!');

				$value = $this->filter->setList($value)->setFields($this->fields)->getList();
			}

			return parent::apply();
		}

	}