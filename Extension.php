<?php

namespace IrishDistillers\SirTrevorTwig;

class Extension extends \Twig_Extension
{
    public function getFunctions() : array
    {
        return [
            'sirtrevor' => new \Twig_SimpleFunction(
                'sirtrevor',
                [$this, 'sirtrevor'],
                [
                    'needs_environment' => true,
                    'is_safe' => ['html']
                ])
        ];
    }

    public function sirtrevor(\Twig_Environment $environment, \stdClass $content) : string
    {
        return implode(
            "\n",
            array_map(
                function($block) use ($environment) {
                    try {
                        return $environment->render(
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