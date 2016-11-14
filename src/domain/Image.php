<?php namespace G_I_A\Domain;

class Image {
    
    /**
     * id de l'Image.
     *
     * @var integer
     */
     private $id;
     
     /**
     * nom du fichier image.
     *
     * @var string
     */
     private $fileName;
     
     /**
     * id du nomine à laquelle appartient l'image.
     *
     * @var string
     */
     private $nomine_fk;
     
     /**
     * id de l'honneur à laquelle appartient l'image.
     *
     * @var string
     */
     private $honneur_fk;
     
     function getId() {
         return $this->id;
     }

     function getFileName() {
         return $this->fileName;
     }

     function getNomine_fk() {
         return $this->nomine_fk;
     }

     function getHonneur_fk() {
         return $this->honneur_fk;
     }

     function setId($id) {
         $this->id = $id;
     }

     function setFileName($fileName) {
         $this->fileName = $fileName;
     }

     function setNomine_fk($nomine_fk) {
         $this->nomine_fk = $nomine_fk;
     }

     function setHonneur_fk($honneur_fk) {
         $this->honneur_fk = $honneur_fk;
     }
}