<?php
    /**
     * HTML element.
     * Provides smart access methods for 'class' attribute.
     * // TODO Add access methods for 'style' attribute.
     * Note that although this class extends {@link SgmlTag} it is not itself compatible with {@link HtmlAssembler}.
     * For {@link HtmlAssembler} compatibility see {@link getOpenSgml()} and {@link getEndSgml()}.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class HtmlElement extends SgmlTag implements ToString
    {
        /**
         * Regular expression for names of tags that must always be empty (i.e. may not have closing tag).
         */
        const ALWAYS_EMPTY = '/^(area|base|basefont|br|col|frame|hr|img|input|isindex|link|meta|param)$/i';

        private $sgml = null;
        private $classes = array();
        private $innerHtml = '';

        public function __construct($tagName = 'div')
        {
            $this->sgml = new SgmlOpenTag();
            $this->sgml->setEmpty(false);
            $this->setTagName($tagName);
        }

        public static function create($tagName = 'div')
        {
            return new static($tagName);
        }

        /**
         * Whether this element can have closing tag or must always be empty.
         *
         * @return bool
         * @see ALWAYS_EMPTY
         */
        public function isAlwaysEmpty()
        {
            return (bool)preg_match(self::ALWAYS_EMPTY, $this->getTagName());
        }

        public function setTagName($id)
        {
            $this->sgml->setId($id);
            return $this;
        }

        public function getTagName()
        {
            return $this->sgml->getId();
        }

        public static function attrName($name)
        {
            Assert::isString($name, 'HTML attribute name must be string, but ' . gettype($name) . ' given');
            return htmlspecialchars(trim($name));
        }

        public static function attrValue($value)
        {
            $value = strval($value);
            return htmlspecialchars($value);
        }

        public function setAttributesList(array $attrs)
        {
            foreach ($attrs as $name => $value) {
                $this->setAttribute($name, $value);
            }
            return $this;
        }

        /**
         * @param string      $name
         * @param mixed       $value Standard string (or stringable) value,
         *                           FALSE to drop the attribute,
         *                           or TRUE to set the boolean attribute (e.g. 'checked', 'disabled')
         * @return HtmlElement
         */
        public function setAttribute($name, $value)
        {
            $name = self::attrName($name);
            if (strtolower($name) === 'class') {
                $this->dropClassesList()->addClass($value);
            } elseif (false === $value) {
                if ($this->hasAttribute($name)) {
                    $this->dropAttribute($name);
                }
            } else {
                $this->sgml->setAttribute($name, (true === $value) ? $name : self::attrValue($value));
            }
            return $this;
        }

        public function hasAttribute($name)
        {
            $name = self::attrName($name);
            return (strtolower($name) === 'class') ? !empty($this->classes) : $this->sgml->hasAttribute($name);
        }

        public function getAttribute($name)
        {
            $name = self::attrName($name);
            return (strtolower($name) === 'class') ? $this->getClassesList(true) : $this->sgml->getAttribute($name);
        }

        public function dropAttribute($name)
        {
            foreach (func_get_args() as $name) {
                $name = self::attrName($name);
                if (strtolower($name) === 'class') {
                    $this->dropClassesList();
                } else {
                    $this->sgml->dropAttribute($name);
                }
            }
            return $this;
        }

        public function getAttributesList($asString = false)
        {
            $attrs = $this->sgml->getAttributesList();
            if ($classes = $this->getAttribute('class')) {
                $attrs['class'] = $classes;
            }
            if ($asString) {
                $arr = array();
                foreach ($attrs as $name => $value) {
                    $arr[] = $name . '="' . $value . '"';
                }
                $attrs = implode(' ', $arr);
            }
            return $attrs;
        }

        public function dropAttributesList()
        {
            $this->sgml->dropAttributesList();
            $this->dropClassesList();
            return $this;
        }

        public function addClass($name)
        {
            foreach (func_get_args() as $name) {
                Assert::isTrue(
                    is_string($name) or is_array($name),
                    'Classes must be passed as strings or arrays, but ' . gettype($name) . ' is given'
                );
                if (is_array($name)) {
                    foreach ($name as $n) {
                        $this->addClass($n);
                    }
                } else {
                    foreach (explode(' ', $name) as $n) {
                        $this->classes[self::attrValue($n)] = true;
                    }
                }
            }
            return $this;
        }

        public function dropClass($name)
        {
            foreach (func_get_args() as $name) {
                Assert::isTrue(
                    is_string($name) or is_array($name),
                    'Classes must be passed as strings or arrays, but ' . gettype($name) . ' is given'
                );
                if (is_array($name)) {
                    foreach ($name as $n) {
                        $this->dropClass($n);
                    }
                } else {
                    foreach (explode(' ', $name) as $n) {
                        $n = self::attrValue($n);
                        if (isset($this->classes[$n])) {
                            unset($this->classes[$n]);
                        }
                    }
                }
            }
            return $this;
        }

        public function hasClass($name)
        {
            return isset($this->classes[self::attrValue($name)]);
        }

        public function dropClassesList()
        {
            $this->classes = array();
            return $this;
        }

        public function getClassesList($asString = false)
        {
            $classes = array_keys($this->classes);
            if ($asString) {
                $classes = implode(' ', $classes);
            }
            return $classes;
        }


        /**
         * @param string|ToString $html
         * @return $this
         */
        public function setInnerHtml($html)
        {
            Assert::isFalse(
                $this->isAlwaysEmpty(),
                $this->getTagName() . ' cannot have innerHTML'
            );
            $this->innerHtml = strval($html);
            return $this;
        }

        /**
         * @return string
         */
        public function getInnerHtml()
        {
            Assert::isFalse(
                $this->isAlwaysEmpty(),
                $this->getTagName() . ' cannot have innerHTML'
            );
            return $this->innerHtml;
        }

        /**
         * Get {@link SgmlOpenTag} representation of this HTML element.
         * To be used with {@link HtmlAssembler}.
         *
         * @return SgmlOpenTag
         */
        public function getOpenSgml()
        {
            if ($this->hasAttribute('class')) {
                $this->sgml->setAttribute('class', $this->getAttribute('class'));
            } else if ($this->sgml->hasAttribute('class')) {
                $this->sgml->dropAttribute('class');
            }
            return $this->sgml;
        }

        /**
         * Get {@link SgmlEndTag} that corresponds with {@link SgmlOpenTag} retrieved by {@link getOpenSgml()}.
         * To be used with {@link HtmlAssembler}.
         *
         * @return SgmlEndTag|null Corresponding end tag, or NULL if not availbale
         * @see isAlwaysEmpty()
         */
        public function getEndSgml()
        {
            return $this->isAlwaysEmpty() ? null : SgmlEndTag::create()->setId($this->getTagName());
        }

        /**
         * Get string representation of opening tag.
         *
         * @return string HTML
         */
        public function open()
        {
            return HtmlAssembler::makeTag($this->getOpenSgml());
        }

        /**
         * Get string representation of closing tag (if available)
         *
         * @return string HTML code, or empty string
         */
        public function close()
        {
            $end = $this->getEndSgml();
            return $end ? HtmlAssembler::makeTag($end) : '';
        }

        public function __toString()
        {
            return $this->open() . ($this->isAlwaysEmpty() ? '' : $this->getInnerHtml()) . $this->close();
        }

    }
