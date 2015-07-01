<?php

namespace An1zhegorodov\JQueueBundle\Command;

use An1zhegorodov\JQueueBundle\Entity\Job;
use An1zhegorodov\JQueueBundle\Entity\JobStatuses;
use An1zhegorodov\JQueueBundle\Entity\JobTypes;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

abstract class AbstractJQueueWorker extends ContainerAwareCommand
{
    protected function configure()
    {
        $this->setName('jqueue:worker:run')
            ->addOption('id', null, InputOption::VALUE_REQUIRED, 'Unique worker id')
            ->addOption('job_type', null, InputOption::VALUE_REQUIRED, 'Job type for this worker to select')
            ->addOption('em', null, InputOption::VALUE_OPTIONAL, 'Entity manager', 'default')
            ->addOption('delay', null, InputOption::VALUE_OPTIONAL, 'Delay in seconds between queue polls', 1)
            ->addOption('expires', null, InputOption::VALUE_REQUIRED, 'Seconds before the worker dies')
            ->addOption('no-keep', null, InputOption::VALUE_NONE, 'Do not keep processed items in queue');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $noKeep = $input->getOption('no-keep');
        $expires = $input->getOption('expires');
        $delay = $input->getOption('delay');
        $emOption = $input->getOption('em');
        $jobTypeString = strtoupper($input->getOption('job_type'));
        $id = $input->getOption('id');
        if (!is_numeric($expires) || !is_numeric($delay) || !is_numeric($id)) {
            $output->writeln(sprintf('<error>%s</error>', $this->getSynopsis()));
        }
        $container = $this->getContainer();
        $em = $container->get(sprintf('doctrine.orm.%s_entity_manager', $emOption));
        $jobRepository = $em->getRepository('JQueueBundle:Job');
        $endTime = strtotime(sprintf('+%s seconds', $expires));
        while (time() < $endTime) {
            /** @var Job $job */
            $jobs = $jobRepository->pop($id, constant('\An1zhegorodov\JQueueBundle\Entity\JobTypes::' . $jobTypeString));
            if (!empty($jobs['0']) && ($job = $jobs['0']) instanceof Job) {
                $this->processJob($job, $input, $output);
                if ($noKeep) {
                    $em->remove($job);
                } else {
                    $job->setStatusId(JobStatuses::FINISHED);
                }
                $em->flush();
            }
            sleep($delay);
        }
    }

    abstract protected function processJob(Job $job, InputInterface $input, OutputInterface $output);
}