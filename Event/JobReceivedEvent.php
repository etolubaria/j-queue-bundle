<?php

namespace An1zhegorodov\JQueueBundle\Event;

use An1zhegorodov\JQueueBundle\Entity\Job;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\EventDispatcher\Event;

class JobReceivedEvent extends Event
{
    /** @var Job */
    private $job;
    /** @var InputInterface */
    private $input;
    /** @var OutputInterface */
    private $output;

    function __construct(Job $job, InputInterface $input, OutputInterface $output)
    {
        $this->job = $job;
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * @return Job
     */
    public function getJob()
    {
        return $this->job;
    }

    /**
     * @param Job $job
     */
    public function setJob($job)
    {
        $this->job = $job;
    }

    /**
     * @return InputInterface
     */
    public function getInput()
    {
        return $this->input;
    }

    /**
     * @return OutputInterface
     */
    public function getOutput()
    {
        return $this->output;
    }
}