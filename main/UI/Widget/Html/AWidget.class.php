<?php
    /**
     * Widget class for <a> element.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class AWidget extends HtmlWidget
    {
        public function __construct() {
            parent::__construct();
            $this
                ->setView('html/a')
                ->setTagName('a')
                ->setContent('')
                ->setHref('');
        }

        public function setHref($href) {
            $href = strval($href);
            $this->setAttribute('href', $href);
            if (!$this->getInnerHtml()) {
                $this->setInnerHtml($href);
            }
            return $this;
        }

        public function setContent($stringable) {
            $this->setInnerHtml(strval($stringable));
            return $this;
        }

    }
