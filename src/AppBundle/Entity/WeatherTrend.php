<?php

namespace AppBundle\Entity;

use AppBundle\Traits\BlameableEntityAssociation;
use Doctrine\ORM\Mapping as ORM;
use dsarhoya\DSYFilesBundle\Interfaces\IFileEnabledEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;
use JMS\Serializer\Annotation as JMS;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * WeatherTrend Entity.
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="AppBundle\Repository\WeatherTrendRepository")
 *
 * @author snake77se <yosip.curiel@dsarhoya.cl>
 */
class WeatherTrend implements IFileEnabledEntity
{
    const PATH_FILE = 'pucara_web/weather_trend';

    const TYPE_WEATHER = 'weather';
    const TYPE_CLIMATE = 'climate';
    const TYPE_SNOW = 'snow';

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @JMS\SerializedName("id")
     * @JMS\Groups({"weather_trend_detail","weather_trend_list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     * @JMS\SerializedName("name")
     * @JMS\Groups({"weather_trend_detail","weather_trend_list"})
     * @Assert\NotBlank()
     */
    private $name;

    /**
     * @ORM\Column(type="string", options={"default": "weather"})
     * @Assert\NotBlank()
     */
    private $type;

    /**
     * @var string|null
     *
     * @ORM\Column(type="string", nullable=true)
     * @JMS\SerializedName("filekey")
     * @JMS\Groups({"weather_trend_detail"})
     */
    private $fileKey;

    /**
     * @var UploadedFile
     *
     * @Assert\File(
     *      maxSize = "4M",
     *      maxSizeMessage = "File too big"
     * )
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="Mine")
     * @ORM\JoinColumn(nullable=true)
     *
     * @var Mine
     */
    private $mine;

    /*
     * Hook timestampable behavior
     * updates createdAt, updatedAt fields
     */
    use TimestampableEntity;

    /*
     * Hook blameable behavior
     * updates createdBy, updatedBy fields
     */
    use BlameableEntityAssociation;

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return WeatherTrend
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of file.
     *
     * @param string $file
     *
     * @return Editorial
     */
    public function setFile(File $file)
    {
        $this->file = $file;
        $this->fileKey = sprintf('file_%s.%s', md5(time()), $file->guessExtension());

        return $this;
    }

    /**
     * Get file.
     *
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * Get filepath.
     *
     * @return string
     */
    public function getFilePath()
    {
        return self::PATH_FILE;
    }

    /**
     * Get file properties.
     *
     * @return array
     */
    public function getFileProperties()
    {
        return ['ACL' => 'public-read'];
    }

    /**
     * Get full filekey.
     *
     * @return string
     */
    public function getFullFileKey()
    {
        return $this->getFilePath().'/'.$this->getFileKey();
    }

    /**
     * Get filekey.
     *
     * @return string|null
     */
    public function getFileKey()
    {
        return $this->fileKey;
    }

    /**
     * Set fileKey.
     *
     * @param string $fileKey
     *
     * @return WeatherTrend
     */
    public function setFileKey($fileKey)
    {
        $this->fileKey = $fileKey;

        return $this;
    }

    /**
     * Get the value of mine.
     *
     * @return Mine
     */
    public function getMine()
    {
        return $this->mine;
    }

    /**
     * Set the value of mine.
     *
     * @return self
     */
    public function setMine(Mine $mine)
    {
        $this->mine = $mine;

        return $this;
    }

    /**
     * Set type.
     *
     * @param string $type
     *
     * @return WeatherTrend
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    public static function typeChoices()
    {
        return [
            'Meteorología' => self::TYPE_WEATHER,
            'Climatología' => self::TYPE_CLIMATE,
            'Nivología' => self::TYPE_SNOW,
        ];
    }

    public function getTypeName()
    {
        $map = array_flip(self::typeChoices());

        return isset($map[$this->getType()]) ? $map[$this->getType()] : null;
    }
}
