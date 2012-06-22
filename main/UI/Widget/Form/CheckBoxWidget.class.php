<?php
    /**
     * Widget class for <input type="checkbox"> element.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class CheckBoxWidget extends FieldWidget
    {
        public function __construct() {
            parent::__construct();
            $this
                ->setView('form/check-box')
                ->setTagName('input')
                ->setInputType('checkbox');
        }

        public function setChecked($checked = true) {
            $this->setAttribute('checked', (bool)$checked);
            return $this;
        }

        public function prepare() {
            parent::prepare();
            $this->setAttribute('value', $this->getPrimitive()->getValue());
            return $this;
        }
    }
