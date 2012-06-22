<?php
    /**
     * Static factory that builds {@link BaseWidget widgets}
     * upon logical entities (e.g. {@link BasePrimitive primitives}).
     *
     * Technically this interface is empty, but {@link Widget} singleton
     * heavily relies on it. See {@link Widget::setFactory()}.
     *
     * @author Peter Vyazovetskiy <anotherpit@gmail.com>
     */
    interface IfaceWidgetFactory
    {
    }
