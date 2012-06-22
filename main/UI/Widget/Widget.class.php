<?php
    /**
     *
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    final class Widget
    {

        ///////////////////////////////////////////////
        //      Registry for widget factories

        private static $factories = array(
            'Href' => 'AWidget',
            'Form' => 'FormWidget',
            'PrimitiveString' => 'InputWidget',
            'PrimitiveNumber' => 'InputWidget',
            'PrimitiveBoolean' => 'CheckBoxWidget'
        );

        /**
         * Register widget factory class.
         *
         * The class MUST implement IfaceWidgetFactory interface
         * and provide method 'fromClassName' that corresponds
         * entity class name you're associating the factory class with.
         *
         * For example:
         *      Widget::setFactory('Something', 'MyFactory')
         * requires that:
         *      1. MyFactory implements IfaceWidgetFactory interface
         *      2. MyFactory provides method fromSomething(Something $arg)
         *
         * @static
         * @param mixed $entity Widget object, or class name
         * @param string $factory Name of factory class
         * @return array
         */
        public static function setFactory($entity, $factory) {
            Assert::isInstance(
                $factory, 'IfaceWidgetFactory',
                'Widget factory must implement "IfaceWidgetFactory" interface'
            );
            $entity = is_object($entity) ? get_class($entity) : strval($entity);
            $factory = is_object($factory) ? get_class($factory) : strval($factory);
            Assert::isTrue(
                method_exists($factory, 'from' . $entity),
                'Widget factory must implement "from' . $entity . '()" to comply "IfaceWidgetFactory" interface'
            );
            return self::$factories[$entity] = $factory;
        }

        public static function getFactory($entity) {
            $entity = is_object($entity) ? get_class($entity) : strval($entity);
            return isset(self::$factories[$entity]) ? self::$factories[$entity] : null;
        }

        /**
         * Build widget upon logical entity
         *
         * @static
         * @param $entity
         * @return IfaceWidget
         */
        static function create($entity)
        {
            // Check
            Assert::isObject(
                $entity,
                'Unable to build widget for ' . gettype($entity) . ', object expected'
            );
            // Given entity is a widget itself
            if ($entity instanceof IfaceWidget) {
                return $entity;
            }
            $widget = false;
            $lineage = (array)get_class($entity) + class_parents($entity) + class_implements($entity);
            foreach ($lineage as $i => $class) {
                if ($factory = self::getFactory($class)) {
                    $widget = call_user_func(array($factory, 'from' . $class), $entity);
                    break;
                }
            }
            Assert::isTrue(
                $widget instanceof IfaceWidget,
                'Unable to build widget for ' . $lineage[0]
            );
            return $widget;
        }



        ///////////////////////////////////////////////
        //      Registry for view resolvers

        /**
         * @var ViewResolver Defaults to {@link MultiPrefixPhpViewResolver} over {@link SimplePhpView}
         */
        private static $defaultViewResolver;

        /**
         * @var array Maps widget classes to view resolver objects
         */
        private static $viewResolvers = array();

        /**
         * @static
         * @return ViewResolver
         */
        public static function getDefaultViewResolver()
        {
            return self::$defaultViewResolver ? self::$defaultViewResolver : self::setDefaultViewResolver();
        }

        /**
         * Change or reset default view resolver.
         *
         * @static
         * @param ViewResolver|null $viewResolver Resolver object, or NULL to reset default
         * @return MultiPrefixPhpViewResolver New default resolver
         */
        public static function setDefaultViewResolver($viewResolver = null)
        {
            if (!$viewResolver) {
                $viewResolver = MultiPrefixPhpViewResolver::create()
                    ->setViewClassName('SimplePhpView')
                    ->setPostfix(EXT_TPL)
                    ->addPrefix(ONPHP_UI_DEFAULT_WTEMPLATES_PATH);
            }
            Assert::isTrue(
                $viewResolver instanceof ViewResolver,
                'View resolver must implement "ViewResolver" interface'
            );
            return self::$defaultViewResolver = $viewResolver;
        }

        /**
         * @static
         * @param string|BaseWidget $widget Widget object or class name
         * @return ViewResolver Associated or default resolver
         */
        public static function getViewResolver($widget)
        {
            Assert::isInstance(
                $widget, 'BaseWidget',
                'Widget expected, but ' . gettype($widget) . ' given'
            );
            $name = is_object($widget) ? get_class($widget) : strval($widget);
            return isset(self::$viewResolvers[$name])
                ? self::$viewResolvers[$name]
                : self::getDefaultViewResolver();
        }

        /**
         * @static
         * @param string|BaseWidget $widget   Widget object or class name
         * @param ViewResolver|null $resolver Resolver object to associate with the widget,
         *                                    or NULL to reset current association to default resolver
         * @see getDefaultViewResolver()
         */
        public static function setViewResolver($widget, $resolver = null)
        {
            Assert::isInstance(
                $widget, 'BaseWidget',
                'Widget expected, but ' . gettype($widget) . ' given'
            );
            $name = is_object($widget) ? get_class($widget) : strval($widget);
            if ($resolver) {
                // Set
                Assert::isTrue(
                    $resolver instanceof ViewResolver,
                    'ViewResolver expected, but ' . gettype($resolver) . ' given'
                );
                self::$viewResolvers[$name] = $resolver;
            } else {
                // Drop
                if (isset(self::$viewResolvers[$name])) {
                    unset(self::$viewResolvers[$name]);
                }
            }
        }

        /**
         * Shorthand for self->getViewResolver()->resolveViewName().
         *
         * @static
         * @param string|BaseWidget $widget
         * @param string $viewName
         * @return View
         */
        public static function resolveView($widget, $viewName) {
            return self::getViewResolver($widget)->resolveViewName($viewName);
        }

    }
