<?php namespace G_I_A\DAO;

include_once __DIR__.'/../domain/Categorie.php';
include_once __DIR__.'/DAO.php';

class CategorieDAO extends DAO 
{
    public function save($categorie) {
        $categorieData = array(
            'libelle'=>$categorie->getLibelle());
        $this->getDb()->insert('categorie', $categorieData);
    }
    
    public function delete_categorie($id_categorie) {
        $this->getDb()->delete('categorie', array(
            'id_categorie' => $id_categorie));
    }
    
    public function findAll() {
        $sql = 'SELECT * FROM t_categorie ORDER BY libelle';
        $result = $this->getDb()->fetchAll($sql);
        
        $categories = array();
        foreach ($result as $row) {
            $categorie_id = $row['id_categorie'];
            $categorie = $this->buildDomainObject($row);
            $categories[$categorie_id] = $categorie;
        }
        return $categories;
    }


    protected function buildDomainObject($row) {
        $categorie = new \G_I_A\Domain\Categorie();
        $categorie->setId($row['id_categorie']);
        $categorie->setLibelle($row['libelle']);
        
        return $categorie;
    }
}


