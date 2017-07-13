<?php

namespace Oro\Bundle\ActionDebugBundle\Condition;

use Oro\Component\ConfigExpression\ContextAccessorAwareInterface;
use Oro\Component\ConfigExpression\ContextAccessorAwareTrait;
use Oro\Component\ConfigExpression\Condition\AbstractCondition;

use Symfony\Component\VarDumper\VarDumper;

/**
 * Dump current context into Debug Toolbar and return TRUE or FALSE result
 */
class Dump extends AbstractCondition implements ContextAccessorAwareInterface
{
    use ContextAccessorAwareTrait;

    const NAME = 'dump';

    /** @var array */
    protected $options = [];

    /** @var bool */
    protected $result;

    /**
     * @param bool $result
     */
    public function __construct($result)
    {
        $this->result = $result;
    }

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
    protected function isConditionAllowed($context)
    {
        VarDumper::dump([reset($this->options) => $context]);

        return $this->result;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function compile($factoryAccessor)
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return self::NAME;
    }
}
