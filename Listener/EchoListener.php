<?php

namespace An1zhegorodov\JQueueBundle\Listener;


use An1zhegorodov\JQueueBundle\Entity\Job;
use An1zhegorodov\JQueueBundle\Event\JobReceivedEvent;

class EchoListener
{
    protected $jobTypeId;

    public function __construct($jobTypeId)
    {
        $this->jobTypeId = $jobTypeId;
    }

    public function onJobReceived(JobReceivedEvent $event)
    {
        $job = $event->getJob();
        $output = $event->getOutput();
        if ($job instanceof Job && $job->getTypeId() === $this->jobTypeId) {
            $data = $job->getData();
            $output->writeln($data['0']);
        }
    }
}