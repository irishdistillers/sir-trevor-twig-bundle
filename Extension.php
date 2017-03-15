<?php

namespace IrishDistillers\SirTrevorTwig;

class Extension extends \Twig_Extension
{
    public function initRuntime(\Twig_Environment $environment)
    {
        parent::initRuntime($environment);

        $this->_env = $environment;
    }

    public function getFunctions() : array
    {
        return [
            'sirtrevor' => new \Twig_Function_Method($this, 'sirtrevor')
        ];
    }

    public function sirtrevor(\stdClass $content) : string
    {
        return implode(
            "\n",
            array_map(
                function($block) {
                    try {
                        return $this->_env->render(
                            'SirTrevorTwig:_snippets:sirtrevor/'.$block->type.'.html.twig',
                            ['data' => $block->data]
                        );
                    } catch (\Twig_Error_Loader $exception) {
                        return sprintf('<!-- Snippet type: "%s" not found -->', $block->type);
                    }
                },
                $content->data
            )
        );
    }
}