<?php
/***************************************************************************
 *   Copyright (C) 2012 by Kutsurua Georgy Tamazievich                     *
 *   email: g.kutsurua@gmail.com, icq: 723737, jabber: soloweb@jabber.ru   *
 ***************************************************************************/


	class TableRow implements Stringable, IArrayable
	{
		protected $columns			= array();


		/**
		 * @static
		 * @param array $columns
		 * @return TableRow
		 */
		public static  function create(array $columns=array())
		{
			return new static($columns);
		}

		public function __construct($columns)
		{
			$this->setColumns($columns);
		}

		/**
		 * @param TableRowData $cell
		 * @return TableRow
		 */
		public function addColumn(TableRowData $data)
		{
			array_push($this->columns, $data);

			return $this;
		}

		/**
		 * @return array
		 */
		public function getColumns()
		{
			return $this->columns;
		}

		/**
		 * @param array $columns
		 * @return TableRow
		 */
		public function setColumns(array $columns = array())
		{
			foreach($columns as $column)
				$this->addColumn($column);

			return $this;
		}

		/**
		 * @return string
		 */
		public function toString()
		{
			return $this->getType()->toString($this->getValue());
		}

		/**
		 * @return array
		 */
		public function toArray()
		{
			return array(
				'columns' => array_map(
					function(TableRowData $data) {
						return $data->toArray();
					},
					$this->getColumns()
				)
			);
		}
	}