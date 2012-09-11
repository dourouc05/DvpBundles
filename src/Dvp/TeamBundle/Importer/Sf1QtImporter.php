<?php 

namespace Dvp\TeamBundle\Importer;

use Dvp\TeamBundle\Entity\Member; 
use Dvp\TeamBundle\Entity\Section; 

class Sf1QtImporter extends Sf1Importer {
    protected function getBaseUrlImages() {
        return 'http://qt.developpez.com/images/equipe/'; 
    }
    
    protected function getDefaultSection() {
        return 'qt';
    }
    
    protected function importSections() {
        $sections = array(); 
        
        $qtText = <<<EOD
<p class="presentation">
	Une petite équipe sympathique présente pour vous aider et qui essaie de contribuer à l'évolution de vos connaissances dans le domaine de la programmation avec Qt. Nous avons la vocation d'échange dans la simplicité et l'amitié, tout en respectant les consignes du site qui a la gentillesse d'héberger <a href="http://www.developpez.net/forums/f376/c-cpp/bibliotheques/qt/">nos forums</a> et nos modestes moyens (tels que la <a href="http://qt.developpez.com/faq/">FAQ</a>, les <a href="http://qt.developpez.com/tutoriels/">tutoriels</a>, les <a href="http://qt-quarterly.developpez.com/">traductions des Qt Quarterly</a>, les <a href="http://qt-labs.developpez.com/">traductions des Qt Labs</a>, les <a href="http://qt-devnet.developpez.com/">traductions du Qt Developer Network</a>, les <a href="http://qt.developpez.com/outils/">outils</a>, les <a href="http://qt.developpez.com/livres/">critiques de livres</a> et le <a href="http://blog.developpez.com/recap/qt">blog</a>), témoins de notre volonté d'échange dans une ambiance de franche amitié.
</p>
EOD;
        $pyqtText = <<<EOD
<p class="presentation">
	Une petite équipe sympathique présente pour vous aider et qui essaie de contribuer à l'évolution de vos connaissances dans le domaine de la programmation avec Qt et Python (PyQt et PySide principalement). Nous avons la vocation d'échange dans la simplicité et l'amitié, tout en respectant les consignes du site qui a la gentillesse d'héberger <a href="http://www.developpez.net/forums/f172/autres-langages/python-zope/gui/pyside-pyqt/">nos forums</a> et nos modestes moyens (tels que la <a href="http://pyqt.developpez.com/faq/">FAQ</a>, les <a href="http://pyt.developpez.com/tutoriels/">cours et tutoriels</a>, les <a href="http://qt-quarterly.developpez.com/">traductions des Qt Quarterly</a>, les <a href="http://qt-labs.developpez.com/">traductions des Qt Labs</a>, les <a href="http://qt-devnet.developpez.com/">traductions du Qt Developer Network</a>, les <a href="http://pyqt.developpez.com/livres/">critiques de livres</a>), témoins de notre volonté d'échange dans une ambiance de franche amitié.
</p> 
EOD;
        
        $sections['qt'] = new Section(); 
        $sections['qt']->setName('Qt')
                       ->setSlug('qt')
                       ->setGabId(65)
                       ->setImage('http://qt.developpez.com/images/equipe/logos/logo_equipe_qt.png')
                       ->setText($qtText);
        $this->em->persist($sections['qt']);
        
        $sections['pyqt'] = new Section(); 
        $sections['pyqt']->setName('PyQt et PySide')
                         ->setSlug('pyqt')
                         ->setGabId(102)
                         ->setImage('http://qt.developpez.com/images/equipe/logos/logo_equipe_qt_python.png')
                         ->setText($pyqtText);
        $this->em->persist($sections['pyqt']);
        
        return $sections; 
    }
    
    protected function finishMemberSections(array $pdoMember, Member $member, array $sections) {
        if((bool) $pdoMember['pyside']) {
            $member->addSection($sections['pyqt']);
        }
    }
}