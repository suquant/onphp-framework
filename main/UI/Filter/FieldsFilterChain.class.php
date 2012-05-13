<?php
/***************************************************************************
 *   Copyright (C) 2012 by Kutsurua Georgy Tamazievich                     *
 *   email: g.kutsurua@gmail.com, icq: 723737, jabber: soloweb@jabber.ru   *
 ***************************************************************************/


	class FieldsFilterChain extends BaseFieldsFilter
	{
		protected $chain			= array();

		public function add(IfaceFieldsFilter $filter)
		{
			array_push($this->chain, $filter);

			return $this;
		}

		/**
		 * @return BaseFieldsFilter
		 */
		public function apply($value)
		{
			foreach($this->chain as $filter)
			{
				$value = $filter->setFields($this->fields)->apply($value);
			}

			return parent::apply($value);
		}
	}