<?php

    require_once(dirname(__FILE__) . '/../../../global.inc.php');

    class Example implements Controller
    {
        public function handleRequest(HttpRequest $request)
        {
            $form = Form::create()
                ->add(Primitive::string('name')->required())
                ->add(Primitive::boolean('like'));
            $form->import($request->getGet());

            $widget = FormWidget::create()
                ->setActionUrl('')
                ->setMethod(FormWidget::METHOD_GET)
                ->addAction(ActionWidget::create('do')->setContent('Submit'))
                ->addField(InputWidget::create('name')->setLabel('My name is'))
                ->addField(CheckBoxWidget::create('like')->setLabel('and I like onPHP'))
                ->importForm($form);

            $page = PageWidget::create()
                ->setTitle($form->get('name')->isImported() ? ('Hello, ' . $form->get('name')->getValue()) : 'OnPHP — Widget example page')
                ->setContent($widget);

            return $page;
        }

    }

    $request = HttpRequest::create()->setGet($_GET)->setPost($_POST);
    $controller = new Example();
    $widget = $controller->handleRequest($request);
    echo $widget;

?>


