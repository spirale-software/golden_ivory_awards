<?php namespace G_I_A\DAO;

include_once __DIR__.'/../domain/Categorie.php';
include_once __DIR__.'/DAO.php';

class CategorieDAO extends DAO 
{

/**
 * Find libelle according to a given ID
 * 
 * @param int $id, it a id of an categorie in the DB.
 * 
 * @return libelle
 */
public function find_libelle($id) {
        $sql = 'SELECT libelle FROM t_categorie where id = ?';
        
        $result = $this->getDb()->fetchAssoc($sql, array($id));
        
        return $result;
    }
    
   /**
 * Find ID according to a given libelle
 * 
 * @param string libelle, it a libelle of an categorie in the DB.
 * 
 * @return ID
 */
public function find_ID($libelle) {
        $sql = "SELECT categorie_id FROM t_categorie where libelle = ? ";
        
        $result = $this->getDb()->fetchAssoc($sql, array($libelle));     
        
        return $result;
    }

    public function save($categorie) {
        $categorieData = array(
            'libelle' => $categorie->getLibelle());
        $this->getDb()->insert('t_categorie', $categorieData);
    }
    
     public function edit($categorie) {
         $categorieData = array(
             'categorie_id'=> $categorie->getID(),
             'libelle' => $categorie->getLibelle()
         );
         
         $categorie_to_update = array('categorie_id' => $categorie->getId());
         
        $this->getDb()->update('t_categorie', $categorieData, $categorie_to_update);
    }
    
    public function delete_categorie($categorie_id) {
        $this->getDb()->delete('t_categorie', array(
            'id' => $categorie_id));
    }
    
    public function find_all() {
        $sql = 'SELECT * FROM t_categorie ORDER BY libelle';
        $result = $this->getDb()->fetchAll($sql);
        
        $categories = array();
        foreach ($result as $row) {
            $categorie_id = $row['categorie_id'];
            $categorie = $this->buildDomainObject($row);
            $categories[$categorie_id] = $categorie;
        }
        return $categories;
    }
    
    public function find_by_ID($categorie_id) {
        $sql = 'SELECT * FROM t_categorie WHERE categorie_id = ?'
                . ' ORDER BY libelle';
        $result = $this->getDb()->fetchAssoc($sql, array($categorie_id));
        
        $categories = array();
        foreach ($result as $row) {
            $categorie_id = $row['categorie_id'];
            $categorie = $this->buildDomainObject($row);
            $categories[$categorie_id] = $categorie;
        }
        return $categories;
    }
    
    public static  function builDomain($categorie_row) {
        
        $categorie = new \G_I_A\Domain\Categorie();
        $categorie->setId($categorie_row['categorie_id']);
        $categorie->setLibelle($categorie_row['libelle']);
        
        return $categorie;
    }


    protected function buildDomainObject($row) {
        
        return $this->builDomain($row);
    }
}


