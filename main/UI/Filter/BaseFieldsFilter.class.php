<?php
/***************************************************************************
 *   Copyright (C) 2012 by Kutsurua Georgy Tamazievich                     *
 *   email: g.kutsurua@gmail.com, icq: 723737, jabber: soloweb@jabber.ru   *
 ***************************************************************************/


abstract class BaseFieldsFilter implements IfaceFieldsFilter
{
	protected $list = array();
	protected $fields = array();
	protected $applyed = null;

	/**
	 * @static
	 * @param array|null $list
	 * @return BaseFieldsFilter
	 */
	public static function create(array $list=null)
	{
		return new static($list);
	}

	public function __construct(array $list=null)
	{
		if($list)
			$this->setList($list);
	}

	/**
	 * @return bool
	 */
	public function isApplyed()
	{
		return ($this->applyed === true);
	}

	/**
	 * @param $value
	 * @return mixed
	 */
	public function apply($value)
	{
		$this->applyed = true;

		return $value;
	}

	/**
	 * Set fields
	 *
	 * @param array $fields
	 * @return AllowedFilter
	 */
	public function setFields(array $fields) {
		$this->fields = $fields;

		return $this;
	}

	/**
	 * @return array
	 */
	public function getFields()
	{
		return $this->fields;
	}


}
