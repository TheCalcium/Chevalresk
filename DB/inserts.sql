USE `dbchevalersk17` ;



-- -----------------------------------------------------
-- NiveauxJoueurs
-- -----------------------------------------------------
INSERT INTO `NiveauxJoueurs` (`id`, `niveau`)
VALUES (0, 'Aucun');

INSERT INTO `NiveauxJoueurs` (`id`, `niveau`)
VALUES (1, 'Débutant');

INSERT INTO `NiveauxJoueurs` (`id`, `niveau`)
VALUES (2, 'Intermédiaire');

INSERT INTO `NiveauxJoueurs` (`id`, `niveau`)
VALUES (3, 'Expert');


-- -----------------------------------------------------
-- Joueurs
-- -----------------------------------------------------
CALL add_joueur("Gemini", "Thomas", "Bradford", "thomasbradford@email.com", "password");
UPDATE Joueurs
SET idNiveau = 1, estAlchimiste = 1, solde = 5000
WHERE alias = "Gemini";

CALL add_joueur("Grok", "Victor", "Dennis", "victordennis@email.com", "password");
UPDATE Joueurs
SET estAdmin = 1
WHERE alias = "Grok";

CALL add_joueur("Bard", "Pierre", "Riel", "pierreriel@email.com", "password");
CALL add_joueur("Mistral", "Julie", "Briard", "juliebriard@email.com", "password");
CALL add_joueur("Midjourney", "Kevin", "Saint-Pierre", "kevinsaintpierre@email.com", "password");

-- donne sprint 2
CALL add_joueur("Pro", "William", "Gagne", "wpro@email.com", "password");
UPDATE Joueurs
SET idNiveau = 3, estAlchimiste = 1, solde = 5000
WHERE alias = "Pro";

CALL add_joueur("Ben", "Talking", "Ben", "ben@email.com", "password");
UPDATE Joueurs
SET idNiveau = 3, estAlchimiste = 1, solde = 5000
WHERE alias = "Ben";

CALL add_joueur("Whisper", "Gaspasd", "Lavallee", "ghosty@email.com", "password");
UPDATE Joueurs
SET idNiveau = 2, estAlchimiste = 1, solde = 5000
WHERE alias = "Whisper";

CALL add_joueur("Joker", "Bernard", "Droler", "joker@email.com", "password");
UPDATE Joueurs
SET idNiveau = 2, estAlchimiste = 1, solde = 5000
WHERE alias = "Joker";

CALL add_joueur("Arthur", "Lancelot", "Chevalier", "Knight@email.com", "password");
UPDATE Joueurs
SET idNiveau = 1, estAlchimiste = 1, solde = 5000
WHERE alias = "Arthur";

CALL add_joueur("GirlyFlower", "Clara", "Secter", "clara@email.com", "password");
UPDATE Joueurs
SET idNiveau = 1, estAlchimiste = 1, solde = 5000
WHERE alias = "GirlyFlower";


-- -----------------------------------------------------
-- TypesItems
-- -----------------------------------------------------
INSERT INTO `TypesItems` (`id`, `type`)
VALUES (0, 'Arme');

INSERT INTO `TypesItems` (`id`, `type`)
VALUES (1, 'Armure');

INSERT INTO `TypesItems` (`id`, `type`)
VALUES (2, 'Élément');

INSERT INTO `TypesItems` (`id`, `type`)
VALUES (3, 'Potion');


-- -----------------------------------------------------
-- GenresArmes
-- -----------------------------------------------------
INSERT INTO `GenresArmes` (`id`, `genre`)
VALUES (0, 'Une main');

INSERT INTO `GenresArmes` (`id`, `genre`)
VALUES (1, 'Deux mains');


-- -----------------------------------------------------
-- TaillesArmures
-- -----------------------------------------------------
INSERT INTO `TaillesArmures` (`id`, `taille`)
VALUES (0, 'Petit');

INSERT INTO `TaillesArmures` (`id`, `taille`)
VALUES (1, 'Moyen');

INSERT INTO `TaillesArmures` (`id`, `taille`)
VALUES (2, 'Grand');


-- -----------------------------------------------------
-- TypesPotions
-- -----------------------------------------------------
INSERT INTO `TypesPotions` (`id`, `type`)
VALUES (0, 'Attaque');

INSERT INTO `TypesPotions` (`id`, `type`)
VALUES (1, 'Défense');


-- -----------------------------------------------------
-- TypesElements
-- -----------------------------------------------------
INSERT INTO `TypesElements` (`id`, `type`)
VALUES (0, 'Air');

INSERT INTO `TypesElements` (`id`, `type`)
VALUES (1, 'Animal');

INSERT INTO `TypesElements` (`id`, `type`)
VALUES (2, 'Eau');

INSERT INTO `TypesElements` (`id`, `type`)
VALUES (3, 'Feu');

INSERT INTO `TypesElements` (`id`, `type`)
VALUES (4, 'Plante');

INSERT INTO `TypesElements` (`id`, `type`)
VALUES (5, 'Poison');

INSERT INTO `TypesElements` (`id`, `type`)
VALUES (6, 'Terre');

INSERT INTO `TypesElements` (`id`, `type`)
VALUES (7, 'Sang');

-- -----------------------------------------------------
-- TypesEnigmes
-- -----------------------------------------------------

INSERT INTO `TypesEnigmes` (`id`, `type`)
VALUES (0, 'Élément');

INSERT INTO `TypesEnigmes` (`id`, `type`)
VALUES (1, 'Potion');

INSERT INTO `TypesEnigmes` (`id`, `type`)
VALUES (2, 'Arme');

INSERT INTO `TypesEnigmes` (`id`, `type`)
VALUES (3, 'Armure');

-- -----------------------------------------------------
-- DifficultesEnigmes
-- -----------------------------------------------------

INSERT INTO `DifficultesEnigmes` (`id`, `difficulte`,`points`)
VALUES (0, 'facile',50);

INSERT INTO `DifficultesEnigmes` (`id`, `difficulte`,`points`)
VALUES (1, 'moyen',100);

INSERT INTO `DifficultesEnigmes` (`id`, `difficulte`,`points`)
VALUES (2, 'difficile',200);

-- -----------------------------------------------------
-- Armes
-- -----------------------------------------------------
CALL add_arme('Arc', 42, 0, 200, 'arc.png', 4, 1, 'Cet arc simple mais robuste est fabriqué à partir du bois le plus résistant de la forêt de Chevalresk. Malgré sa simplicité, il offre une précision remarquable et est idéal pour les débutants apprenant l’art du tir à l’arc.');
CALL add_arme('Bâton en bois', 39, 0, 150, 'baton_bois.png', 4, 1, 'Ce bâton, taillé à partir des arbres anciens de la forêt de Chevalresk, est aussi simple qu’efficace. Il offre une portée décente et peut être utilisé pour repousser les ennemis ou pour explorer les environnements difficiles.');
CALL add_arme('Bâton maléfique', 18, 0, 600, 'baton_emeraude.png', 6, 1, 'Ce bâton sinistre, imprégné de l’énergie sombre des forces maléfiques de Chevalresk, est redouté par tous. Il dégage une aura effrayante et a le pouvoir d’invoquer des créatures des ténèbres pour aider son porteur.');
CALL add_arme('Bâton de feu', 7, 0, 1200, 'baton_rubis.png', 9, 1, 'Ce bâton enflammé, forgé dans les volcans de Chevalresk, brûle d’une énergie ardente. Il peut lancer des boules de feu dévastatrices et illuminer les endroits les plus sombres, faisant de son porteur une force à ne pas sous-estimer.');
CALL add_arme('Bâton de tempêtes', 13, 0, 950, 'baton_saphir.png', 7, 1, 'Ce bâton puissant, chargé de l’énergie tumultueuse des tempêtes, est capable de déchaîner des vents violents et des éclairs dévastateurs. Son porteur peut invoquer la fureur des éléments, faisant de ce bâton une arme redoutable.');
CALL add_arme('Bâton électrique', 34, 0, 350, 'baton_topaz.png', 5, 1, 'Un instrument de puissance et de précision, ce bâton décharge un éclair dévastateur à chaque coup, paralysant les ennemis avec une force électrique brutale. Idéal pour les combattants qui préfèrent garder leurs adversaires à distance.');
CALL add_arme('Bouclier en bois', 45, 0, 200, 'bouclier_bois.png', 4, 1, 'Un bouclier robuste et fiable, taillé dans le chêne le plus résistant. Il offre une protection solide tout en conservant une légèreté surprenante, idéal pour les guerriers qui valorisent la défense et l’agilité.');
CALL add_arme('Bouclier en fer', 27, 0, 500, 'bouclier_fer.png', 6, 0, 'Forgé dans le fer le plus pur, ce bouclier offre une défense impénétrable contre les attaques les plus féroces. Son poids substantiel est un témoignage de sa solidité, le choix parfait pour les guerriers qui ne reculent devant rien.');
CALL add_arme('Couteau', 36, 0, 100, 'couteau.png', 2, 0, 'Un outil de précision, forgé avec le plus fin des aciers. Sa lame aiguisée permet des attaques rapides et discrètes, le choix idéal pour les assassins qui préfèrent la furtivité et la vitesse');
CALL add_arme('Épée en bois', 52, 0, 50, 'epee_bois.png', 1, 0, 'Une épée légère et maniable, sculptée à partir du bois le plus résistant. Bien qu’elle ne soit pas aussi tranchante que l’acier, elle offre une excellente option pour l’entraînement ou pour les guerriers qui préfèrent la vitesse et l’agilité.');
CALL add_arme('Épée en fer', 34, 0, 300, 'epee_fer.png', 5, 0, 'Une épée solide et tranchante, forgée dans le fer le plus pur. Sa lame robuste permet des attaques puissantes, le choix parfait pour les guerriers qui cherchent à dominer le champ de bataille.');
CALL add_arme('Épée en acier', 22, 0, 850, 'epee_acier.png', 7, 0, 'Cette épée robuste et fiable est forgée à partir d’acier de la plus haute qualité. Sa lame tranchante et son équilibre parfait en font une arme redoutable sur le champ de bataille. Elle est le choix idéal pour les guerriers qui apprécient la force et la durabilité.');
CALL add_arme('Épée sacrée', 6, 0, 1350, 'epee_sacree.png', 9, 0, 'Forgée dans les flammes de la vertu, cette épée est un symbole de justice et de courage. Sa lame brille d’une lumière divine, capable de repousser les forces du mal. Elle est idéale pour les chevaliers qui cherchent à défendre l’innocence et à répandre la paix.');
CALL add_arme('Hache', 35, 0, 250, 'hache.png', 4, 0, ' Forgée dans les flammes de la montagne, cette épée en acier est aussi tranchante que le froid de l’hiver. Sa lame étincelante inspire la peur dans le cœur des ennemis, promettant une fin rapide et décisive à tout conflit.');
CALL add_arme('Livre d’apprenti', 41, 0, 200, 'livre_apprenti.png', 4, 0, 'Ce livre ancien, rempli de connaissances oubliées et de mystères non résolus, est un trésor pour tout apprenti magicien. En le lisant, l’apprenti peut apprendre des sorts puissants et des techniques de magie qui peuvent transformer le cours d’une bataille.');
CALL add_arme('Livre magique', 28, 0, 450, 'livre_magique.png', 6, 0, 'Ce grimoire ancien déborde de sorts puissants, permettant aux joueurs de déchaîner des attaques magiques dévastatrices sur leurs adversaires. Chaque page tournée révèle un nouveau sort, rendant chaque combat unique et imprévisible.');
CALL add_arme('Livre des maîtres', 11, 0, 1000, 'livre_maitre.png', 8, 0, 'Un grimoire ancien dans Chevalresk, renfermant des sorts puissants et secrets. Ce livre permet à son porteur de maîtriser des magies inconnues, augmentant considérablement sa puissance.');
CALL add_arme('Baguette magique', 33, 0, 300, 'baguette_bois.png', 5, 0, 'La Baguette magique, un artefact ancien de Chevalresk, est connue pour sa capacité à canaliser des énergies mystiques. Elle permet à son porteur de lancer des sorts dévastateurs, transformant le cours de la bataille en un instant.');
CALL add_arme('Marteau', 40, 0, 150, 'marteau.png', 3, 0, 'Le marteau est une arme de destruction massive. Avec une tête en pierre et un manche en chêne robuste, ce marteau peut écraser les ennemis avec une force dévastatrice. Sa présence sur le champ de bataille inspire la peur et le respect.');
CALL add_arme('Pelle', 47, 0, 100, 'pelle.png', 2, 1, 'La pelle est une arme polyvalente. Elle peut être utilisée pour creuser des pièges pour les ennemis ou pour les frapper avec une force surprenante. Sa simplicité cache une utilité inattendue sur le champ de bataille.');
CALL add_arme('Pioche', 36, 0, 150, 'pioche.png', 3, 1, 'La pioche est une arme de mêlée robuste et polyvalente dans Chevalresk. Elle est idéale pour les combats rapprochés et peut également être utilisée pour extraire des ressources précieuses des roches dures.');
CALL add_arme('Torche', 43, 0, 100, 'torche.png', 2, 0, 'La torche est une arme de lumière et de chaleur dans Chevalresk. Elle éclaire les endroits les plus sombres et peut enflammer les ennemis avec un feu ardent. Sa lueur vacillante est un symbole d’espoir pour tous les chevaliers.');

-- -----------------------------------------------------
-- Armures
-- -----------------------------------------------------
CALL add_armure('Bottes en cuir', 49, 1, 150, 'bottes_cuir.png', 'Cuir', 1);
CALL add_armure('Bottes en fer', 24, 1, 450, 'bottes_fer.png', 'Fer', 0);
CALL add_armure('Casque en cuir', 38, 1, 150, 'casque_cuir.png', 'Cuir', 2);
CALL add_armure('Casque en fer', 22, 1, 500, 'casque_fer.png', 'Fer', 1);
CALL add_armure('Casque en acier', 13, 1, 700, 'casque_acier.png', 'Acier', 1);
CALL add_armure('Ceinture en cuir', 52, 1, 100, 'ceinture_cuir.png', 'Cuir', 1);
CALL add_armure('Chapeau magique', 31, 1, 350, 'chapeau_magique.png', 'Tissu', 0);
CALL add_armure('Cuirasse en cuir', 44, 1, 250, 'cuirasse_cuir.png', 'Cuir', 0);
CALL add_armure('Cuirasse en bois', 37, 1, 400, 'cuirasse_bois.png', 'Bois', 2);
CALL add_armure('Cuirasse en fer', 26, 1, 750, 'cuirasse_fer.png', 'Fer', 1);

-- -----------------------------------------------------
-- Elements
-- -----------------------------------------------------
CALL add_element('Charbon', 65, 2, 10, 'charbon.png', 6, 1, 1);
CALL add_element('Crâne', 27, 2, 30, 'crane.png', 7, 4, 3);
CALL add_element('Cristal', 13, 2, 60, 'cristal.png', 6, 6, 5);
CALL add_element('Cuir', 46, 2, 20, 'cuir.png', 1, 3, 1);
CALL add_element('Diamand', 9, 2, 70, 'diamand.png', 6, 7, 4);
CALL add_element('Laine', 58, 2, 20, 'laine.png', 1, 2, 1);
CALL add_element('Obsidienne', 22, 2, 40, 'obsidienne.png', 3, 5, 3);
CALL add_element('Oeil de dragon', 6, 2, 80, 'oeil_dragon.png', 3, 8, 7);
CALL add_element('Oeuf', 28, 2, 40, 'oeuf.png', 1, 4, 5);
CALL add_element('Oeuf de dragon', 3, 2, 100, 'oeuf_dragon.png', 0, 9, 8);
CALL add_element('Os', 52, 2, 10, 'os.png', 7, 2, 2);
CALL add_element('Perle', 18, 2, 60, 'perle.png', 2, 7, 4);
CALL add_element('Plume', 61, 2, 10, 'plume.png', 0, 1, 1);
CALL add_element('Slime', 32, 2, 50, 'slime.png', 5, 5, 6);
CALL add_element('Viande Putrifié', 49, 2, 20, 'viande_putrefiee.png', 7, 2, 5);

-- -----------------------------------------------------
-- Potions
-- -----------------------------------------------------
CALL add_potion('Potion d’acide', 26, 3, 450, 'potion_acide.png', 'Inflige des dégâts continus à l’ennemi.', 15, 0);
CALL add_potion('Potion d’agilité', 43, 3, 200, 'potion_agilite.png', 'Augmente la hauteur des sauts du joueur.', 60, 1);
CALL add_potion('Potion explosive', 17, 3, 500, 'potion_explosive.png', 'Provoque une puissante explosion à l’impact.', 1, 0);
CALL add_potion('Potion de force', 26, 3, 350, 'potion_force.png', 'Augmente les dégats  du joueur.', 15, 1);
CALL add_potion('Potion d’invisibilité', 3, 3, 1500, 'potion_invisibilite.png', 'Rend le joueur temporairement invisible.', 45, 1);
CALL add_potion('Potion de mana', 53, 3, 150, 'potion_mana.png', 'Restaure une quantité significative de mana.', 1, 1);
CALL add_potion('Potion de poison', 23, 3, 300, 'potion_poison.png', 'Affaiblit la défense de l’ennemi.', 30, 0);
CALL add_potion('Potion de lenteur', 36, 3, 250, 'potion_lenteur.png', 'Réduit la vitesse de déplacement de l’ennemi', 20, 0);
CALL add_potion('Potion de vie', 61, 3, 200, 'potion_vie.png', 'Restaure une quantité significative de vie.', 1, 1);
CALL add_potion('Potion de vitesse', 42, 3, 250, 'potion_vitesse.png', 'Augmente la vitesse de déplacement du joueur.', 60, 1);

-- -----------------------------------------------------
-- Panier
-- -----------------------------------------------------
CALL add_panier(1, 2);
CALL update_panier(1, 2, 2);
CALL add_panier(1, 7);
CALL update_panier(1, 7, 1);
CALL add_panier(1, 20);
CALL update_panier(1, 20, 3);
CALL add_panier(1, 28);
CALL update_panier(1, 28, 2);
CALL add_panier(1, 35);
CALL update_panier(1, 35, 5);
CALL add_panier(1, 46);
CALL update_panier(1, 46, 11);
CALL add_panier(2, 12);
CALL update_panier(2, 12, 1);
CALL add_panier(2, 34);
CALL update_panier(2, 34, 2);

-- -----------------------------------------------------
-- Inventaire
-- -----------------------------------------------------
CALL add_inventaire(1, 2, 0);
CALL update_inventaire(1, 2, 2);
CALL add_inventaire(1, 7, 0);
CALL update_inventaire(1, 7, 1);
CALL add_inventaire(1, 20, 0);
CALL update_inventaire(1, 20, 4);
CALL add_inventaire(1, 28, 0);
CALL update_inventaire(1, 28, 8);

CALL insertPlayer(6);
CALL insertPlayer(7);
CALL insertPlayer(8);
CALL insertPlayer(9);
CALL insertPlayer(10);
CALL insertPlayer(11);




-- -----------------------------------------------------
-- Enigmes
-- -----------------------------------------------------
-- Enigmes Type Arme
INSERT INTO `Enigmes` (`question`, `iddifficulte`,`idType`) VALUES ('Quel est l’arme la plus légerte ?',0,2);
-- Reponses
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (1,'Hache de guerre',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (1,'Épée à deux mains',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (1,'Dague',1);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (1,'Bouclier',0);
--
INSERT INTO `Enigmes` (`question`, `iddifficulte`,`idType`) VALUES ('Quel est l’arme la plus coûteuse dans Chevalresk ?',1,2);
-- Reponses
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (2,'Épée sacrée',1);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (2,'Bâton de tempêtes',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (2,'Hache',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (2,'Arc',0);
--
INSERT INTO `Enigmes` (`question`, `iddifficulte`,`idType`) VALUES ('Quel est l’arme la plus utilisé au moyen âge ?',2,2);
-- Reponses
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (3,'Épée',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (3,'Lance',1);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (3,'Arc',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (3,'Épée à deux mains',0);
--
-- Enigmes Type Element
INSERT INTO `Enigmes` (`question`, `iddifficulte`,`idType`) VALUES ('Quel est l’élément le moins rare ?',0,0);
-- Reponses
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (4,'Obsidienne',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (4,'Os',1);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (4,'Slime',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (4,'Cuir',0);
--
INSERT INTO `Enigmes` (`question`, `iddifficulte`,`idType`) VALUES ('Quel est l’élément le plus dangereux ?',1,0);
-- Reponses
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (5,'Diamant',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (5,'Viande putrifié',1);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (5,'Perle',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (5,'Crâne',0);
--
INSERT INTO `Enigmes` (`question`, `iddifficulte`,`idType`) VALUES ('Quel est l’élément de type feu ?',2,0);
-- Reponses
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (6,'Cuir',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (6,'Charbon',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (6,'Oeuf de dragon',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (6,'Obsidienne',1);
--
-- Enigmes Type Armure
INSERT INTO `Enigmes` (`question`, `iddifficulte`,`idType`) VALUES ('Quel est l’armure pour magicien ?',0,3);
-- Reponses
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (7,'Chapeau Magique',1);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (7,'Casque en acier',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (7,'Cuirasse en cuir',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (7,'Bottes en fer',0);
--
INSERT INTO `Enigmes` (`question`, `iddifficulte`,`idType`) VALUES ('Quel est l’armure avec la plus petite taille ?',1,3);
-- Reponses
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (8,'Casque en acier',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (8,'Botte en fer',1);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (8,'Cuirasse en fer',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (8,'Cuirasse en bois',0);
--
INSERT INTO `Enigmes` (`question`, `iddifficulte`,`idType`) VALUES ('Quel est l’armure la plus chère ?',2,3);
-- Reponses
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (9,'Botte en cuir',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (9,'Casque en cuir',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (9,'Cuirasse en bois',1);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (9,'Ceinture en cuir',0);
--
-- Enigme Type Potion
INSERT INTO `Enigmes` (`question`, `iddifficulte`,`idType`) VALUES ('Quel est la potion de défense ?',0,1);
-- Reponses
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (10,'Potion de lenteur',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (10,'Potion d’invisibilité',1);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (10,'Potion d’acide',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (10,'Potion explosive',0);
--
INSERT INTO `Enigmes` (`question`, `iddifficulte`,`idType`) VALUES ('Quel potion augmente la vitesse de déplacement du joueur ?',0,1);
-- Reponses
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (11,'Potion de force',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (11,'Potion de force',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (11,'Potion de vitesse',1);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (11,'Potion d’agilité',0);
--
INSERT INTO `Enigmes` (`question`, `iddifficulte`,`idType`) VALUES ('Quel est la potion la plus chère ?',0,1);
-- Reponses
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (12,'Potion explosive',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (12,'Potion de vie',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (12,'Potion de mana',0);
INSERT INTO `Reponses` (`idQuestion`, `texte`,`isTrue`) VALUES (12,'Potion d’invisibilité',1);
--

-- -----------------------------------------------------
-- EnigmesJoueurs
-- -----------------------------------------------------
-- INSERT INTO `enigmesJoueurs` (`idJoueur`,`idEnigme`,`estReussi`)
-- VALUES (2, 11,1);
-- INSERT INTO `enigmesJoueurs` (`idJoueur`,`idEnigme`,`estReussi`)
-- VALUES (2, 4,1);
-- INSERT INTO `enigmesJoueurs` (`idJoueur`,`idEnigme`,`estReussi`)
-- VALUES (2, 5,0);
-- INSERT INTO `enigmesJoueurs` (`idJoueur`,`idEnigme`,`estReussi`)
-- VALUES (2, 7,1);
-- INSERT INTO `enigmesJoueurs` (`idJoueur`,`idEnigme`,`estReussi`)
-- VALUES (2, 8,0);
-- INSERT INTO `enigmesJoueurs` (`idJoueur`,`idEnigme`,`estReussi`)
-- VALUES (2, 2,1);

-- -----------------------------------------------------
-- ElemPotion
-- -----------------------------------------------------
Insert INTO `elementPotion` VALUES(56,34);
Insert INTO `elementPotion` VALUES(56,36);

Insert INTO `elementPotion` VALUES(50,33);
Insert INTO `elementPotion` VALUES(50,40);

Insert INTO `elementPotion` VALUES(53,35);
Insert INTO `elementPotion` VALUES(53,38);

Insert INTO `elementPotion` VALUES(54,43);
Insert INTO `elementPotion` VALUES(54,47);

Insert INTO `elementPotion` VALUES(57,42);
Insert INTO `elementPotion` VALUES(57,44);

-- -----------------------------------------------------
-- Evalutations
-- -----------------------------------------------------
CALL add_evaluation(1, 1, 'This in-game gear is a testament to the creativity of the game developers. Its aesthetics are pleasing, adding a touch of flair to the player’s avatar. The functionality it provides is remarkable, enhancing the player’s capabilities in a balanced manner. It’s not just about power, but also about strategy and skill, making the gameplay more immersive and challenging. The gear is adaptable, fitting seamlessly into various game scenarios and strategies. It’s clear that a lot of thought has gone into its design and implementation. Overall, this gear significantly enriches the gaming experience, making it more engaging and rewarding. A must-have for any player.', 5);
CALL add_evaluation(1, 2, 'This piece of in-game gear is truly a game-changer. Its design is visually stunning, with intricate details that show the developers’ dedication to creating an immersive gaming experience. The stats are well-balanced, providing a fair boost without making the game too easy. It’s versatile, suitable for various play styles and situations. The unique abilities it grants add an extra layer of strategy, encouraging players to think creatively. It’s not just about the power it holds, but also the way it seamlessly integrates into the gameplay. This gear is a testament to the beauty of game design, enhancing enjoyment without compromising challenge. Truly a must-have for any player.', 4);
CALL add_evaluation(1, 3, 'This in-game gear is a marvel of virtual craftsmanship. Its aesthetic appeal is undeniable, with a design that is both eye-catching and fitting within the game’s world. The balance it brings to gameplay is commendable, offering a significant yet fair advantage. Its versatility is impressive, catering to a variety of play styles and scenarios. The unique abilities it bestows upon the player add a strategic depth to the game, pushing players to devise innovative tactics. More than just a tool, this gear enhances the overall gaming experience, striking a perfect balance between challenge and enjoyment. It’s an essential addition to any player’s arsenal.', 3);
CALL add_evaluation(1, 4, 'This gear is truly a game-changer. It’s well-balanced and adds a new dimension to the gameplay. The design is intricate and the attention to detail is commendable. It’s not just about the power it brings, but also the strategy it involves.', 2);
CALL add_evaluation(1, 5, 'I’m really impressed with this piece of gear. It’s not just about the stats, but the way it changes the dynamics of the game. It’s a testament to the developers’ creativity and understanding of the game mechanics.', 1);
CALL add_evaluation(2, 1, 'This gear is a perfect blend of aesthetics and functionality. It’s not just visually appealing, but also adds a significant advantage in the game. It’s definitely worth the grind.', 5);
CALL add_evaluation(2, 2, 'This piece of gear is truly a standout in the game. Its design is sleek and the attention to detail is commendable. The developers have done a fantastic job in balancing its attributes, making it a versatile choice for players with different strategies. The special abilities it grants are not overpowering, yet they add a significant edge to the gameplay. It’s a bit challenging to acquire, but the effort is well worth it. Overall, this gear enhances the gaming experience, making each encounter more engaging and strategic. It’s a must-have for any serious player.', 4);
CALL add_evaluation(2, 3, 'Decent quality, serves its purpose', 3);
CALL add_evaluation(2, 4, 'The introduction of this gear has made the game more engaging. It’s not just about brute force, but also about the tactics and strategy it involves. It’s a great addition to the game.', 2);
CALL add_evaluation(2, 5, 'This gear has added a new layer of complexity to the game. It’s not just about equipping the most powerful gear, but also about understanding its nuances and using it effectively.', 1);
CALL add_evaluation(3, 1, 'This piece of in-game gear is truly a game-changer. Its design is sleek and visually appealing, making it stand out in the inventory. The attention to detail is commendable, and it’s clear that the developers put a lot of thought into its creation. The gear’s functionality is impressive, providing a significant boost to the player’s abilities. It’s versatile, suitable for a variety of situations and play styles. The balance between power and usability is well-maintained, preventing it from being overpowered. Overall, this gear enhances the gaming experience, making each session more engaging and enjoyable. A must-have for any serious player.', 5);
CALL add_evaluation(3, 2, 'I’m really enjoying this piece of gear. It adds a whole new dimension to the gameplay. The special abilities are not too overpowering but still make a significant difference in battles. Highly recommended for any player.', 3);
CALL add_evaluation(3, 3, 'This gear is truly a game-changer. It has a unique design and the attention to detail is impressive. The stats are well-balanced, making it suitable for various play styles. It’s definitely worth the grind.', 4);
CALL add_evaluation(3, 4, 'The aesthetics of this gear are top-notch. It’s not just about the stats, it’s about looking good on the battlefield too. This gear delivers on both fronts. A must-have for any serious player.', 3);
CALL add_evaluation(3, 5, 'This is one of those gears that you don’t know you need until you have it. It has significantly improved my gaming experience. The added abilities give me an edge in close encounters. Two thumbs up!', 2);
CALL add_evaluation(4, 1, 'Top-notch product, worth every penny', 5);
CALL add_evaluation(4, 2, 'This piece of gear is a real game-changer. Its design is intricate and the craftsmanship is evident in every detail. The balance between its attributes is well thought out, making it adaptable to various strategies. The unique abilities it provides are subtle yet impactful, adding a new layer of depth to the gameplay. Acquiring it might be a challenge, but the reward is definitely worth the effort. Overall, this gear significantly enhances the gaming experience, making each battle more immersive and tactical. It’s an essential addition to any player’s arsenal.', 4);
CALL add_evaluation(4, 3, 'Excellent craftsmanship, exceeded expectations', 5);
CALL add_evaluation(4, 4, 'This piece of gear is an excellent addition to the game. Its design is sophisticated and the level of detail is truly impressive. The balance of its attributes is well-executed, making it a versatile choice for players with varying tactics. The unique abilities it offers are not overly dominant, but they add a meaningful impact to the gameplay. While it may be a bit challenging to acquire, the reward is undeniably worth the effort. Overall, this gear significantly enriches the gaming experience, making each battle more thrilling and strategic. It’s a must-have for any dedicated player', 5);
CALL add_evaluation(4, 5, 'This gear is a standout addition to the game. Its design is intricate, and the balance of its attributes makes it adaptable to various strategies. The unique abilities it provides add a new layer of depth to the gameplay. Acquiring it might be a challenge, but the reward is definitely worth the effort. Overall, this gear enhances the gaming experience, making each encounter more engaging and strategic.', 4);
CALL add_evaluation(5, 1, 'This piece of gear is truly impressive. The developers have done a fantastic job balancing its power and usability. The special abilities it grants are not overpowering, yet they add a significant edge to the gameplay. It’s a bit challenging to acquire, but the effort is well worth it. Overall, this gear significantly enhances the gaming experience.', 5);
CALL add_evaluation(5, 2, 'The aesthetics of this gear are top-notch. It’s not just about the stats, it’s about looking good on the battlefield too. This gear delivers on both fronts. A must-have for any serious player.', 4);
CALL add_evaluation(5, 3, 'This is one of those gears that you don’t know you need until you have it. It has significantly improved my gaming experience. The added abilities give me an edge in close encounters. Two thumbs up!', 3);
CALL add_evaluation(5, 4, 'Below average quality, disappointed', 2);
CALL add_evaluation(5, 5, 'This gear is fantastic! It’s versatile and fits well with my character build. The developers did a great job in balancing its power and usability. It’s not easy to acquire, but it’s definitely worth the effort.', 5);
CALL add_evaluation(6, 1, 'This gear is a standout addition to the game. Its design is intricate, and the balance of its attributes makes it adaptable to various strategies. The unique abilities it provides add a new layer of depth to the gameplay. Acquiring it might be a challenge, but the reward is definitely worth the effort. Overall, this gear enhances', 5);
CALL add_evaluation(6, 2, 'This piece of gear is truly impressive. The developers have done a fantastic job balancing its power and usability. The special abilities it grants are not overpowering, yet they add a significant edge to the gameplay. It’s a bit challenging to acquire, but the effort is well worth it. Overall, this gear significantly enhances the gaming experience.', 4);
CALL add_evaluation(6, 3, 'The aesthetics of this gear are top-notch. It’s not just about the stats, it’s about looking good on the battlefield too. This gear delivers on both fronts. A must-have for any serious player.', 3);
CALL add_evaluation(6, 4, 'This is one of those gears that you don’t know you need until you have it. It has significantly improved my gaming experience. The added abilities give me an edge in close encounters. Two thumbs up!', 2);
CALL add_evaluation(6, 5, 'It works. could be better', 3);
CALL add_evaluation(7, 1, 'This piece of gear is truly a game-changer. Its design is sleek and it fits perfectly into the game’s aesthetic. The stats it provides are balanced, making it a versatile choice for any player. It’s clear that a lot of thought went into its creation, and it shows in every detail. It’s not just about the power it gives, but also the way it enhances the overall gaming experience.', 1);
CALL add_evaluation(7, 2, 'I’m really impressed with this gear. It’s not just about the boost it gives to my character, but also the way it changes the gameplay. It adds a new layer of strategy and makes every encounter more interesting. The developers did a great job integrating it into the game world. It feels like a natural part of the environment, not just an add-on.', 2);
CALL add_evaluation(7, 3, 'This gear is a great addition to the game. It’s well-crafted and offers a unique set of abilities that can turn the tide of any battle. It’s not overpowered, but it gives just the right amount of edge to keep things interesting. Plus, it looks amazing. The attention to detail is commendable. It’s clear that the developers put a lot of effort into making it fit seamlessly into the game.', 3);
CALL add_evaluation(7, 4, 'I’ve been playing this game for a while now, and this gear is one of the best I’ve come across. It’s not just the stats that make it great, but also the way it changes the gameplay. It adds a new dimension to the game and makes every encounter feel fresh and exciting. It’s a testament to the creativity of the developers', 2);
CALL add_evaluation(7, 5, 'This gear is a standout piece in the game. It’s not just powerful, but also beautifully designed. It adds depth to the gameplay and makes every battle more engaging. It’s clear that the developers put a lot of thought into its creation. It’s not just a tool for combat, but also a piece of the game’s world. It’s a great example of how gear can enhance the gaming experience.', 1);
CALL add_evaluation(8, 1, 'This gear is a fantastic addition to the game. It’s not just about the stats, but also the way it changes the gameplay. It adds a new layer of strategy and makes every encounter more thrilling. The developers did a great job integrating it into the game world. It feels like a natural part of the environment, not just an add-on.', 5);
CALL add_evaluation(8, 2, 'I’m really impressed with this piece of gear. It’s well-crafted and offers a unique set of abilities that can turn the tide of any battle. It’s not overpowered, but it gives just the right amount of edge to keep things interesting. Plus, it looks amazing. The attention to detail is commendable. It’s clear that the developers put a lot of effort into making it fit seamlessly into the game.', 4);
CALL add_evaluation(8, 3, 'This gear is truly a game-changer. Its design is sleek and it fits perfectly into the game’s aesthetic. The stats it provides are balanced, making it a versatile choice for any player. It’s clear that a lot of thought went into its creation, and it shows in every detail. It’s not just about the power it gives, but also the way it enhances the overall gaming experience.', 3);
CALL add_evaluation(8, 4, 'I’ve been playing this game for a while now, and this gear is one of the best I’ve come across. It’s not just the stats that make it great, but also the way it changes the gameplay. It adds a new dimension to the game and makes every encounter feel fresh and exciting. It’s a testament to the creativity of the developers.', 2);
CALL add_evaluation(8, 5, 'This gear is a standout piece in the game. It’s not just powerful, but also beautifully designed. It adds depth to the gameplay and makes every battle more engaging. It’s clear that the developers put a lot of thought into its creation. It’s not just a tool for combat, but also a piece of the game’s world. It’s a great example of how gear can enhance the gaming experience.', 1);
CALL add_evaluation(9, 1, 'This gear is a remarkable addition to the game. It’s not just about the stats, but also the way it alters the gameplay. It introduces a new layer of strategy and makes every encounter more exciting. The developers did an excellent job integrating it into the game world. It feels like a natural part of the environment, not just an add-on.', 5);
CALL add_evaluation(9, 2, 'I’m really impressed with this piece of gear. It’s well-crafted and offers a unique set of abilities that can turn the tide of any battle. It’s not overpowered, but it gives just the right amount of edge to keep things interesting. Plus, it looks fantastic. The attention to detail is commendable. It’s clear that the developers put a lot of effort into making it fit seamlessly into the game.', 4);
CALL add_evaluation(9, 3, 'This gear is truly a game-changer. Its design is sleek and it fits perfectly into the game’s aesthetic. The stats it provides are balanced, making it a versatile choice for any player. It’s clear that a lot of thought went into its creation, and it shows in every detail. It’s not just about the power it gives, but also the way it enhances the overall gaming experience.', 3);
CALL add_evaluation(9, 4, 'I’ve been playing this game for a while now, and this gear is one of the best I’ve come across. It’s not just the stats that make it great, but also the way it changes the gameplay. It adds a new dimension to the game and makes every encounter feel fresh and exciting. It’s a testament to the creativity of the developers.', 2);
CALL add_evaluation(9, 5, 'This gear is a standout piece in the game. It’s not just powerful, but also beautifully designed. It adds depth to the gameplay and makes every battle more engaging. It’s clear that the developers put a lot of thought into its creation. It’s not just a tool for combat, but also a piece of the game’s world. It’s a great example of how gear can enhance the gaming experience.', 1);

