<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                  *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************
 * $Id: IFieldsFilter.class.php 133 2010-09-16 12:25:06Z stev $ */


interface IfaceFieldsFilter
{
	public function setFields(array $fields);
	public function getList();
}

?>
