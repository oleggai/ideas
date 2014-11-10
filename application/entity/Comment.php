<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 04.08.14
 * Time: 12:33
 */

/**
 * Class Comment
 * @Entity
 * @Table(name="comments")
 */
class Comment {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="creator", referencedColumnName="id")
     */
    private $creator;

    /**
     * @ManyToOne(targetEntity="Topic")
     * @JoinColumn(name="topic", referencedColumnName="id")
     */
    private $topic;

    /**
     * @Column(type="string")
     */
    private $comment;


    /** @Column(type="datetime") */
    private $date_created;

    /**
     * @Column(type="boolean")
     */
    private $deleted;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set comment
     *
     * @param string $comment
     * @return Comment
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string 
     */
    public function getComment()
    {
        return $this->comment;
    }

    

    /**
     * Set date_created
     *
     * @param \DateTime $dateCreated
     * @return Comment
     */
    public function setDateCreated($dateCreated)
    {
        $this->date_created = $dateCreated;

        return $this;
    }

    /**
     * Get date_created
     *
     * @return \DateTime 
     */
    public function getDateCreated()
    {
        return $this->date_created;
    }

    /**
     * Set creator
     *
     * @param \User $creator
     * @return Comment
     */
    public function setCreator(\User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return \User 
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Set topic
     *
     * @param \Topic $topic
     * @return Comment
     */
    public function setTopic(\Topic $topic = null)
    {
        $this->topic = $topic;

        return $this;
    }

    /**
     * Get topic
     *
     * @return \Topic 
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Comment
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }

    /**
     * Get deleted
     *
     * @return boolean 
     */
    public function getDeleted()
    {
        return $this->deleted;
    }
}
