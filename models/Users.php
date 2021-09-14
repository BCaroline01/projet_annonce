<?php
class Users extends Ads
{
    private $_idUsers;
    private $_mail;

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

    public function getIdUsers()
    {
        return $this->_idUsers;
    }

    public function getMail()
    {
        return $this->_mail;
    }

    /* --------------------------------- SETTER --------------------------------- */

    public function setIdUsers($idUsers)
    {
        $idUsers = (int) $idUsers;
        if ($idUsers > 0) {
            $this->_idUsers = $idUsers;
        }
    }

    public function setMail($mail)
    {
        if (is_string($mail)) {
            $this->_mail = $mail;
        }
    }
}
