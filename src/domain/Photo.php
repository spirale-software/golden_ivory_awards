<?php
namespace G_I_A\Domain;

/**
 * @OVERVIEW: Photo est une classe représentant à quel nominé appartient la photo.
 */
class Photo {
    
    /**
     * id du de la photo.
     *
     * @var integer
     */
    private $id;
    
    /**
     * nominé auquel appartient la photo.
     *
     * @var integer
     */
    private $nomine;
    
    function getId() {
        return $this->id;
    }

    function getNomine() {
        return $this->nomine;
    }

    function setId($id) {
        $this->id = $id;
    }

    function setNomine($nomine) {
        $this->nomine = $nomine;
    }
}
