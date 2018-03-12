<?php

namespace IrishDistillers\SirTrevorTwig;

use IrishDistillers\SirTrevorTwig\SirTrevor;

class Extension extends \Twig_Extension
{
    /**
     * @var IrishDistillers\SirTrevorTwig\SirTrevor
     */
    protected $sirTrevor;

    public function __construct(SirTrevor $sirTrevor)
    {
        $this->sirTrevor = $sirTrevor;
    }

    public function getFunctions() : array
    {
        return [
            'sirtrevor' => new \Twig_SimpleFunction(
                'sirtrevor',
                [$this, 'sirtrevor'],
                [
                    'needs_environment' => true,
                    'is_safe' => ['html']
                ]
            )
        ];
    }

    public function sirtrevor(\Twig_Environment $environment, \stdClass $content, array $options = []) : string
    {
        return $this->sirTrevor->render($content, $options, $environment);
    }

    public function getLoadedBlocks() : array
    {
        return $this->sirTrevor->getLoadedBlocks();
    }
}
