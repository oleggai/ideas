<?php
/**
 * Created by PhpStorm.
 * User: Matrix
 * Date: 29.07.14
 * Time: 12:25
 */

/**
 * @Entity(repositoryClass="UserRepository")
 * @Table(name="users")
 */
class User {
    /**
     * @Id
     * @GeneratedValue
     * @Column(type="integer")
     */
    private $id;

    /** @Column(length=140) */
    private $name;

    /** @Column(length=140) */
    private $surname;

    /** @Column(length=140, unique=true) */
    private $login;

    /** @Column(length=140, name="password") */
    private $pass;

    /**
     * @ManyToOne(targetEntity="UserType")
     * @JoinColumn(name="type", referencedColumnName="id", nullable=false)
     */
    private $type;

    /**
     * @Column(type="boolean", name="deleted")
     *
     */
    private $deleted = false;

    /**
     * @Column(type="boolean", name="first_start", nullable=false)
     *
     */
    private $firstStart = false;

    /**
     * @param boolean $firstStart
     * @return User
     */
    public function setFirstStart($firstStart)
    {
        $this->firstStart = $firstStart;

        return $this;
    }

    /**
     * @return boolean
     */
    public function getFirstStart()
    {
        return $this->firstStart;
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
     * Set name
     *
     * @param string $name
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set surname
     *
     * @param string $surname
     * @return User
     */
    public function setSurname($surname)
    {
        $this->surname = $surname;

        return $this;
    }

    /**
     * Get surname
     *
     * @return string 
     */
    public function getSurname()
    {
        return $this->surname;
    }

    /**
     * Set login
     *
     * @param string $login
     * @return User
     */
    public function setLogin($login)
    {
        $this->login = $login;

        return $this;
    }

    /**
     * Get login
     *
     * @return string 
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * Set pass
     *
     * @param string $pass
     * @return User
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string 
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Set type
     *
     * @param string $type
     * @return User
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string 
     */
    public function getType()
    {
        return $this->type;
    }



    /**
     * Set deleted
     *
     * @param boolean $deleted
     * @return User
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
