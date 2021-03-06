<?php

namespace Suxx\Commands {

    use Suxx\Http\Request;

    abstract class AbstractFormCommand
    {
        abstract public function execute(Request $request);

        abstract protected function validateRequest();

        abstract protected function performAction();

        abstract protected function hasErrors();

        abstract protected function repopulateForm();
    }
}

