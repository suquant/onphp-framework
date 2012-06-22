<?php
    /**
     * Widget class for <input> element.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class InputWidget extends FieldWidget
    {
        public function __construct($name) {
            parent::__construct($name);
            $this
                ->setView('form/input')
                ->setTagName('input')
                ->setInputType('text');
        }

        public function setMaxLength($length) {
            $this->setAttribute('maxlength', (false === $length) ? false : intval($length));
            return $this;
        }

        public function setPlaceholder($placeholder) {
            $this->setAttribute('placeholder', $placeholder);
            return $this;
        }

        public function setInputType($type) {
            $this->setAttribute('type', $type);
            return $this;
        }

        public function prepare() {
            parent::prepare();
            $this->setAttribute('value', $this->getValue());
            return $this;
        }

    }
