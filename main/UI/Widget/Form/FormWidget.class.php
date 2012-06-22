<?php
    /**
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class FormWidget extends HtmlWidget implements IfaceWidgetFactory
    {

        const METHOD_GET = 'GET';
        const METHOD_POST = 'POST';
        const ENCTYPE_DEFAULT = 'application/x-www-form-urlencoded';
        const ENCTYPE_UPLOAD = 'multipart/form-data';
        const ENCTYPE_RAW = 'text/plain';
        const TARGET_BLANK = '_blank';
        const TARGET_SELF = '_self';
        const TARGET_PARENT = 'parent';
        const TARGET_TOP = '_top';

        /**
         * @var Form
         */
        private $form = null;

        /**
         * @var array Prepared field widgets
         * @see setField(), getField()
         */
        private $fields = array();

        private $labels = array();

        private $descriptions = array();

        /**
         * @var array Form actions
         */
        private $actions = array();

        public function __construct($form = null) {
            parent::__construct();
            $this
                ->setView('form')
                ->setTagName('form')
                ->setForm($form)
                ->setMethod(self::METHOD_POST)
                ->setEnctype(self::ENCTYPE_DEFAULT)
                ->setTarget(self::TARGET_SELF)
                ->setActionUrl('');
        }

        static function fromForm(Form $entity) {
            return static::create($entity);
        }

        protected function getForm() {
            return $this->form;
        }

        protected function setForm($form = null) {
            if (!$form) {
                $form = Form::create();
            }
            Assert::isObject(
                $form,
                'Cannot build form widget upon ' . gettype($form)
            );
            Assert::isTrue(
                $form instanceof Form,
                'Cannot build form widget upon ' . get_class($form) . ' entity, Form expected'
            );
            $this->fields = array();
            $this->form = $form;
            return $this;
        }

        public function setMethod($method) {
            $this->setAttribute('method', $method);
            return $this;
        }

        public function setEnctype($enctype) {
            $this->setAttribute('enctype', ($enctype === self::ENCTYPE_DEFAULT) ? false : $enctype);
            return $this;
        }

        public function setTarget($target) {
            $this->setAttribute('target', ($target === self::TARGET_SELF) ? false : $target );
            return $this;
        }

        public function setActionUrl($url) {
            $this->setAttribute('action', strval($url));
            return $this;
        }

        public function setAction(ActionWidget $action) {
            $this->actions[$action->getName()] = $action;
            return $this;
        }

        public function getAction($name) {
            return $this->actions[$name];
        }

        public function setField(FieldWidget $widget) {
            $this->fields[$widget->getName()] = $widget;
            return $this;
        }

        /**
         * @param $name
         * @return FieldWidget
         */
        public function getField($name) {
            if (!isset($this->fields[$name])) {
                Assert::isTrue(
                    $this->form->exists($name),
                    'Primitive ' . $name . ' not found'
                );
                $this->fields[$name] = Widget::create($this->getForm()->get($name));
            }
            return $this->fields[$name];
        }

        public function setLabel($name, $label) {
            $this->labels[$name] = $label;
            return $this;
        }

        public function dropLabel($name) {
            if (isset($this->labels[$name])) {
                unset($this->labels[$name]);
            }
            return $this;
        }

        public function setDescription($name, $description) {
            $this->descriptions[$name] = $description;
            return $this;
        }

        public function dropDescription($name) {
            if (isset($this->descriptions[$name])) {
                unset($this->descriptions[$name]);
            }
            return $this;
        }


        protected function prepare() {
            parent::prepare();
            $fields = array();
            foreach ($this->form->getPrimitiveList() as $name => $primitive) {
                $fields[$name] = $this->getField($name);
            }
            $this->getModel()
                ->set('fields', $fields)
                ->set('labels', $this->labels)
                ->set('descriptions', $this->descriptions)
                ->set('form', $this->getForm())
                ->set('actions', $this->actions);
            return $this;
        }

    }
