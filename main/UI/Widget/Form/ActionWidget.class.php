<?php
    /**
     * Widget class for <button> element inside form.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class ActionWidget extends FieldWidget
    {
        public function __construct() {
            parent::__construct();
            $this->setTagName('button');
        }

        public function setContent($stringable) {
            $this->setInnerHtml(strval($stringable));
            return $this;
        }

        protected function prepare() {
            parent::prepare();

            // Only 'submit' buttons should be form actions
            // 'reset' buttons are evil, and default 'button' buttons
            // have nothing to do with forms
            $this->setAttribute('type', 'submit');

            return $this;
        }

    }
