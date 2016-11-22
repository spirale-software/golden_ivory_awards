<?php namespace G_I_A\DAO;

include_once __DIR__ . '/../domain/Actualite.php';
include_once __DIR__ . '/DAO.php';

/**
 * @OVERVIEW: ActualiteDAO représente le Data Access Objet(DAO) utilisé pour 
 *             l'accès à la BD.
 */
class ActualiteDAO extends DAO {
    
    public function find_all() {
        
        $sql = 'SELECT * FROM t_actualite ORDER BY date_creation';
        
        $actualites_array = $this->getDb()->fetchAll($sql);
        $actualites = array();
        foreach ($actualites_array as $row) {          
            $actualite = $this->buildDomainObject($row);
            $id = $row['actualite_id'];
            $actualites[$id] = $actualite;
        }
         
        return $actualites;      
    }
    
    public function save(\G_I_A\Domain\Actualite $actualite) {
        
        // Inser dans la BD la photo correspondante à cette actualite.
        
        
        $sql = "INSERT INTO t_actualite(titre, descriptif, date_creation) VALUES"
                . "(?, ?, NOW())";
        $this->getDb()->executeQuery($sql, array($actualite->getTitre(), 
            $actualite->getDescriptif()));
        
        /*$actualite_to_insert = array(
            'titre' => $actualite->getTitre(),
            'descriptif' => $actualite->getDescriptif(),
            'date_creation' => NOW());
        
        $this->getDb()->insert('t_actualite', $actualite_to_insert);*/
    }
    
    public function update(\G_I_A\Domain\Actualite $actualite) {
        
        $actualite_to_update = array(
            'titre' => $actualite->getTitre(),
            'descriptif' => $actualite->getDescriptif(),
            'date_creation' => $actualite->getDate());
        
        $this->getDb()->update('t_actualite', $actualite_to_update, 
                array($actualite->getId()));
    }
    
   
    
    public function find_actualite_by_titre($titre) {
        
        $sql = 'SELECT * FROM t_actualite WHERE titre = ?';
        $row = $this->getDb()->fetchAssoc($sql, array($titre));
        
        return $this->buildDomainObject($row);
    }
    
    protected function buildDomainObject($row) {
        
        $actualite = new \G_I_A\Domain\Actualite();
        
        $actualite->setActualite_id($row['actualite_id']);
        $actualite->setTitre($row['titre']);
        $actualite->setDescriptif($row['descriptif']);
        $actualite->setDate($row['date_creation']);
        
        return $actualite;
    }
}
