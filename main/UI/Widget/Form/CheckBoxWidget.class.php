<?php
    /**
     * Widget class for <input type="checkbox"> element.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class CheckBoxWidget extends FieldWidget implements IfaceWidgetFactory
    {
        public function __construct() {
            parent::__construct();
            $this
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

        public static function fromPrimitiveBoolean(PrimitiveBoolean $primitive) {
            return parent::fromBasePrimitive($primitive)
                ->setValue(false)
                ->setChecked($primitive->getValue());
        }

    }
