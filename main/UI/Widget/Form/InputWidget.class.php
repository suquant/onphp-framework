<?php
    /**
     * Widget class for <input> element.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     *
     * @method static InputWidget create()
     */
    class InputWidget extends FieldWidget implements IfaceWidgetFactory
    {
        public function __construct() {
            parent::__construct();
            $this
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

        public static function fromPrimitiveString(PrimitiveString $primitive) {
            $max = $primitive->getMax();
            if ($max and ($max > 128)) {
                return TextAreaWidget::fromPrimitiveString($primitive);
            }
            return parent::fromBasePrimitive($primitive)
                ->setInputType('text')
                ->setValue($primitive->getValue())
                ->setMaxLength($max ? $max : false)
                ->setPlaceholder(($default = $primitive->getDefault()) ? $default : false);
        }

        public static function fromPrimitiveNumber(PrimitiveNumber $primitive) {
            return parent::fromBasePrimitive($primitive)
                ->setInputType('number')
                ->setValue($primitive->getValue());
        }

    }
