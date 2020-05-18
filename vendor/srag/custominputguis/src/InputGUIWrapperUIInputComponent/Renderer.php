<?php

namespace srag\CustomInputGUIs\SrPluginInfosFetcher\InputGUIWrapperUIInputComponent;

use ILIAS\UI\Component\Component;
use ILIAS\UI\Component\Input\Field\Input as InputInterface;
use ILIAS\UI\Implementation\Component\Input\Field\Input;
use ILIAS\UI\Implementation\Render\Template;
use ILIAS\UI\Renderer as RendererInterface;
use srag\DIC\SrPluginInfosFetcher\DICStatic;

if (DICStatic::version()->is6()) {
    /**
     * Class Renderer
     *
     * @package srag\CustomInputGUIs\SrPluginInfosFetcher\InputGUIWrapperUIInputComponent
     *
     * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
     */
    class Renderer extends AbstractRenderer
    {

        /**
         * @inheritDoc
         */
        public function render(Component $component, RendererInterface $default_renderer) : string
        {
            $input_tpl = $this->getTemplate("input.html", true, true);

            $html = $this->renderInputFieldWithContext($default_renderer, $input_tpl, $component, null, null);

            return $html;
        }


        /**
         * @inheritDoc
         */
        protected function renderInputField(Template $tpl, Input $input, $id, RendererInterface $default_renderer) : string
        {
            return $this->renderInput($tpl, $input);
        }
    }
} else {
    /**
     * Class Renderer
     *
     * @package srag\CustomInputGUIs\SrPluginInfosFetcher\InputGUIWrapperUIInputComponent
     *
     * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
     */
    class Renderer extends AbstractRenderer
    {

        /**
         * @inheritDoc
         */
        protected function renderNoneGroupInput(InputInterface $input, RendererInterface $default_renderer) : string
        {
            $input_tpl = $this->getTemplate("input.html", true, true);

            $html = $this->renderInputFieldWithContext($input_tpl, $input, null, null);

            return $html;
        }


        /**
         * @inheritDoc
         */
        protected function renderInputField(Template $tpl, Input $input, $id) : string
        {
            return $this->renderInput($tpl, $input);
        }
    }
}