<?php
    /**
     * Widget class for <select> element.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class SelectWidget extends FieldWidget
    {
        private $options = array();

        public function __construct($name) {
            parent::__construct($name);
            $this
                ->setView('form/select')
                ->setTagName('select')
                ->setOptionsList(array());
        }

        public function setValue($value) {
            $value = empty($value) ? array() : is_array($value) ? $value : (array)$value;
            Assert::isTrue(
                $this->isMultiple() or (count($value) <= 1),
                'This instance of select widget does not allow multiple values'
            );
            parent::setValue($value);
            return $this;
        }

        public function setMultiple($multiple = true) {
            $this->setAttribute('multiple', (bool)$multiple);
            return $this;
        }

        public function isMultiple() {
            return $this->hasAttribute('multiple');
        }

        public function setOptionsList(array $options) {
            $this->options = $options;
            return $this;
        }

        protected function prepare() {
            parent::prepare();
            $this->setAttribute('value', false);
            $this->getModel()
                ->set('options', $this->options)
                ->set('values', $this->getValue());
            return $this;
        }

    }
