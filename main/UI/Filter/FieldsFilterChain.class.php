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
		public function apply()
		{
			foreach($this->chain as $filter)
			{
				$this->list = $filter->setList($this->list)->setFields($this->fields)->getList();
			}

			return parent::apply();
		}
	}