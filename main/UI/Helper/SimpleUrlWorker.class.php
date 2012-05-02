<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/
/* $Id: SimpleUrlWorker.class.php 236 2010-10-18 08:30:11Z stev $ */


class SimpleUrlWorker extends Singleton implements IUrlWorker
{
	protected $params;
	protected $host = PATH_WEB;

	public function setParams(array $params)
	{
		$this->params = $params;
		return $this;
	}

	/**
	 *
	 * @param <type> $host
	 * @return <type>
	 */
	public function setHost($host)
	{
		$this->host = (string)$host;
		return $this;
	}

	public function __toString()
	{
		return $this->makeUrlString();
   	}

	public function makeUrlString()
	{
		$array = array();

		foreach ($this->params as $key => $value) {
			if ($value)
				$array[] = $key.'='.$value;
		}

		if ($array)
			return $this->host.'?'.join('&',$array);

		return $this->host;
	}
}

?>
