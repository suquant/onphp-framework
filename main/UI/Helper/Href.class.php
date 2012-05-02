<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************
 * $Id: Href.class.php 371 2011-03-16 18:04:41Z stev $ */


/**
 * @example:
 *
 * <a href="<?=Href::create('area')?>">Link name</a>
 *
 * @package Helpers
 *
 */

class Href
{
	protected $params = array();
	/**
	 * @var IUrlWorker
	 */
	protected $worker = null;

	/**
	 * @param string $area
	 * @param string $action
	 * @return Href
	 */
	static public function create($area=null, $action=null, $params = array())
	{
		return new self($area, $action, $params);
	}

	public function __construct($area = null, $action = null, array $params = array())
	{
		if ((string)$area)
			$this->params['area'] = (string)$area;

		if ((string)$action)
			$this->params['action'] = (string)$action;

		if(!empty($params))
			$this->setParams($params);

		// TODO : Ð¿ÐµÑÐµÐ¾Ð¿ÑÐµÐ´ÐµÐ»Ð¸ÑÑ UrlWorkerPeer::me()->setMap(..)
		$this->worker = Singleton::getInstance('SimpleUrlWorker');
	}

	/**
	 *
	 * @param <type> $name
	 * @param <type> $value
	 * @return Href
	 */
	public function set($name, $value)
	{
		$this->params[(string)$name] = $value;
		return $this;
	}
	/**
	 * @param <type> $worker
	 * @return Href
	 */
	public function setWorker(IUrlWorker $worker)
	{
		$this->worker = $worker;
		return $this;
	}
	/**
	 * @param string $area
	 * @return Href
	 */
	public function setArea($area)
	{
		$this->params['area'] = (string)$area;
		return $this;
	}

	/**
	 * @param array $params
	 * @return Href
	 */
	public function setParams(array $params)
	{
		$this->params = array_merge($this->params, $params);
		return $this;
	}

	public function __toString()
	{
		return (string)$this->worker->setParams($this->params);
	}
}

?>
