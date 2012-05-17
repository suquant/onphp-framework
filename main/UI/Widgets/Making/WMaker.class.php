<?php
/***************************************************************************
 *   Copyright (C) by Georgiy T. Kutsurua                                  *
 *                                                                         *
 *   This program is free software; you can redistribute it and/or modify  *
 *   it under the terms of the GNU Lesser General Public License as        *
 *   published by the Free Software Foundation; either version 3 of the    *
 *   License, or (at your option) any later version.                       *
 ***************************************************************************/


	class WMaker
	{
		static protected $defaultStrategy;
		static protected $map = array(
			'BasePrimitive' => 'WDefaultPrimitiveMakeStrategy',
		);

		public static function setDefaultStrategy(IfaceWidgetMakeStrategy $strategy)
		{
			static::$defaultStrategy = $strategy;
		}


		/**
		 * @static
		 * @return IfaceWidgetMakeStrategy
		 */
		public static function getDefaultStrategy()
		{
			if(!static::$defaultStrategy)
				static::setDefaultStrategy(
					WDefaultMakeStrategy::me()
				);

			return static::$defaultStrategy;
		}

		/**
		 * @static
		 * @param array $map
		 * @throws WrongArgumentException
		 */
		public static function setMap(array $map)
		{
			array_walk($map, function($val, $key) {
				if (!$val instanceof IfaceWidgetMakeStrategy) {
					throw new WrongArgumentException('Not implimentation IfaceWidgetMakeStrategy '.$key);
				}
			});

			array_merge(static::$map, $map);
		}

		static public function cleanup()
		{
			static::$map = array();
		}

		/**
		 * @param string $name
		 * @return IfaceWidgetMakeStrategy
		 * @throws WrongArgumentException
		 */
		public static function get($name = null)
		{
			if (isset(static::$map[$name])) {
				$strategy = static::$map[$name];

				if($strategy instanceof IfaceWidgetMakeStrategy)
					return $strategy;
				else {

					if(ClassUtils::isInstanceOf($strategy, 'Singleton'))
						$strategy = Singleton::getInstance($strategy);
					else
						$strategy = new $strategy();

					Assert::isInstance(
						$strategy,
						'IfaceWidgetMakeStrategy',
						'Strategy mus instanceof IfaceWidgetMakeStrategy!'
					);

					return static::$map[$name] = $strategy;
				}
			}

			return static::getDefaultStrategy();
		}

		/**
		 * @static
		 * @param $entity
		 * @return mixed
		 */
		public static function make($entity)
		{
			Assert::isObject($entity);

			$tree = class_parents($entity);
			array_unshift($tree, get_class($entity));

			$strategy = null;
			foreach($tree as $name) {
				if(array_key_exists($name, static::$map))
				{
					$strategy = static::get($name);
					break;
				}
			}

			if(!$strategy)
				$strategy = static::getDefaultStrategy();

			return $strategy->makeBy($entity);
		}

	}

