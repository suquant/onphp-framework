<?php
    /**
     * Base widget class that aggregates {@link HtmlElement}.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    abstract class HtmlWidget extends BaseWidget
    {
        /**
         * @var HtmlElement
         */
        private $html;

        public function __construct()
        {
            parent::__construct();
            $this->html = HtmlElement::create();
            $this->setView('html');
        }

        protected function prepare() {
            $this->getModel()->set('html', $this->getHtml());
            return parent::prepare();
        }

        protected function getHtml() {
            return $this->html;
        }

        protected function setTagName($tag) {
            $this->html->setTagName($tag);
            return $this;
        }

        protected function getTagName() {
            return $this->html->getTagName();
        }

        protected function setInnerHtml($html) {
            $this->html->setInnerhtml($html);
            return $this;
        }

        protected function getInnerHtml() {
            return $this->html->getInnerHtml();
        }

        public function addClass($name) {
            call_user_func_array(array($this->html, __METHOD__), func_get_args());
            return $this;
        }

        public function dropClass($name) {
            call_user_func_array(array($this->html, __METHOD__), func_get_args());
            return $this;
        }

        public function hasClass($name) {
            return $this->html->hasClass($name);
        }

        public function getClassesList($asString = false) {
            return $this->html->getClassesList($asString);
        }

        public function setAttribute($name, $value) {
            $this->html->setAttribute($name, $value);
            return $this;
        }

        public function dropAttribute($name) {
            $this->html->dropAttribute($name, $value);
            return $this;
        }

        public function hasAttribute($name) {
            return $this->html->hasAttribute($name);
        }

        public function getAttribute($name) {
            return $this->html->getAttribute($name);
        }

        public function setAttributesList(array $attrs) {
            $this->html->setAttributesList($attrs);
            return $this;
        }


    }
