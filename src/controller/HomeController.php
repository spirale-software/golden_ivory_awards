<?php namespace G_I_A\Controller;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

include_once __DIR__ . '/../form/type/categorieType.php';
include_once __DIR__ . '/../form/type/ContactType.php';
include_once __DIR__ . '/../domain/Contact.php';

class HomeController {

    public function contact_action(Application $app, Request $request) {

        $contact = new \G_I_A\Domain\Contact();
        $contact_form = $app['form.factory']->create(
                new \G_I_A\Form\Type\ContactType(), $contact);

        $contact_form->handleRequest($request);

        if ($contact_form->isSubmitted() && $contact_form->isValid()) {
            // Envoie du message
            /*$message = \Swift_Message::newInstance()
                    ->setSubject('[mailer] test')
                    ->setFrom(array('gyleentrepreneur@gmail.com'))
                    ->setTo(array($contact->getEmail()))
                    ->setBody($contact->getMessage());

            $app['mailer']->send($message);*/
            
         mail($contact->getEmail(), $objet, $contact->getMessage(), $entete);

            $app['session']->getFlashBag()->add(
                    'success', 'Votre message a bien été envoyé');
        }

        return $app['twig']->render('contact_form.html.twig', array(
                    'contact_form' => $contact_form->createView()));
    }

    /**
     * allow to show detail about a nomine. 
     * 
     * @param Application $app
     * @param int $id : represent the id of the given nomine.
     * 
     * return nomine_detail.html.twig
     */
    public function nomine_detail_action(Application $app, $id) {

        $_nomine = $app['dao.nomine']->find_nomine_by_ID($id);
        $nomine = array_shift($_nomine);

        return $app['twig']->render('nomine_detail.html.twig', array(
                    'nomine' => $nomine,
                    'title' => 'Detail'));
    }

    /**
     * Show all nomines who discuss a given honnor.
     * 
     * @param Application $app
     * @param integer $id
     * 
     * @return nomine_honneur.html.twig
     */
    public function nomine_honneur_action(Application $app, $id) {

        $nomines = $app['dao.nomine']->find_nomine_by_categorie($id);

        return $app['twig']->render('nomine_all.html.twig', array(
                    'title' => 'nomines',
                    'nomines' => $nomines));
    }

    /**
     * 
     * @param Application $app
     * 
     * @return index.html.twig
     */
    public function index_action(Application $app) {

        /* $user = new \G_I_A\Domain\User();
          $salt = uniqid();
          $user->setSalt($salt);

          $encoder = $app['security.encoder_factory']->getEncoder($user);
          $password = $encoder->encodePassword('admin', $user->getSalt());

          //echo 'pwd:'.$password;
          //echo 'salt: '.$salt;

          $p = '6R70Hwd8DyDXHEg2PQ2kKunJBx08hy7KCDSx58RHuiVFR7UgrzOtnGXNVyKoi/8oD3VcLSQ/dVZbViT7Xldv5A==';
          $s= '582ea561ea777'; */

        return $app['twig']->render('index.html.twig');
    }

    /**
     * Show all nomine who are in the DB.
     * 
     * @param Application $app, Request $request
     *  
     * @return all_nomines.html.twig
     */
    public function all_nomines_action(Application $app) {

        $nomines = $app['dao.nomine']->find_all_nomine();

        return $app['twig']->render('nomine_all.html.twig', array(
                    'nomines' => $nomines,
                    'title' => 'Nominés'));
    }
    
    
    public function qui_sommes_nous_action(Application $app) {

        return $app['twig']->render('qui_sommes_nous.html.twig');
    }

    /**
     * Show all honneur
     * @param Application $app
     * 
     * @return honneur.html.twig
     */
    public function honneur_action(Application $app) {

        $honneurs = $app['dao.honneur']->find_all();

        return $app['twig']->render('honneur.html.twig', array(
                    'title' => 'Honneur',
                    'honneurs' => $honneurs));
    }

    /**
     * Show all honneur
     * @param Application $app
     * 
     * @return honneur.html.twig
     */
    public function partenaire_action(Application $app) {

        return $app['twig']->render('partenaire.html.twig', array(
                    'title' => 'Partenaire'));
    }

    /**
     * 
     * @param array $categories
     * @param int $id.
     * 
     * @return string libelle, according to the $id.
     */
    private function find_libelle_by_ID($categories, $id) {

        foreach ($categories as $categorie) {

            if ($categorie->getID() == $id) {
                $libelle = $categorie->getLibelle();
                break;
            }
        }

        return $libelle;
    }

}
