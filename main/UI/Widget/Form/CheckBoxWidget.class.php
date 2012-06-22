<?php
    /**
     * Widget class for <input type="checkbox"> element.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class CheckBoxWidget extends FieldWidget
    {
        public function __construct($name) {
            parent::__construct($name);
            $this
                ->setView('form/check-box')
                ->setTagName('input')
                ->setAttribute('type', 'checkbox');
        }

        public function setChecked($checked = true) {
            $this->setAttribute('checked', (bool)$checked);
            return $this;
        }

        public function prepare() {
            parent::prepare();
            $this->setAttribute('value', $this->getValue());
            return $this;
        }

        public function importPrimitive(BasePrimitive $primitive)
        {
            parent::importPrimitive($primitive);
            if ($primitive instanceof PrimitiveBoolean) {
                $this
                    ->setValue(false)
                    ->setChecked($primitive->getValue());
            }
            return $this;
        }


    }
