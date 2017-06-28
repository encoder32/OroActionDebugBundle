<?php

namespace Oro\Bundle\ActionDebugBundle\EventListener;

use Oro\Component\Action\Event\ExecuteActionEvent;

class ExecuteActionListener
{
    const MAX_DEPTH = 6;

    /** @var bool */
    protected $enabled = false;

    /**
     * @param bool $enabled
     */
    public function setEnabled(bool $enabled)
    {
        $this->enabled = $enabled;
    }

    /**
     * @param ExecuteActionEvent $event
     */
    public function beforeExecute(ExecuteActionEvent $event)
    {
        if (!$this->enabled) {
            return;
        }

        print_r([
            'execute action' => get_class($event->getAction()),
            'options' => $this->getScalarValues($event->getAction()),
            'context values' => $this->getScalarValues($event->getContext())
        ]);
    }

    /**
     * @param ExecuteActionEvent $event
     */
    public function afterExecute(ExecuteActionEvent $event)
    {
        if (!$this->enabled) {
            return;
        }

        print_r([
            '/execute action' => get_class($event->getAction()),
            'context values' => $this->getScalarValues($event->getContext())
        ]);
    }

    /**
     * @param mixed $context
     * @return array
     */
    protected function getScalarValues($context)
    {
        $result = [];

        if ($context instanceof \Oro\Bundle\WorkflowBundle\Entity\WorkflowItem) {
            $result = [
                'data' => $this->getValues($context->getData()),
                'result' => $this->getValues($context->getResult()),
            ];
        } elseif ($context instanceof \Oro\Bundle\WorkflowBundle\Model\ProcessData) {
            $result = $this->getValues($context);
        } elseif ($context instanceof \Oro\Bundle\ActionBundle\Model\ActionData) {
            $result = $this->getValues($context);
        } elseif (is_object($context)) {
            $reflection = new \ReflectionClass($context);
            foreach($reflection->getProperties() as $property) {
                $property->setAccessible(true);
                $result[$property->getName()] = $property->getValue($context);
            }
            $result = $this->getValues($result);
        }

        return $result;
    }

    /**
     * @param mixed $context
     * @param int $depth
     * @return string|array
     */
    protected function getValues($context, $depth = 0)
    {
        if ($depth > self::MAX_DEPTH) {
            return 'N/A';
        }

        $result = [];

        if (is_array($context)) {
            foreach ($context as $key => $value) {
                $result[$key] = $this->getValues($value, $depth++);
            }
        } elseif (is_object($context)) {
            if ($context instanceof \ArrayAccess) {
                foreach($context as $key => $value) {
                    $result[$key] = $this->getValues($value, $depth++);
                }
            } else {
                $result = get_class($context);
                if (method_exists($context, 'getId')) {
                    $result .= ':' . $context->getId() ?: 'NULL';
                }
                if (method_exists($context, '__toString')) {
                    $result .= '(' . (string)$context . ')';
                }
            }
        } else {
            return $context;
        }

        return $result;
    }
}
