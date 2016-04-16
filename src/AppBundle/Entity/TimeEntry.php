<?php
/**
 * Created by PhpStorm.
 * User: device
 * Date: 16.04.16
 * Time: 14:05
 */

namespace AppBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
/**
 * TimeEntry
 */
class TimeEntry
{
    /**
     * @Assert\NotBlank()
     */
    private $projectId;
    /**
     * @Assert\Type(
     *     type="numeric",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $issueId;
    /**
     * @Assert\NotBlank()
     * @Assert\Type(
     *     type="numeric",
     *     message="The value {{ value }} is not a valid {{ type }}."
     * )
     */
    private $hours;
    /**
     * @Assert\NotBlank()
     * @Assert\Length(
     *      min = 2,
     *      minMessage = "Your first name must be at least {{ limit }} characters long",
     * )
     */
    private $comments;


    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }
    /**
     * @param mixed $comments
     * @return $this
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getHours()
    {
        return $this->hours;
    }
    /**
     * @param mixed $hours
     * @return $this
     */
    public function setHours($hours)
    {
        $this->hours = $hours;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getIssueId()
    {
        return $this->issueId;
    }
    /**
     * @param mixed $issueId
     * @return $this
     */
    public function setIssueId($issueId)
    {
        $this->issueId = $issueId;
        return $this;
    }
    /**
     * @return mixed
     */
    public function getProjectId()
    {
        return $this->projectId;
    }
    /**
     * @param mixed $projectId
     * @return $this
     */
    public function setProjectId($projectId)
    {
        $this->projectId = $projectId;
        return $this;
    }

    public function toArray()
    {
        return [
            'time_entry' => [
                'project_id' => $this->projectId,
                'issue_id'   => $this->issueId,
                'hours'      => $this->hours,
                'comments'   => $this->comments
            ]
        ];
    }
}