<?php

declare(strict_types=1);

namespace App\Infrastructure\Infrastructure\Doctrine;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;


trait TimestampableTrait
{
    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private DateTime $createdAt;

    /**
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(type="datetime")
     */
    private DateTime $updatedAt;

    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @param DateTime $createdAt
     *
     * @return TimestampableTrait
     */
    public function setCreatedAt(DateTime $createdAt): TimestampableTrait
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): DateTime
    {
        return $this->updatedAt;
    }

    /**
     * @param DateTime $updatedAt
     *
     * @return TimestampableTrait
     */
    public function setUpdatedAt(DateTime $updatedAt): TimestampableTrait
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}