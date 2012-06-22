<?php
    /**
     *
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    final class Widget
    {

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
