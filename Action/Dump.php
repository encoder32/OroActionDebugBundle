<?php

namespace Oro\Bundle\ActionDebugBundle\Action;

use Oro\Component\Action\Action\AbstractAction;

/**
 * Dump current context to Debug Toolbar
 */
class Dump extends AbstractAction
{
    /** @var array */
    protected $options = [];

    /**
     * {@inheritdoc}
     */
    public function initialize(array $options)
    {
        if (count($options) !== 1) {
            throw new Exception\InvalidArgumentException(
                sprintf('Options must have 1 element, but %d given.', count($options))
            );
        }

        $this->options = $options;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    protected function executeAction($context)
    {
        if (function_exists('dump')) {
            dump([reset($this->options) => $context]);
        } elseif (method_exists($context, 'getScalarValues')) {
            print_r([reset($this->options) => $context->getScalarValues()]);
        } else {
            print_r([reset($this->options)]);
        }
    }
}
