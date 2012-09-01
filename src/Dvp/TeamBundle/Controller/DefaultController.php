<?php

namespace Dvp\TeamBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller {
    public function indexAction($section) {
        /// Get page information. 
        $repoSection = $this->getDoctrine()
                            ->getManager()
                            ->getRepository('DvpTeamBundle:Section'); 
    
        $section = $repoSection->findOneBySlug($section); 
    
        // Bad URL. Redirect to the first page. 
        if(! $section) {
            $section = $repoSection->findAll(); 
            return $this->redirect($this->generateUrl('DvpTeamBundle_homepage', array('section' => $section[0]->getSlug())));
        }
        
        /// Get page members (via the categories). 
        $categories = $this->getDoctrine()
                           ->getManager()
                           ->getRepository('DvpTeamBundle:Category')
                           ->findAll(); 
        
        /// Done. 
        return $this->render('DvpTeamBundle:Default:index.html.twig', array('section' => $section, 'categories' => $categories));
    }
    
    // URL: /import/localhost/dvp/root/root
    
    /** Original dump **/
/*
-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Sep 01, 2012 at 02:59 PM
-- Server version: 5.0.84
-- PHP Version: 5.3.14

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- Database: `qt`
--

-- --------------------------------------------------------

--
-- Table structure for table `certif`
--

CREATE TABLE IF NOT EXISTS `certif` (
  `id` bigint(20) NOT NULL auto_increment,
  `nom` text,
  `image` text NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `certif`
--

INSERT INTO `certif` (`id`, `nom`, `image`) VALUES
(1, 'Qt Essentials 1.0', 'logo_qt_developer.png'),
(2, 'Qualified in C++ with Qt', 'logo_qt_developer.png'),
(3, 'Advanced Widget UI', 'logo_qt_developer.png');

-- --------------------------------------------------------

--
-- Table structure for table `membre`
--

CREATE TABLE IF NOT EXISTS `membre` (
  `id` bigint(20) NOT NULL auto_increment,
  `nom` text,
  `prenom` text,
  `pseudo` text,
  `resp` tinyint(1) default NULL,
  `redac` tinyint(1) default NULL,
  `ancien` tinyint(1) default NULL,
  `email` text,
  `valide` tinyint(1) NOT NULL,
  `pyside` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=408668 ;

--
-- Dumping data for table `membre`
--

INSERT INTO `membre` (`id`, `nom`, `prenom`, `pseudo`, `resp`, `redac`, `ancien`, `email`, `valide`, `pyside`) VALUES
(33090, 'Verdavaine', 'Yan', 'yan', 0, 1, 0, 'yan.verdavaine@redaction-developpez.com', 1, 0),
(44506, 'Courtois', 'Jonathan', 'johnlamericain', 1, 1, 0, 'jonathan.courtois@redaction-developpez.com', 1, 0),
(57426, 'Poulain', 'Benjamin', 'Ikipou', 0, 0, 0, 'ikipou@gmail.com', 1, 0),
(63689, 'Charles', 'Pierre-François', 'charlespf', 0, 0, 0, 'charlespf38@hotmail.com', 1, 0),
(67052, 'Mestan', 'Alp', 'Alp', 0, 1, 0, 'alp@redaction-developpez.com', 1, 0),
(72448, 'Yoann', 'Moreau', 'YoniBlond', 0, 1, 0, 'moreau.yo@gmail.com', 1, 0),
(108609, 'Loïc', 'Leguay', 'Loic31', 0, 0, 0, 'loic_leguay@yahoo.fr', 1, 0),
(126136, 'Jaffré', 'François', 'superjaja', 0, 1, 0, 'francois.jaffre@redaction-developpez.com', 1, 0),
(135545, 'Gentil', 'Charles-Élie', 'Jiyuu', 0, 1, 0, 'gentilcharlie@yahoo.fr', 1, 1),
(161714, 'Decombe', 'Etienne', 'Gulish', 0, 0, 0, 'decombe.etienne@gmail.com', 1, 0),
(169573, 'Sorant', 'Jérémy', 'Niak74', 0, 0, 0, 'jsorant@gmail.com', 1, 0),
(193107, 'Bonnier', 'Cédric', 'myzu69', 0, 0, 0, 'myzu69@gmail.com', 1, 0),
(240267, 'Laurent', 'Alexandre', 'LittleWhite', 0, 1, 0, 'thedograge@hotmail.fr', 1, 0),
(254882, 'Cuvelier', 'Thibaut', 'dourouc05', 1, 1, 0, 'tcuvelier@redaction-developpez.com', 1, 1),
(268393, 'Belz', 'Guillaume', 'gbdivers', 0, 1, 0, 'guillaume.belz@free.fr', 1, 0),
(290340, 'Deladda', 'Jérôme', 'Attrox', 0, 0, 0, 'jeromedeledda@gmail.com', 1, 0),
(292096, 'du Verdier', 'Louis', 'Amnell', 0, 1, 0, 'zemassacreur@yahoo.fr', 1, 0),
(333286, 'Renault', 'Florent', 'GreatTux', 0, 0, 0, 'renault.florent@gmail.com', 1, 0),
(341511, 'Hafidi', 'Abdelhafid', 'std_abdel', 0, 0, 0, 'abdelite.algebra@gmail.com', 1, 0),
(345570, 'Genet', 'Francis', 'frifri59', 0, 0, 0, 'francis.genet@supinfo.com', 1, 0),
(352080, 'Meyer', 'Vincent', '0x4e84', 0, 0, 0, 'viinceent.meeyeer@gmail.com', 1, 1),
(360054, 'Rigal', 'Pierre-Nicolas', 'sysedit', 0, 0, 0, 'qt-contrib@p-n-r.com', 1, 0),
(378458, 'Halgand', 'Florentin', 'Architekth', 0, 0, 0, 'architekth@gmail.com', 1, 0),
(408667, 'Di Clemente', 'Emmanuel', 'manudiclemente', 0, 0, 0, 'manudiclemente@gmail.fr', 1, 0);

-- --------------------------------------------------------

--
-- Table structure for table `membre_certif`
--

CREATE TABLE IF NOT EXISTS `membre_certif` (
  `id` bigint(20) NOT NULL auto_increment,
  `membre` bigint(20) default NULL,
  `certif` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `membre_idx` (`membre`),
  KEY `certif_idx` (`certif`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=5 ;

--
-- Dumping data for table `membre_certif`
--

INSERT INTO `membre_certif` (`id`, `membre`, `certif`) VALUES
(1, 44506, 1),
(2, 360054, 1),
(3, 44506, 2),
(4, 44506, 3);

-- --------------------------------------------------------

--
-- Table structure for table `membre_rang`
--

CREATE TABLE IF NOT EXISTS `membre_rang` (
  `id` bigint(20) NOT NULL auto_increment,
  `membre` bigint(20) default NULL,
  `rang` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `membre_idx` (`membre`),
  KEY `rang_idx` (`rang`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=100 ;

--
-- Dumping data for table `membre_rang`
--

INSERT INTO `membre_rang` (`id`, `membre`, `rang`) VALUES
(8, 44506, 1),
(9, 44506, 2),
(10, 44506, 4),
(11, 44506, 5),
(12, 44506, 7),
(13, 44506, 8),
(14, 44506, 9),
(15, 254882, 1),
(16, 254882, 2),
(17, 254882, 3),
(18, 254882, 4),
(19, 254882, 5),
(20, 254882, 6),
(21, 254882, 7),
(22, 254882, 8),
(23, 254882, 9),
(24, 33090, 2),
(25, 33090, 4),
(26, 67052, 3),
(27, 67052, 4),
(29, 126136, 4),
(30, 292096, 3),
(31, 292096, 7),
(32, 292096, 9),
(33, 169573, 4),
(34, 193107, 7),
(35, 290340, 9),
(36, 341511, 9),
(37, 378458, 3),
(38, 345570, 8),
(39, 345570, 4),
(47, 333286, 7),
(48, 333286, 9),
(59, 268393, 2),
(60, 268393, 3),
(61, 268393, 5),
(62, 268393, 7),
(63, 268393, 8),
(66, 240267, 4),
(67, 57426, 3),
(68, 57426, 4),
(69, 161714, 4),
(70, 360054, 4),
(71, 33090, 12),
(72, 44506, 15),
(73, 193107, 12),
(74, 193107, 17),
(75, 240267, 16),
(76, 240267, 13),
(77, 268393, 13),
(78, 341511, 17),
(79, 360054, 14),
(80, 135545, 3),
(81, 135545, 4),
(82, 72448, 2),
(83, 72448, 4),
(84, 254882, 18),
(85, 254882, 19),
(86, 292096, 18),
(87, 408667, 9),
(88, 108609, 9),
(89, 352080, 3),
(90, 352080, 4),
(91, 352080, 7),
(92, 352080, 8),
(93, 352080, 16),
(94, 352080, 18),
(95, 352080, 19),
(98, 63689, 7),
(99, 135545, 2);

-- --------------------------------------------------------

--
-- Table structure for table `membre_site`
--

CREATE TABLE IF NOT EXISTS `membre_site` (
  `id` bigint(20) NOT NULL auto_increment,
  `url` text,
  `name` text,
  `membre` bigint(20) default NULL,
  PRIMARY KEY  (`id`),
  KEY `membre_idx` (`membre`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `membre_site`
--

INSERT INTO `membre_site` (`id`, `url`, `name`, `membre`) VALUES
(1, 'http://tcuvelier.developpez.com', 'Articles divers et variés', 254882),
(2, 'http://blog.developpez.com/dourouc05/', 'Blog', 254882),
(3, 'http://www.jcourtois.fr/', 'Site personnel', 44506),
(4, 'http://jonathan-courtois.developpez.com/', 'Site personnel sur Developpez.com', 44506),
(5, 'http://blog.developpez.com/jonathan.courtois/', 'Blog', 44506),
(6, 'http://alp.developpez.com/', 'Articles', 67052),
(7, 'http://yan-verdavaine.developpez.com/', 'Articles', 33090),
(8, 'http://fhalgand.developpez.com/', 'Articles', 378458),
(11, 'http://gbelz.developpez.com/', 'Site Web', 268393),
(12, 'http://alexandre-laurent.developpez.com/', 'Site Web', 240267),
(13, 'http://www.Ikipou.com/', 'Site Web', 57426),
(14, 'http://blog.developpez.com/jiyuu', 'Blog', 135545),
(15, 'http://ceg.developpez.com/', 'Site Web', 135545),
(16, 'http://ymoreau.users.sourceforge.net ', 'Site Web', 72448);

-- --------------------------------------------------------

--
-- Table structure for table `rang`
--

CREATE TABLE IF NOT EXISTS `rang` (
  `id` bigint(20) NOT NULL auto_increment,
  `nom` text,
  `useraddable` tinyint(1) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=20 ;

--
-- Dumping data for table `rang`
--

INSERT INTO `rang` (`id`, `nom`, `useraddable`) VALUES
(1, 'Responsable de rubrique', 0),
(2, 'Modérateur du forum', 1),
(3, 'Rédacteur d''articles', 1),
(4, 'Rédacteur pour la FAQ', 1),
(5, 'Rédacteur du blog (newser)', 1),
(6, 'Rédacteur du wiki', 0),
(7, 'Traducteur des Qt Quaterly', 1),
(8, 'Traducteur des Qt Labs', 1),
(9, 'Traducteur de la doc', 1),
(10, 'Responsable des Qt Quarterly', 0),
(11, 'Responsable des Qt Labs', 0),
(12, 'Relecteur pour la FAQ', 0),
(13, 'Testeur pour la FAQ', 0),
(14, 'Coordinateur adjoint FAQ', 0),
(15, 'Coordinateur FAQ', 0),
(16, 'Traducteur pour la FAQ', 1),
(17, 'Assurance qualité pour la FAQ', 0),
(18, 'Traducteur du Qt Developer Network', 1),
(19, 'Traducteur pour divers projets', 1);

--
-- Constraints for dumped tables
--

--
-- Constraints for table `membre_certif`
--
ALTER TABLE `membre_certif`
  ADD CONSTRAINT `membre_certif_certif_certif_id` FOREIGN KEY (`certif`) REFERENCES `certif` (`id`),
  ADD CONSTRAINT `membre_certif_membre_membre_id` FOREIGN KEY (`membre`) REFERENCES `membre` (`id`);

--
-- Constraints for table `membre_rang`
--
ALTER TABLE `membre_rang`
  ADD CONSTRAINT `membre_rang_membre_membre_id` FOREIGN KEY (`membre`) REFERENCES `membre` (`id`),
  ADD CONSTRAINT `membre_rang_rang_rang_id` FOREIGN KEY (`rang`) REFERENCES `rang` (`id`);

--
-- Constraints for table `membre_site`
--
ALTER TABLE `membre_site`
  ADD CONSTRAINT `membre_site_membre_membre_id` FOREIGN KEY (`membre`) REFERENCES `membre` (`id`);
*/
    public function importAction() {
        return new Response();
    }
}
