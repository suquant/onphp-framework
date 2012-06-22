<?php
    /**
     * Widget class for <img> element.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class ImgWidget extends HtmlWidget
    {
        public function __construct() {
            parent::__construct();
            $this
                ->setTagName('img')
                ->setSrc('')
                ->setAlt('');
        }

        public function setSrc($url) {
            $this->setAttribute('src', strval($url));
            return $this;
        }

        public function setAlt($alt) {
            $this->setAttribute('alt', strval($alt));
            return $this;
        }
    }
