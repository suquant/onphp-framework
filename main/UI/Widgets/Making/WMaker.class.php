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
			'BasePrimitive' => 'WDefaultPrimitiveMaker',
		);

		public static function setDefaultStrategy(IfaceWidgetMaker $strategy)
		{
			static::$defaultStrategy = $strategy;
		}


		/**
		 * @static
		 * @return IfaceWidgetMaker
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
				if (!$val instanceof IfaceWidgetMaker) {
					throw new WrongArgumentException('Not implimentation IfaceWidgetMaker '.$key);
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
		 * @return IfaceWidgetMaker
		 * @throws WrongArgumentException
		 */
		public static function get($name = null)
		{
			if (isset(static::$map[$name])) {
				$strategy = static::$map[$name];

				if($strategy instanceof IfaceWidgetMaker)
					return $strategy;
				else {

					if(ClassUtils::isInstanceOf($strategy, 'Singleton'))
						$strategy = Singleton::getInstance($strategy);
					else
						$strategy = new $strategy();

					Assert::isInstance(
						$strategy,
						'IfaceWidgetMaker',
						'Strategy mus instanceof IfaceWidgetMaker!'
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

