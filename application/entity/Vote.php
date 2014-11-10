<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 04.08.14
 * Time: 12:40
 */

/**
 * Class Vote
 * @Entity(repositoryClass="VoteRepository")
 * @Table(name="votes")
 */
class Vote {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;

    /**
     * @ManyToOne(targetEntity="Topic")
     * @JoinColumn(name="topic", referencedColumnName="id")
     */
    private $topic;

    /**
     * @Column(type="integer", name="mark")
     */
    private $mark;




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
     * Set mark
     *
     * @param integer $mark
     * @return Vote
     */
    public function setMark($mark)
    {
        $this->mark = $mark;

        return $this;
    }

    /**
     * Get mark
     *
     * @return integer 
     */
    public function getMark()
    {
        return $this->mark;
    }

    /**
     * Set user
     *
     * @param \User $user
     * @return Vote
     */
    public function setUser(\User $user = null)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return \User 
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set topic
     *
     * @param \Topic $topic
     * @return Vote
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
}
