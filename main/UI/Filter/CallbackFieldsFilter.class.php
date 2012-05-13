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
	 * Callback filter
	 */
	class CallbackFieldsFilter extends BaseFieldsFilter
	{
		/**
		 * @var array
		 */
		protected $closures		 		= array();

		/**
		 * @param array $closures
		 * @return CallbackFilter
		 */
		public function setCallbacks(array $closures)
		{
			$this->closures = $closures;

			return $this;
		}

		/**
		 * @param $value
		 * @return mixed
		 */
		public function apply($value)
		{
			foreach($value as $key => &$val)
			{
				if(isset($this->closures[$key]))
				{
					$closure = $this->closures[$key];
					Assert::isTrue(
						($closure instanceof Closure),
						'field value must be key "'.$key.'" instance of Closure, gived "'.gettype($closure).'"'
					);

					$val = $closure->__invoke($val);
				}
			}

			return parent::apply($value);
		}
	}

?>
