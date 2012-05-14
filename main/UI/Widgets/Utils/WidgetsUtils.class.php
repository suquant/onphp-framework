<?php
/***************************************************************************
 *   Copyright (C) by Evgeny M. Stepanov                                   *
 *   from.stev@gmail.com                                                   *
 ***************************************************************************
 * $Id$ */



class WidgetsUtils
{
	//put your code here

	public static function makeWidgetByPrimitive(BasePrimitive $primitive)
	{
		$widget = null;
		$primitiveClassName = get_class($primitive);
		$widgetClassName = 'W'.$primitiveClassName;

		if(class_exists($widgetClassName))
			$widget = new $widgetClassName($primitive);
		else {
			$parents = class_parents($primitiveClassName);

			foreach($parents as $parent)
			{
				$className = 'W'.$parent;
				if(class_exists($className)) {
					$widget = new $className($primitive);
					break;
				}

			}
		}

		if(!$widget)
			throw new WrongArgumentException(
				'cannot find widget for "'.$primitiveClassName.'" primitve!'
			);

		return $widget;
	}

}
