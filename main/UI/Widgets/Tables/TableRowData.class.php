<?php
/***************************************************************************
 *   Copyright (C) 2012 by Kutsurua Georgy Tamazievich                     *
 *   email: g.kutsurua@gmail.com, icq: 723737, jabber: soloweb@jabber.ru   *
 ***************************************************************************/



	class TableRowData implements Stringable, Identifiable, IArrayable
	{

		/**
		 * @var TableRowDataType
		 */
		protected $type			= null;

		/**
		 * @var null|misc
		 */
		protected $value		= null;

		/**
		 * @var null
		 */
		protected $id			= null;


		/**
		 * @static
		 * @param TableRowDataType $type
		 * @param $value
		 * @return TableRowData
		 */
		public static  function create(TableRowDataType $type, $value)
		{
			return new static($type, $value);
		}

		public function __construct(TableRowDataType $type, $value)
		{
			$this->type = $type;
			$this->value = $value;
		}

		/**
		 * @return misc|null
		 */
		public function getValue()
		{
			return $this->value;
		}

		/**
		 * @param $value
		 * @return TableRowData
		 */
		public function setValue($value)
		{
			$this->value = $value;

			return $this;
		}


		/**
		 * @param TableRowDataType $type
		 * @return TableRowData
		 */
		public function setType(TableRowDataType $type)
		{
			$this->type = $type;

			return $this;
		}

		/**
		 * @return null|TableRowDataType
		 */
		public function getType()
		{
			return $this->type;
		}

		/**
		 * @return string
		 */
		public function toString()
		{
			return $this->getType()->toCastedString($this->getValue());
		}

		/**
		 * @return null
		 */
		public function getId()
		{
			return $this->id;
		}

		/**
		 * @param $id
		 * @return TableRowData
		 */
		public function setId($id)
		{
			$this->id = $id;

			return $this;
		}

		/**
		 * @return array
		 */
		public function toArray()
		{
			return array(
				'id' => $this->getId(),
				'type' => $this->getType()->getId(),
				'values' => array(
					'raw' => $this->getValue(),
					'string' => $this->toString(),
				),
			);
		}
	}
