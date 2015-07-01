<?php

namespace An1zhegorodov\JQueueBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;

/**
 * Job
 *
 * @ORM\Table(name="jqueue_job")
 * @ORM\Entity(repositoryClass="An1zhegorodov\JQueueBundle\Entity\JobRepository")
 */
class Job extends BaseJob
{
    /**
     * @var integer
     *
     * @ORM\Column(name="type_id", type="smallint")
     */
    private $typeId;

    /**
     * @var array
     *
     * @ORM\Column(name="data", type="array")
     */
    private $data;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private $updated;

    /**
     * @return int
     */
    public function getTypeId()
    {
        return $this->typeId;
    }

    /**
     * @param int $typeId
     */
    public function setTypeId($typeId)
    {
        $this->typeId = $typeId;
    }

    /**
     * Set data
     *
     * @param array $data
     * @return Job
     */
    public function setData($data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }
}