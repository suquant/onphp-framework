<?php
/***************************************************************************
 *   Copyright (C) 2012 by Kutsurua Georgy Tamazievich                  *
 *   email: g.kutsurua@gmail.com, icq: 723737, jabber: soloweb@jabber.ru   *
 ***************************************************************************/

	class TableRowDataType extends Enum
	{
		const TYPE_STRING			= 'string';

		const TYPE_NUMBER			= 'number';

		const TYPE_MISC			 	= 'misc';

		protected static $names = array(
			self::TYPE_MISC => 'misc',
			self::TYPE_NUMBER => 'number',
			self::TYPE_STRING => 'string',
		);

		/**
		 * @param $value
		 * @return string
		 */
		public function toCastedString($value)
		{
			switch($this->id)
			{
				case static::TYPE_STRING:
				case static::TYPE_MISC:
					return GUIUtils::objectToString($value);
					break;

				case static::TYPE_NUMBER:
					Assert::isTrue(
						is_numeric($value)
					);

					return $value;
					break;
			}

			Assert::isUnreachable();
		}

		/**
		 * @static
		 * @return TableRowDataType
		 */
		public static function typeString()
		{
			return new static(static::TYPE_STRING);
		}

		/**
		 * @static
		 * @return TableRowDataType
		 */
		public static function typeNumber()
		{
			return new static(static::TYPE_NUMBER);
		}

		/**
		 * @static
		 * @return TableRowDataType
		 */
		public static function typeMisc()
		{
			return new static(static::TYPE_MISC);
		}
	}