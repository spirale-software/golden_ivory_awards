<?php namespace G_I_A\DAO;

include_once __DIR__ . '/../domain/Prix.php';
include_once __DIR__ . '/DAO.php';

class PrixDAO extends DAO {

    /**
     * 
     */
    public function find_all() {

        $sql = 'SELECT * FROM t_prix ORDER BY libelle';
        $result = $this->getDb()->fetchAll($sql);

        $array_prix = array();
        foreach ($result as $row) {
            $prix_id = $row['id'];
            $prix = $this->buildDomainObject($row);
            $array_prix[$prix_id] = $prix;
        }
        return $array_prix;
    }

    protected function buildDomainObject($row) {
        $prix = new \G_I_A\Domain\Prix();

        $prix->setId($row['id']);
        $prix->setLibelle($row['libelle']);
        $prix->setDescriptif($row['descriptif']);
        $prix->setCategorieID($row['categorieID']);
        $prix->setGagnantID($row['gagnantID']);
        $prix->setPhotoID($row['photoID']);
    }
}
