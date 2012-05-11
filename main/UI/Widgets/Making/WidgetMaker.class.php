<?php

/**
 * If you need to disable default strategy
 * <code>
 *	// config ..php code,
 *	define('WIDGET_MAKER_DEF_OFF', true);
 * </code>
 *
 * @author stev
 */
class WidgetMaker
{
	static protected $defaultStrategy;
	static protected $map = array();

	static public function setDefaultStrategy(IfaceWidgetMakeStrategy $strategy)
	{
		static::$defaultStrategy = $strategy;
	}

	static public function setMap(array $map)
	{
		array_walk($map, function($val, $key) {
			if (!$val instanceof IfaceWidgetMakeStrategy) {
				throw new WrongArgumentException('Not implimentation IfaceWidgetMakeStrategy '.$key);
			}
		});

		array_merge(static::$map, $map);
	}

	static public function cleanMap()
	{
		static::$map = array();
	}

	/**
	 * 
	 * @param string $name
	 * @param bool $def
	 * @return IfaceWidgetMakeStrategy
	 * @throws WrongArgumentException
	 */
	static public function get($name = null, $def = true)
	{
		if (isset(static::$map[(string)$name])) {
			$strategy = static::$map[(string)$name];
			$strategyName = (string)$strategy;
			return
				$strategy instanceof IfaceWidgetMakeStrategy
				? $strategy
				: new $strategyName();
		}

		if ($def && !defined('WIDGET_MAKER_DEF_OFF'))
			if (static::$defaultStrategy) {
				return static::$defaultStrategy;
			}

		throw new WrongArgumentException('Not found widget in map name:'.$name.' or not set default');
	}

	/*
	// @todo
	static public function from($object)
	{

	}
	// @todo
	static public function fromTo($object, $widget)
	{

	}
	 */
}

