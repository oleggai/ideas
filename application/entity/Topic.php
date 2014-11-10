<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 04.08.14
 * Time: 11:40
 */

/**
 * Class Topic

 * @Entity(repositoryClass="TopicRepository")
 * @Table(name="topics")
 */
class Topic {

    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /**
     * @Column(type="string")
     */
    private $title;

    /**
     * @Column(type="string")
     */
    private $message;

    /** @Column(type="datetime") */
    private $date_created;

    /**
     * @ManyToOne(targetEntity="User")
     * @JoinColumn(name="creator", referencedColumnName="id")
     */
    private $creator;

    /**
     * @Column(type="string")
     */
    private $picture;

    /**
     * @Column(type="boolean")
     */
    private $deleted = false;

    /**
     * @OneToMany(targetEntity="Comment", mappedBy="topic")
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $comments;

    /**
     * @OneToMany(targetEntity="Vote", mappedBy="topic")
     * @var \Doctrine\Common\Collections\ArrayCollection
     */
    private $votes;

    /**
     * @Column(type="integer")
     */
    private $link_type = 1;

    /**
     * @Column(type="string")
     */
    private $file_type = "";


    /**
     * @var float
     */
    private $mark = 0;

    /**
     * @var integer
     */
    private $activeCommentsCount = 0;

    /**
     * @var string
     */
    private $timeAgo = null;

    /**
     * @var integer
     */
    private $commentsCount;

    /**
     * @var integer
     */
    private $userMark = 0;

    /**
     * @param int $userMark
     */
    public function setUserMark($userMark)
    {
        $this->userMark = $userMark;
    }

    /**
     * @return int
     */
    public function getUserMark()
    {
        return $this->userMark;
    }




    /**
     * @param float $mark
     */
    public function setMark($mark)
    {
        $this->mark = $mark;
    }

    /**
     * @return float
     */
    public function getMark()
    {
        return $this->mark;
    }

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
     * Set date_created
     *
     * @param \DateTime $dateCreated
     * @return Topic
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
     * @return Topic
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
     * Set title
     *
     * @param string $title
     * @return Topic
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set message
     *
     * @param string $message
     * @return Topic
     */
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get message
     *
     * @return string 
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set picture
     *
     * @param string $picture
     * @return Topic
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * Get picture
     *
     * @return string 
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return Topic
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




    /**
     * Constructor
     */
    public function __construct()
    {
        $this->comments = new \Doctrine\Common\Collections\ArrayCollection();
    }

    /**
     * Add comments
     *
     * @param \Comment $comments
     * @return Topic
     */
    public function addComment(\Comment $comments)
    {
        $this->comments[] = $comments;

        return $this;
    }

    /**
     * Remove comments
     *
     * @param \Comment $comments
     */
    public function removeComment(\Comment $comments)
    {
        $this->comments->removeElement($comments);
    }

    /**
     * Get comments
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Add votes
     *
     * @param \Vote $votes
     * @return Topic
     */
    public function addVote(\Vote $votes)
    {
        $this->votes[] = $votes;

        return $this;
    }

    /**
     * Remove votes
     *
     * @param \Vote $votes
     */
    public function removeVote(\Vote $votes)
    {
        $this->votes->removeElement($votes);
    }

    /**
     * Get votes
     *
     * @return \Doctrine\Common\Collections\Collection 
     */
    public function getVotes()
    {
        return $this->votes;
    }

    public function calculateMark(){
        $this->getVotes();
        if($this->votes->count() > 0){
            $total = $this->votes->count();
            $sum = 0;
            foreach($this->votes as $vote){

                $sum += $vote->getMark();
            }

            $this->setMark(round($sum/$total));
        } else {
            $this->mark = 0;
        }

    }

    public function getCommentsCount(){
        if($this->commentsCount > 0){
            return $this->commentsCount;
        }

        $comments = $this->getComments();

        return $comments->count();
    }

    public function getActiveCommentsCount(){
        if($this->activeCommentsCount > 0){
            return $this->activeCommentsCount;
        }

        $comments = $this->getComments();
        $count = 0;
        foreach($comments as $comment){
            if(!$comment->getDeleted())
                $count++;
        }
        $this->activeCommentsCount = $count;

        return $count;
    }

    public function getDeletedCommentsCount(){
        //TODO:
        return 0;
    }

    /**
     * TODO: translate
     * @param int $granularity
     * @param array $lang
     * @return null|string
     */
    private function timeAgo($granularity=1, array $lang) {

        $date = ($this->date_created) ? $this->date_created->getTimestamp () : time();
        $difference = time() - $date;
        $periods = array('decade' => 315360000,
            'year' => 31536000,
            'month' => 2628000,
            'week' => 604800,
            'day' => 86400,
            'hour' => 3600,
            'minute' => 60,
            'second' => 1);
        if ($difference < 5) { // less than 5 seconds ago, let's say "just now"
            $retval = $lang['postedJustNow'];
            return $retval;
        } else {
            $retval = null;
            foreach ($periods as $key => $value) {
                if ($difference >= $value) {
                    $time = floor($difference/$value);
                    $difference %= $value;
                    $retval .= ($retval ? ' ' : '').$time.' ';
                    $retval .= (($time > 1) ? $lang[$key.'s'] : $lang[$key]);
                    $granularity--;
                }
                if ($granularity == '0') { break; }
            }
            return ($retval) ? $retval.' ' . $lang['ago'] : "";
        }
    }

    /**
     * @return string
     */
    public function getTimeAgo()
    {
        //var_dump(Controller::$language['time']);
        if(!$this->timeAgo && isset(Controller::$language['time'])){
            $this->timeAgo = $this->timeAgo(1, Controller::$language['time']);
        }
        return $this->timeAgo;
    }



    /**
     * Set link_type
     *
     * @param integer $linkType
     * @return Topic
     */
    public function setLinkType($linkType)
    {
        $this->link_type = $linkType;

        return $this;
    }

    /**
     * Get link_type
     *
     * @return integer 
     */
    public function getLinkType()
    {
        return $this->link_type;
    }

    /**
     * Set file_type
     *
     * @param string $fileType
     * @return Topic
     */
    public function setFileType($fileType)
    {
        $this->file_type = $fileType;

        return $this;
    }

    /**
     * Get file_type
     *
     * @return string 
     */
    public function getFileType()
    {
        return $this->file_type;
    }
}
