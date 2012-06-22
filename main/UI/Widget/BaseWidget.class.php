<?php
    /**
     * Base widget class
     *
     * Extends {@link ModelAndView} to aggregate:
     * — template-based view;
     * — model to store and pass related data.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    abstract class BaseWidget extends ModelAndView implements IfaceWidget
    {
        /**
         * Factory alias for constructor
         *
         * @static
         * @return $this|ModelAndView
         */
        public static function create() {
            $factory = new ReflectionClass(get_called_class());
            return $factory->newInstanceArgs(func_get_args());
        }

        /**
         * Capture {@link render()} and return the string
         *
         * @return string
         * @see render()
         */
        final public function __toString() {
            try {
                ob_start();
                $this->prepare();
                $this->getView()->render($this->getModel());
                return ob_get_clean();
            } catch (Exception $ex) {
                return strval($ex);
            }
        }

        /**
         * Get view object
         *
         * Note, that when you set template file name using {@link setView}
         * (as you typically would) this method will resolve it to
         * ready-to-use View object.
         *
         * @return View
         */
        public function getView() {
            $view = parent::getView();
            $view = is_string($view) ? Widget::resolveView($this, $view) : $view;
            return $view;
        }

        /**
         * Prepare this object for rendering
         *
         * Typically you will override this method
         * to fill {@link model() aggregated model}
         * with custom private or protected data.
         *
         * This method is called in the very beginning of {@link __toString()}
         *
         * @return $this
         * @see __toString()
         */
        protected function prepare() {
            return $this;
        }
    }
