<?php
    /**
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    class FormWidget extends HtmlWidget
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
         * @var array Prepared field widgets
         * @see setField(), getField()
         */
        private $fields = array();

        /**
         * @var array Form actions
         */
        private $actions = array();

        public function __construct() {
            parent::__construct();
            $this
                ->setView('form/form')
                ->setTagName('form')
                ->setMethod(self::METHOD_POST)
                ->setEnctype(self::ENCTYPE_DEFAULT)
                ->setTarget(self::TARGET_SELF)
                ->setActionUrl('');
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

        // TODO: single nameless action
        public function addAction(ActionWidget $action) {
            $this->actions[$action->getName()] = $action;
            return $this;
        }

        public function getAction($name) {
            return $this->actions[$name];
        }

        public function addField(FieldWidget $widget) {
            $this->fields[$widget->getName()] = $widget;
            return $this;
        }

        /**
         * @param $name
         * @return FieldWidget
         */
        public function getField($name) {
            return $this->fields[$name];
        }

        /**
         * @param Form $form
         * @return $this
         *
         * @see FieldWidget::importPrimitive
         */
        public function importForm(Form $form) {
            foreach($this->fields as $name => $field) {
                if ($form->exists($name)) {
                    $field->importPrimitive($form->get($name));
                }
            }
            return $this;
        }

        protected function prepare() {
            parent::prepare();
            $this->getModel()
                ->set('fields', $this->fields)
                ->set('actions', $this->actions);
            return $this;
        }

    }
