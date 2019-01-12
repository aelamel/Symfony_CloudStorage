<?php

namespace AppBundle\Entity;

use Symfony\Component\HttpFoundation\File\File as File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * ReleaseNotes
 *
 * @ORM\Table(name="release_notes")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ReleaseNotesRepository")
 * @Vich\Uploadable
 */

class ReleaseNotes
{

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, name="version", nullable=true)
     *
     * @var string $version
     */
    private $version;


    /**
     * @ORM\Column(type="string", length=255, name="document", nullable=true)
     *
     * @var string $document
     */
    private $document;

    /**
     * @var string
     *
     * @ORM\Column(name="message", type="text")
     */
    private $message;

    /**
     * @var \DateTime
     * Release date
     * @ORM\Column(type="datetime", name="release_date", nullable=true)
     */
    private $releaseDate;

    /**
     * @Assert\File(
     *  mimeTypes={
     *          "application/pdf",
     *          "image/jpeg",
     *          "image/pjpeg",
     *          "application/msword",
     *          "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
     *          "application/vnd.ms-excel",
     *          "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
     *          "application/zip",
     *          "image/png",
     *          "image/x-png",
     *          "image/bmp",
     *          "image/x-ms-bmp",
     *          "image/bmp",
     *          "image/gif",
     *          "image/jpeg",
     *          "image/tiff",
     *          "application/vnd.ms-powerpoint",
     *          "application/vnd.ms-excel",
     *          "image/x-xbitmap",
     *          "application/zip",
     *          "text/plain",
     *          "text/html",
     *          "application/msword",
     *          "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
     *          "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
     *          "application/vnd.openxmlformats-officedocument.presentationml.presentation"
     *  },
     *  mimeTypesMessage="The file format is not correct",
     *  maxSize="100M"
     * )
     * @Vich\UploadableField(mapping="release_note_mapping", fileNameProperty="document", nullable=true)
     *
     * @var File $file
     * @Serializer\Exclude
     */
    private $file;

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
    }

    /**
     * @param string $version
     */
    public function setVersion($version)
    {
        $this->version = $version;
    }

    /**
     * @return mixed
     */
    public function getDocument()
    {
        return $this->document;
    }

    /**
     * @param mixed $document
     */
    public function setDocument($document)
    {
        $this->document = $document;
    }

    /**
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param string $message
     */
    public function setMessage($message)
    {
        $this->message = $message;
    }

    /**
     * @return File
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @param File $file
     */
    public function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * @return \DateTime
     */
    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @param mixed $releaseDate
     */
    public function setReleaseDate($releaseDate)
    {
        if (!$releaseDate instanceof \DateTime && null !== $releaseDate) {
            $this->releaseDate = new \DateTime($releaseDate);
        } else {
            $this->releaseDate = $releaseDate;
        }
    }
}
