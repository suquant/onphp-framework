<?php
    /**
     * Base widget class for form fields
     *
     * Provides access methods to standard HTML form element attributes.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    abstract class FieldWidget extends HtmlWidget
    {
        /**
         * @var mixed
         */
        private $value = null;

        public function __construct() {
            parent::__construct();
            $this
                ->setName('')
                ->setDisabled(false)
                ->setReadOnly(false)
                ->setAutoFocus(false)
                ->setAutoFocus(false)
            ;
        }

        public function setRequired($required = true)
        {
            $this->setAttribute('required', (bool)$required);
            return $this;
        }

        public function setName($name)
        {
            $this->setAttribute('name', $name);
            return $this;
        }

        public function getName() {
            return $this->getAttribute('name');
        }

        public function getValue() {
            return $this->value;
        }

        public function setValue($value)
        {
            $this->value = $value;
            return $this;
        }

        public function setDisabled($disabled = true)
        {
            $this->setAttribute('disabled', (bool)$disabled);
            return $this;
        }

        public function setReadOnly($readOnly = true)
        {
            $this->setAttribute('readonly', (bool)$readOnly);
            return $this;
        }

        public function setAutoFocus($autoFocus = true) {
            $this->setAttribute('autofocus', (bool)$autoFocus);
            return $this;
        }

        /**
         * Set 'tabIndex' attribute.
         *
         * To avoid collapse this method adjusts global {@link autoTabIndex()) sequence
         * to be greater then last numeric argument.
         *
         * @param mixed $index NULL to set {@link autoTabIndex() auto-generated index},
         *                     FALSE to drop attribute value,
         *                     or explicit integer value
         * @return $this
         * @see autoTabIndex()
         */
        public function setTabIndex($index = null)
        {
            if (is_null($index)) {
                // Auto
                $index = self::autoTabIndex();
            } else if (false === $index) {
                // Drop
                $this->setAttribute('tabindex', false);
            } else {
                // Check
                Assert::isTrue(
                    is_numeric($index),
                    'Attribute "tabIndex" expects numeric value, but ' . gettype($index) . ' given'
                );
                // Asjust auto-sequence
                self::$autoTabIndex = max(self::$autoTabIndex, $index);
                // Set
                $this->setAttribute('tabindex', intval($index));
            }
            return $this;
        }

        private static $autoTabIndex = 1000;

        /**
         * @static
         * @return mixed
         */
        final public static function autoTabIndex()
        {
            return ++self::$autoTabIndex;
        }

        /**
         * @static
         * @param BasePrimitive $prm
         * @return $this
         */
        public static function fromBasePrimitive(BasePrimitive $primitive) {
            return static::create()
                ->setRequired($primitive->isRequired())
                ->setName($primitive->getName());
        }

    }
