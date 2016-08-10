<?php

namespace Statistic\BasicBundle\Workflow;

use Statistic\BasicBundle\Event\PostProcessEvent;
use Statistic\BasicBundle\Event\PreProcessEvent;
use Statistic\BasicBundle\Event\ProcessEvent;
use Statistic\BasicBundle\Processor\ProcessorInterface;
use Statistic\BasicBundle\Reader\ReaderInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class Workflow implements WorkflowInterface
{
    /**
     * @var ReaderInterface
     */
    protected $reader;

    /**
     * @var ProcessorInterface
     */
    protected $processor;

    /**
     * @var EventDispatcherInterface
     */
    protected $dispatcher;

    /**
     * Workflow constructor.
     *
     * @param ReaderInterface $reader
     * @param ProcessorInterface $processor
     * @param EventDispatcherInterface $dispatcher
     */
    public function __construct(ReaderInterface $reader, ProcessorInterface $processor,
                                EventDispatcherInterface $dispatcher)
    {
        $this->reader = $reader;
        $this->processor = $processor;
        $this->dispatcher = $dispatcher;
    }

    /**
     * @return ReaderInterface
     */
    public function getReader()
    {
        return $this->reader;
    }

    /**
     * @param ReaderInterface $reader
     * @return $this
     */
    public function setReader(ReaderInterface $reader)
    {
        $this->reader = $reader;

        return $this;
    }

    /**
     * @return ProcessorInterface
     */
    public function getProcessor()
    {
        return $this->processor;
    }

    /**
     * @param ProcessorInterface $processor
     * @return $this
     */
    public function setProcessor(ProcessorInterface $processor)
    {
        $this->processor = $processor;

        return $this;
    }


    public function process()
    {
        $items = $this->reader->getItems();
        $this->dispatcher->dispatch(PreProcessEvent::NAME, new PreProcessEvent($items));

        foreach ($items as $item) {
            $stat = $this->processor->process($item);
            $this->processor->save($stat, false);

            $this->reader->markProcess($item);
            $this->reader->saveItem($item, false);

            $this->dispatcher->dispatch(ProcessEvent::NAME, new ProcessEvent($item, $stat));
        }

        $this->reader->flush();
        $this->processor->flush();

        $this->dispatcher->dispatch(PostProcessEvent::NAME, new PostProcessEvent());
    }

}