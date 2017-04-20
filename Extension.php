<?php

namespace IrishDistillers\SirTrevorTwig;

class Extension extends \Twig_Extension
{
    private $loadedBlocks = [];

    private $defaultOptions = [
        'mobile' => false
    ];

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

    public function sirtrevor(\Twig_Environment $environment, \stdClass $content, array $options = []) : string
    {
        return implode(
            "\n",
            array_map(
                function($block) use ($environment, $options) {
                    try {
                        $block->data->rand = mt_rand();
                        $this->loadedBlocks[] = $block;

                        return $environment->render(
                            'SirTrevorTwig:_snippets:sirtrevor/'.$block->type.'.html.twig',
                            [
                                'data' => $block->data,
                                'options' => array_merge($this->defaultOptions, $options)
                            ]
                        );
                    } catch (\Twig_Error_Loader $exception) {
                        return sprintf('<!-- Snippet type: "%s" not found -->', $block->type);
                    }
                },
                $content->data
            )
        );
    }

    public function getLoadedBlocks() : array
    {
        return $this->loadedBlocks;
    }
}