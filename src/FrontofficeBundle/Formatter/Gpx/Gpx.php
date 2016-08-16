<?php
/**
 * Created by PhpStorm.
 * User: Valentin
 * Date: 16/08/2016
 * Time: 13:30
 */

namespace FrontofficeBundle\Formatter\Gpx;


use FrontofficeBundle\Entity\Course;

class Gpx
{
    private $carte = array();
    private $minLon = null;
    private $maxLon = null;
    private $minLat = null;
    private $maxLat = null;

    /**
     * Gpx constructor.
     * @param Course $course
     */
    public function __construct($course)
    {
        $xml = new \SimpleXMLElement(file_get_contents('/uploads/gpx/'.$course->getGpx()));
        foreach($xml->trk->trkseg->trkpt as $value) {
            $lon = floatval($value['lon']);
            $lat = floatval($value['lat']);
            $ele = intval($value->ele);

            if(count($this->carte) == 0){
                $this->minLon = $this->maxLon = $lon;
                $this->minLat = $this->maxLat = $lat;
            }

            if($this->minLon > $lon) $this->minLon = $lon;
            if($this->maxLon < $lon) $this->maxLon = $lon;
            if($this->minLat > $lon) $this->minLat = $lat;
            if($this->maxLat < $lon) $this->maxLat = $lat;

            $this->carte[] = array($lon,$lat,$ele);
        }
    }

    /**
     * @return array
     */
    public function getCarte()
    {
        return $this->carte;
    }

    /**
     * @param array $carte
     */
    public function setCarte($carte)
    {
        $this->carte = $carte;
    }

    /**
     * @return float|null
     */
    public function getMinLon()
    {
        return $this->minLon;
    }

    /**
     * @param float|null $minLon
     */
    public function setMinLon($minLon)
    {
        $this->minLon = $minLon;
    }

    /**
     * @return float|null
     */
    public function getMaxLon()
    {
        return $this->maxLon;
    }

    /**
     * @param float|null $maxLon
     */
    public function setMaxLon($maxLon)
    {
        $this->maxLon = $maxLon;
    }

    /**
     * @return float|null
     */
    public function getMinLat()
    {
        return $this->minLat;
    }

    /**
     * @param float|null $minLat
     */
    public function setMinLat($minLat)
    {
        $this->minLat = $minLat;
    }

    /**
     * @return float|null
     */
    public function getMaxLat()
    {
        return $this->maxLat;
    }

    /**
     * @param float|null $maxLat
     */
    public function setMaxLat($maxLat)
    {
        $this->maxLat = $maxLat;
    }
}