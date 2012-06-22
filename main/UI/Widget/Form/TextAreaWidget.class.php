<?php
    /**
     * Widget class for <textarea> element.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class TextAreaWidget extends FieldWidget
    {
        public function __construct($name) {
            parent::__construct($name);
            $this
                ->setView('form/text-area')
                ->setTagName('textarea');
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

    }
