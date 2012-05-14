<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/


	class WCalendar extends WFormElement
	{
		protected $tplName = 'calendar';
		protected $format = 'd.m.Y';

		/**
		 * @static
		 * @param null $name
		 * @return WCalendar
		 */
		public static function create($name=null)
		{
			return new static($name);
		}

		public function __construct($name=null)
		{
			parent::__construct($name);

			// Default value
			$this->setFormat($this->format);
		}

		/**
		 * @example: d.m.Y
		 * @param string $format
		 * @return WCalendar
		 */
		public function setFormat($format)
		{
			$this->model->set('format', $format);

			return $this;
		}

		/**
		 * @return Model
		 */
		protected function makeModel()
		{
			$value = $this->model->get('value');
			$format = $this->model->get('format');

			if($value instanceof Date)
				$this->setValue(
					$value->toFormatString($format)
				);
			elseif(is_scalar($value))
				$this->setValue(
					Timestamp::create($value)->toFormatString($format)
				);


			return parent::makeModel();
		}

	}
