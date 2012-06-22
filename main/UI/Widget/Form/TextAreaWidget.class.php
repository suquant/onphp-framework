<?php
    /**
     * Widget class for <textarea> element.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class TextAreaWidget extends FieldWidget implements IfaceWidgetFactory
    {
        public function __construct() {
            parent::__construct();
            $this->setTagName('textarea');
        }

        public function setRows($rows) {
            $this->setAttribute('rows', (false === $rows) ? false : intval($rows));
            return $this;
        }

        public function setCols($cols) {
            $this->setAttribute('cols', (false === $cols) ? false : intval($cols));
            return $this;
        }

        public function setMaxLength($length) {
            $this->setAttribute('maxlength', (false === $length) ? false : intval($length));
            return $this;
        }

        public function prepare() {
            parent::prepare();
            $this->setInnerHtml($this->getValue());
            return $this;
        }

        public static function fromPrimitiveString(PrimitiveString $primitive) {
            return parent::fromBasePrimitive($primitive)
                ->setValue($primitive->getValue())
                ->setMaxLength(($max = $primitive->getMax()) ? $max : false)
                ->setPlaceholder(($default = $primitive->getDefault()) ? $default : false);
        }

    }
