<?php
    /**
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class PageWidget extends BaseWidget
    {
        public function __construct() {
            parent::__construct();
            $this
                ->setView('html/page')
                ->setTitle('')
                ->setContent('');
        }

        public function setTitle($title) {
            $this->getModel()->set('title', $title);
            return $this;
        }

        public function setContent($stringable) {
            $this->getModel()->set('content', $stringable);
            return $this;
        }

        protected function prepare()
        {
            parent::prepare();

            // Execute content strictly before
            // getStylesheets() and getScripts()
            // to ensure that contained widgets
            // register their resources
            $content = strval($this->getModel()->get('content'));

            $this->getModel()
                ->set('content', $content)
                ->set('stylesheets', static::getStylesheets())
                ->set('scripts', static::getScripts());
            return $this;
        }

        ///////////////////////////////////////////
        //      Global resource registry

        private static $stylesheets = array();
        private static $scripts = array();

        /**
         * Globally register stylesheet
         *
         * @static
         * @param string $href Unique stylesheet URL (all duplicates will be merged)
         * @param mixed $rel  Stylesheet 'rel' type, or FALSE to let the method detect it automatically by file extension
         */
        public static function addStylesheet($href, $rel = false)
        {
            static::$stylesheets[strval($href)] = strval($rel);
        }

        /**
         * @static
         * @return array of 'href' => 'rel'
         */
        public static function getStylesheets()
        {
            return static::$stylesheets;
        }

        /**
         * Globally register script
         *
         * @static
         * @param string $src Unique script URL (all duplicates will be merged)
         */
        public static function addScript($src)
        {
            static::$scripts[strval($src)] = true;
        }

        /**
         * @static
         * @return array of script URLs
         */
        public static function getScripts()
        {
            return array_keys(static::$scripts);
        }

    }
