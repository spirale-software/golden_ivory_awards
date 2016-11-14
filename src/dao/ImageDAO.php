<?php namespace G_I_A\DAO;

class ImageDAO extends DAO {
    
    /**
     * Cherche toute les images d'un nominé donné dans la BD.
     *
     * @param integer $nomine_id
     */
    public function find_by_nomine($nomine_id) {
        $sql = 'SELECT fileName FROM t_image WHERE nomine_fk = ?';
        $result = $this->getDb()->fetchAssoc($sql, array($nomine_id));
        
        return $result;
        
    }
    
    /**
     * Cherche toute les images d'un Honneur donné dans la BD.
     *
     * @param integer honneur_id
     */
    public function find_by_honneur($honneur_id) {
        $sql = 'SELECT fileName FROM t_image WHERE honneur_fk = ?';
        $result = $this->getDb()->fetchAssoc($sql, array($honneur_id));
        
        return array_shift($result);
    }
    
    public function save(G_I_A\Domain\Image $image) {
        
        $image_to_insert = array(
            'fileName' => $image->getFileName(),
            'categorie_fk' => $image->getCategorie()->getID(),
            'honneur_fk' => $image->getHonneur()->getID());
        try {
            $this->getDb()->insert('t_image', $image_to_insert);
        } catch (Exception $ex) {
            $message = "dao.package -> ImageDAO.class -> save.method :: "
                    . "le nominé n'a pas pu être inséré dans la BD";
            throw new DAOException($message);
        }
    }
    
    protected function buildDomainObject($row) {
        
    }
}

