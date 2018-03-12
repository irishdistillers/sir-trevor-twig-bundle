<?php

namespace IrishDistillers\SirTrevorTwig;

use Symfony\Bundle\TwigBundle\TwigEngine;

class SirTrevor
{
    /**
     * @var Symfony\Bundle\TwigBundle\TwigEngine
     */
    protected $templating = null;

    /**
     * @var array
     */
    protected $loadedBlocks = [];

    /**
     * @var array
     */
    protected $defaultOptions = [
        'mobile' => false
    ];

    public function __construct(TwigEngine $templating = null)
    {
        $this->templating = $templating;
    }

    public function render(\stdClass $content, array $options = [], \Twig_Environment $environment = null) : string
    {
        if (is_null($environment)) {
            $environment = $this->templating;
        }

        return implode(
            "\n",
            array_map(
                function ($block) use ($environment, $options) {
                    try {
                        // Deep copy hack, otherwise the rand value gets overwritten
                        $block = unserialize(serialize($block));

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
