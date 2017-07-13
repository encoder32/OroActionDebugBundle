<?php

namespace Oro\Bundle\ActionDebugBundle\Tests\Functional;

use Oro\Component\Action\Action\ActionFactory;
use Oro\Component\Action\Action\ActionInterface;
use Oro\Component\ConfigExpression\ExpressionFactory;
use Oro\Component\ConfigExpression\ExpressionInterface;

trait MockActionsTrait
{
    /**
     * @param string $name
     * @param \Closure $callback
     * @throws \Exception
     */
    protected function mockAction(string $name, \Closure $callback)
    {
        /* @var $factory ActionFactory */
        $factory = $this->getContainer()->get('oro_action.action_factory');

        if (!$factory->isTypeExists($name)) {
            throw new \Exception(sprintf('Action with name "%s" doesnt\'t registered', $name));
        }

        $service = $factory->getTypes()[$name];

        $action = $this->createMock(ActionInterface::class);
        $action->expects($this->any())->method('execute')->willReturnCallback($callback);

        $this->getContainer()->set($service, $action);
    }

    /**
     * @param string $name
     * @param \Closure $callback
     * @throws \Exception
     */
    protected function mockCondition(string $name, \Closure $callback)
    {
        /* @var $factory ExpressionFactory */
        $factory = $this->getContainer()->get('oro_action.expression.factory');

        if (!$factory->isTypeExists($name)) {
            throw new \Exception(sprintf('Condition with name "%s" doesnt\'t registered', $name));
        }

        $service = $factory->getTypes()[$name];

        $expression = $this->createMock(ExpressionInterface::class);
        $expression->expects($this->any())->method('evaluate')->willReturnCallback($callback);

        $this->getContainer()->set($service, $expression);
    }
}
