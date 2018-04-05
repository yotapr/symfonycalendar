<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 */
class Type
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\Column(type="string")
     */
    private $coursetype;

    private $delete;

    // add your own fields

    /**
     * Get the value of Id
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of Coursetype
     *
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * Set the value of Coursetype
     *
     * @param mixed coursetype
     *
     * @return self
     */
    public function setActive($active)
    {
        $this->active = $active;

        return $this;
    }

    /**
     * Get the value of Coursetype
     *
     * @return mixed
     */
    public function getCoursetype()
    {
        return $this->coursetype;
    }

    /**
     * Set the value of Coursetype
     *
     * @param mixed coursetype
     *
     * @return self
     */
    public function setCoursetype($coursetype)
    {
        $this->coursetype = $coursetype;

        return $this;
    }


    /**
     * Set the value of Id
     *
     * @param mixed id
     *
     * @return self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of Delete
     *
     * @return mixed
     */
    public function getDelete()
    {
        return $this->delete;
    }

    /**
     * Set the value of Delete
     *
     * @param mixed delete
     *
     * @return self
     */
    public function setDelete($delete)
    {
        $this->delete = $delete;

        return $this;
    }

}
