<?php

namespace Statistic\BasicBundle\Workflow;

use Statistic\BasicBundle\Processor\ProcessorInterface;
use Statistic\BasicBundle\Reader\ReaderInterface;

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
     * Workflow constructor.
     * @param ReaderInterface $reader
     * @param ProcessorInterface $processor
     */
    public function __construct(ReaderInterface $reader, ProcessorInterface $processor)
    {
        $this->reader = $reader;
        $this->processor = $processor;
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

        foreach ($items as $item) {
            $stat = $this->processor->process($item);
            $this->processor->save($stat, false);

            $this->reader->markProcess($item);
            $this->reader->saveItem($item, false);
        }

        $this->reader->flush();
        $this->processor->flush();
    }

}