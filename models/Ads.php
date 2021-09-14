<?php
class Ads
{
    private $_idAds;
    private $_title;
    private $_content;
    private $_date;
    private $_price;
    private $_type;
    private $_image;
    private $_status;
    private $_idUnique;
    private $_idUsers;

    /* -------------------------------- CONSTRUCT ------------------------------- */
    public function __construct(array $datas)
    {
        $this->hydrate($datas);
    }

    public function hydrate(array $datas)
    {
        foreach ($datas as $key => $value) {
            $method = 'set' . ucfirst($key);

            if (method_exists($this, $method)) {
                $this->$method($value);
            }
        }
    }

    /* --------------------------------- GETTER --------------------------------- */
    public function getIdAds()
    {
        return $this->_idAds;
    }

    public function getTitle()
    {
        return $this->_title;
    }

    public function getContent()
    {
        return $this->_content;
    }
    public function getDate()
    {
        return $this->_date;
    }
    public function getPrice()
    {
        return $this->_price;
    }
    public function getType()
    {
        return $this->_type;
    }
    public function getImage()
    {
        return $this->_image;
    }
    public function getStatus()
    {
        return $this->_status;
    }
    public function getIdUnique()
    {
        return $this->_idUnique;
    }
    public function getIdUsers()
    {
        return $this->_idUsers;
    }

    /* --------------------------------- SETTER --------------------------------- */
    public function setIdAds($idAds)
    {
        $idAds = (int) $idAds;
        if ($idAds > 0) {
            $this->_idAds = $idAds;
        }
    }

    public function setTitle($title)
    {
        if (is_string($title)) {
            $this->_title = $title;
        }
    }

    public function setContent($content)
    {
        if (is_string($content)) {
            $this->_content = $content;
        }
    }
    public function setDate($date)
    {
        $this->_date = $date;
    }
    public function setPrice($price)
    {
        $this->_price = $price;
    }
    public function setType($type)
    {
        if (is_string($type)) {
            $this->_type = $type;
        }
    }
    public function setImage($image)
    {
        if (is_string($image)) {
            $this->_image = $image;
        }
    }
    public function setStatus($status)
    {
        if (is_string($status)) {
            $this->_status = $status;
        }
    }
    public function setIdUnique($idUnique)
    {
        if (is_string($idUnique)) {
            $this->_idUnique = $idUnique;
        }
    }
    public function setIdUsers($idUsers)
    {
        $idUsers = (int) $idUsers;

        if ($idUsers > 0) {
            $this->_idUsers = $idUsers;
        }
    }
}
