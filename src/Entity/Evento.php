<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventoRepository")
 */
class Evento
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string")
     */
    private $title;

    /**
     * @ORM\Column(type="integer")
     */
    private $teacher;

    /**
     * @ORM\Column(type="datetime")
     */
    private $start;

    /**
     * @ORM\Column(type="datetime")
     */
    private $end;

    /**
     * @ORM\Column(type="integer")
     */
    private $place;

    /**
     * @ORM\Column(type="integer")
     */
    private $course;

    /**
     * @ORM\Column(type="integer")
     */
    private $topic;

    /**
     * @ORM\Column(type="integer")
     */
    private $coursetype;


    // used for display place.name
    private $placename;

    // used for display topic.gallery
    private $gallery;


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
     * Get the value of Date
     *
     * @return mixed
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set the value of Date
     *
     * @param mixed date
     *
     * @return self
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get the value of Title
     *
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set the value of Title
     *
     * @param mixed title
     *
     * @return self
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get the value of Image
     *
     * @return mixed
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set the value of Image
     *
     * @param mixed image
     *
     * @return self
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get the value of Teacher
     *
     * @return mixed
     */
    public function getTeacher()
    {
        return $this->teacher;
    }

    /**
     * Set the value of Teacher
     *
     * @param mixed teacher
     *
     * @return self
     */
    public function setTeacher($teacher)
    {
        $this->teacher = $teacher;

        return $this;
    }

    /**
     * Get the value of Start
     *
     * @return mixed
     */
    public function getStart()
    {
        return $this->start;
    }

    /**
     * Set the value of Start
     *
     * @param mixed start
     *
     * @return self
     */
    public function setStart($start)
    {
        $this->start = $start;

        return $this;
    }

    /**
     * Get the value of End
     *
     * @return mixed
     */
    public function getEnd()
    {
        return $this->end;
    }

    /**
     * Set the value of End
     *
     * @param mixed end
     *
     * @return self
     */
    public function setEnd($end)
    {
        $this->end = $end;

        return $this;
    }

    /**
     * Get the value of Place
     *
     * @return mixed
     */
    public function getPlace()
    {
        return $this->place;
    }

    /**
     * Set the value of Place
     *
     * @param mixed place
     *
     * @return self
     */
    public function setPlace($place)
    {
        $this->place = $place;

        return $this;
    }

    /**
     * Get the value of Course
     *
     * @return mixed
     */
    public function getCourse()
    {
        return $this->course;
    }

    /**
     * Set the value of Course
     *
     * @param mixed course
     *
     * @return self
     */
    public function setCourse($course)
    {
        $this->course = $course;

        return $this;
    }

    /**
     * Get the value of Topic
     *
     * @return mixed
     */
    public function getTopic()
    {
        return $this->topic;
    }

    /**
     * Set the value of Topic
     *
     * @param mixed topic
     *
     * @return self
     */
    public function setTopic($topic)
    {
        $this->topic = $topic;

        return $this;
    }



    public function getPlacename()
    {
        return $this->placename;
    }

    public function setPlacename($placename)
    {
        $this->placename = $placename;

        return $this;
    }


    public function getGallery()
    {
        return $this->gallery;
    }

    public function setGallery($gallery)
    {
        $this->gallery = $gallery;

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

}
