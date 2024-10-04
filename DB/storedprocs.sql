USE `dbchevalersk17`;

-- -----------------------------------------------------
-- Items
-- -----------------------------------------------------
DROP PROCEDURE IF EXISTS `update_stock`;

DELIMITER //
CREATE PROCEDURE `update_stock`(idItem INT, quantite INT)
BEGIN
	DECLARE quantiteItem INT;

    SELECT `Items`.`stock` FROM `Items` WHERE `Items`.`id` = idItem INTO quantiteItem;

	IF (quantite > quantiteItem) THEN 
		UPDATE `Items`
			SET `Items`.`stock` = 0
			WHERE `Items`.`idItem` = idItem;
	ELSE
		UPDATE `Items`
			SET `Items`.`stock` = quantiteItem - quantite
			WHERE `Items`.`id` = idItem;
	END IF;
	
END;
// DELIMITER ;

-- -----------------------------------------------------
-- Joueurs
-- -----------------------------------------------------

-- Add
DROP PROCEDURE IF EXISTS `add_joueur`;

DELIMITER //
CREATE PROCEDURE `add_joueur` (alias VARCHAR(16), nom VARCHAR(16), prenom VARCHAR(16), email VARCHAR(255), motdepasse VARCHAR(128))
BEGIN
    DECLARE mdp_salt CHAR(16);
    DECLARE mdp_hash CHAR(128);

    SELECT SUBSTRING(MD5(RAND()), 1, 16) INTO mdp_salt;
    SELECT SHA2(CONCAT(motdepasse, mdp_salt), 512) INTO mdp_hash;

    START TRANSACTION;
        INSERT INTO `Joueurs` (`alias`, `nom`, `prenom`, `email`, `salt`, `hash`)
        VALUES (alias, nom, prenom, LOWER(email), mdp_salt, mdp_hash);

        INSERT INTO `StatistiqueJoueur` (`idJoueur`, `dateCreation`, `nbAchats`, `itemsInventaire`, `nbConcoctions`, `progressionEnigmes`, `nbEvaluations`, `totalEcusDepense`)
        VALUES (LAST_INSERT_ID(), CURRENT_TIMESTAMP, 0, 0, 0, '', 0, 0);
    COMMIT;
END;

// DELIMITER ;

DROP PROCEDURE IF EXISTS `modify_joueur`;

DELIMITER //
CREATE PROCEDURE `modify_joueur` (idJoueur INT, nom VARCHAR(16), prenom VARCHAR(16), email VARCHAR(255))
BEGIN
	START TRANSACTION;
		UPDATE `joueurs` SET `joueurs`.`nom`=nom where `joueurs`.`id`=idJoueur;
		UPDATE `joueurs` SET `joueurs`.`prenom`=prenom where `joueurs`.`id`=idJoueur;
		UPDATE `joueurs` SET `joueurs`.`email`=email where `joueurs`.`id`=idJoueur;
	COMMIT;
END;
// DELIMITER ;
DROP PROCEDURE IF EXISTS `verify_password`;

DELIMITER //
CREATE PROCEDURE `verify_password` (idJoueur INT, motdepasse VARCHAR(128))
BEGIN
	DECLARE mdp_salt char(16);
	DECLARE mdp_hash char(128);

    SELECT `salt` INTO mdp_salt FROM `Joueurs` WHERE `Joueurs`.`id` = idJoueur;
    SELECT SHA2(CONCAT(motdepasse, mdp_salt), 512) INTO mdp_hash;
    
    IF (mdp_hash = (SELECT `hash` FROM `Joueurs` where `Joueurs`.`id` = idJoueur)) THEN
		SELECT true;
	else
		SELECT false;
	END IF;
END;
// DELIMITER ;

DROP PROCEDURE IF EXISTS `modify_password`;

DELIMITER //
CREATE PROCEDURE `modify_password` (idJoueur INT, motdepasse VARCHAR(128))
BEGIN
	DECLARE mdp_salt char(16);
	SELECT substring(MD5(RAND()), 1, 16) INTO mdp_salt;
	START TRANSACTION;
		UPDATE `joueurs` SET `joueurs`.`salt`=mdp_salt where `joueurs`.`id`=idJoueur;
		UPDATE `joueurs` SET `joueurs`.`hash`=SHA2(CONCAT(motdepasse, mdp_salt), 512) where `joueurs`.`id`=idJoueur;
	COMMIT;
	
END;
// DELIMITER ;

-- Verify
DROP PROCEDURE IF EXISTS `verify_joueur`;

DELIMITER //
CREATE PROCEDURE `verify_joueur` (alias VARCHAR(16), motdepasse VARCHAR(128))
BEGIN
	DECLARE mdp_salt char(16);
	DECLARE mdp_hash char(128);

    SELECT `salt` INTO mdp_salt FROM `Joueurs` WHERE `Joueurs`.`alias` = alias;
    SELECT SHA2(CONCAT(motdepasse, mdp_salt), 512) INTO mdp_hash;
    
    IF (mdp_hash = (SELECT `hash` FROM `joueurs` where `Joueurs`.`alias` = alias)) THEN
		SELECT true;
	ELSE
		SELECT false;
	END IF;
END;
// DELIMITER ;


-- -----------------------------------------------------
-- Panier
-- -----------------------------------------------------

-- Add
DROP PROCEDURE IF EXISTS `add_panier`;

DELIMITER //
CREATE PROCEDURE `add_panier` (idJoueur INT, idItem INT)
BEGIN
	DECLARE quantite_item char(16);

    SELECT `quantite` INTO quantite_item FROM `Panier` WHERE `Panier`.`idJoueur` = idJoueur AND `Panier`.`idItem` = idItem;

	INSERT INTO `Panier` (`idJoueur`, `idItem`, `quantite`) 
    VALUES(idJoueur, idItem, 1) 
	ON DUPLICATE KEY UPDATE `quantite` = quantite_item + 1;
END;
// DELIMITER ;

-- Update
DROP PROCEDURE IF EXISTS `update_panier`;

DELIMITER //
CREATE PROCEDURE `update_panier` (idJoueur INT, idItem INT, quantite INT)
BEGIN
	IF (quantite < 1) THEN
		CALL remove_panier(idJoueur, idItem);
	ELSE
    	UPDATE `Panier`
		SET `Panier`.`quantite` = quantite
		WHERE `Panier`.`idJoueur` = idJoueur
			AND `Panier`.`idItem` = idItem;
    END IF;
END;
// DELIMITER ;

-- Remove
DROP PROCEDURE IF EXISTS `remove_panier`;

DELIMITER //
CREATE PROCEDURE `remove_panier` (idJoueur INT, idItem INT)
BEGIN
	DELETE FROM `Panier` 
	WHERE `Panier`.`idJoueur` = idJoueur
		AND `Panier`.`idItem` = idItem;
END;
// DELIMITER ;

-- Acheter
DROP PROCEDURE IF EXISTS `acheter_panier`;

DELIMITER //
CREATE PROCEDURE `acheter_panier` (idJoueur INT, idItem INT, quantite INT)
BEGIN

	DECLARE nombreItem INT;
	DECLARE prixItem INT;
	SELECT `Inventaire`.`quantite` FROM `Inventaire` WHERE `Inventaire`.`idJoueur` = idJoueur AND `Inventaire`.`idItem` = idItem INTO nombreItem;
	SELECT `Items`.`prix` FROM `Items` WHERE `Items`.`id` = idItem INTO prixItem;
    
	START TRANSACTION;
		IF(isnull(nombreItem)) THEN
			CALL add_inventaire(idJoueur, idItem, quantite);
		ELSE
			CALL add_inventaire(idJoueur, idItem, nombreItem + quantite);
		END IF;
		
		CALL remove_panier(idJoueur, idItem);
        
		UPDATE `Joueurs`
		SET `Joueurs`.`solde` = `Joueurs`.`solde` - (prixItem * quantite)
		WHERE `Joueurs`.`id` = idJoueur;
        
        CALL update_stock(idItem, quantite);
        CALL increment_achats(idJoueur);
        CALL add_totalspent(idJoueur, prixItem, quantite);
	COMMIT;
END; 
// DELIMITER ;

-- -----------------------------------------------------
-- Inventaire
-- -----------------------------------------------------

-- Add
DROP PROCEDURE IF EXISTS `add_inventaire`;

DELIMITER //
CREATE PROCEDURE `add_inventaire` (idJoueur INT, idItem INT, quantity INT)
BEGIN
	INSERT INTO `Inventaire` (`idItem`, `idJoueur`, `quantite`) 
    VALUES(idItem, idJoueur , quantity) 
	ON DUPLICATE KEY UPDATE `quantite` = quantity;
    CALL update_items_inventaire(idJoueur);
END;
// DELIMITER ;

DROP PROCEDURE IF EXISTS `add_inventaireV2`;

DELIMITER //
CREATE PROCEDURE `add_inventaireV2` (idJoueur INT, idItem INT, quantity INT)
BEGIN
	INSERT INTO `Inventaire` (`idItem`, `idJoueur`, `quantite`) 
    VALUES(idItem, idJoueur, quantity) 
	ON DUPLICATE KEY UPDATE `quantite` = `quantite` + quantity;
    CALL update_items_inventaire(idJoueur);
END;
// DELIMITER ;

DROP PROCEDURE IF EXISTS `add_inventaireV3`;

DELIMITER //
CREATE PROCEDURE `add_inventaireV3` (idJoueur INT, idItem INT, quantity INT)
BEGIN
	INSERT INTO `Inventaire` (`idItem`, `idJoueur`, `quantite`) 
    VALUES(idItem, idJoueur , quantity) 
	ON DUPLICATE KEY UPDATE `Inventaire`.`quantite` = `Inventaire`.`quantite` + quantity;
    CALL update_items_inventaire(idJoueur);
END;
// DELIMITER ;

-- Update
DROP PROCEDURE IF EXISTS `update_inventaire`;

DELIMITER //
CREATE PROCEDURE `update_inventaire` (idJoueur INT, idItem INT, quantite INT)
BEGIN
	UPDATE `Inventaire`
	SET `Inventaire`.`quantite` = quantite
	WHERE `Inventaire`.`idJoueur` = idJoueur
		AND `Inventaire`.`idItem` = idItem;
	
    CALL update_items_inventaire(idJoueur);
END;
// DELIMITER ;

-- Remove
DROP PROCEDURE IF EXISTS `remove_inventaire`;

DELIMITER //
CREATE PROCEDURE `remove_inventaire` (idJoueur INT, idItem INT)
BEGIN
	DELETE FROM `Inventaire` 
	WHERE `Inventaire`.`idJoueur` = idJoueur
		AND `Inventaire`.`idItem` = idItem;
        
	CALL update_items_inventaire(idJoueur);
END;
// DELIMITER ;

-- -----------------------------------------------------
-- Armes
-- -----------------------------------------------------

-- Add
DROP PROCEDURE IF EXISTS `add_arme`;

DELIMITER //
CREATE PROCEDURE `add_arme` (nom varchar(30), stock INT, idTypeItem INT, prix INT, photo VARCHAR(2848), efficacite INT, idGenre INT,  descript VARCHAR(400))
BEGIN
	START TRANSACTION;
	INSERT INTO `Items` (`nom`, `stock`, `idType`, `prix`, `photo`) 
	VALUES(nom, stock, idTypeItem, prix, photo);
    
	INSERT INTO `Armes` (`idItem`, `efficacite`, `idGenre`, `description`) 
	VALUES(LAST_INSERT_ID(), efficacite, idGenre, descript);
    COMMIT;
END;
// DELIMITER ;


-- -----------------------------------------------------
-- Armures
-- -----------------------------------------------------

-- Add
DROP PROCEDURE IF EXISTS `add_armure`;

DELIMITER //
CREATE PROCEDURE `add_armure` (nom varchar(30), stock INT, idTypeItem INT, prix INT, photo VARCHAR(2848), matiere VARCHAR(50), idTaille INT)
BEGIN
	START TRANSACTION;
	INSERT INTO `Items` (`nom`, `stock`, `idType`, `prix`, `photo`) 
	VALUES(nom, stock, idTypeItem, prix, photo);
    
	INSERT INTO `Armures` (`idItem`, `matiere`, `idTaille`) 
	VALUES(LAST_INSERT_ID(), matiere, idTaille);
    COMMIT;
END;
// DELIMITER ;


-- -----------------------------------------------------
-- Potions
-- -----------------------------------------------------

-- Add
DROP PROCEDURE IF EXISTS `add_potion`;

DELIMITER //
CREATE PROCEDURE `add_potion` (nom varchar(30), stock INT, idTypeItem INT, prix INT, photo VARCHAR(2848), effet VARCHAR(50), duree INT,  idTypePotion INT)
BEGIN
	IF (prix <= (SELECT `Items`.`prix` FROM `Items` WHERE `Items`.`idType` = 2 ORDER BY `Items`.`prix` LIMIT 1)) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le prix des potions doit être plus grand que celui des éléments';
	END IF;
    
	START TRANSACTION;
	INSERT INTO `Items` (`nom`, `stock`, `idType`, `prix`, `photo`) 
	VALUES(nom, stock, idTypeItem, prix, photo);
    
	INSERT INTO `Potions` (`idItem`, `effet`, `duree`, `idType`) 
	VALUES(LAST_INSERT_ID(), effet, duree, idTypePotion);
    COMMIT;
END;
// DELIMITER ;


-- -----------------------------------------------------
-- Elements
-- -----------------------------------------------------

-- Add
DROP PROCEDURE IF EXISTS `add_element`;

DELIMITER //
CREATE PROCEDURE `add_element` (nom varchar(30), stock INT, idTypeItem INT, prix INT, photo VARCHAR(2848), idTypeElement INT, rarete INT, dangerosite INT)
BEGIN
	IF (prix >= (SELECT `Items`.`prix` FROM `Items` WHERE `Items`.`idType` = 3 ORDER BY `Items`.`prix` LIMIT 1)) THEN
		SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Le prix des éléments doit être plus petit que celui des potions';
	END IF;
    
	START TRANSACTION;
	INSERT INTO `Items` (`nom`, `stock`, `idType`, `prix`, `photo`) 
	VALUES(nom, stock, idTypeItem, prix, photo);
    
	INSERT INTO `Elements` (`idItem`, `idType`, `rarete`, `dangerosite`) 
	VALUES(LAST_INSERT_ID(), idTypeElement, rarete, dangerosite);
    COMMIT;
END;
// DELIMITER ;


-- -----------------------------------------------------
-- Enigmes
-- -----------------------------------------------------

DROP PROCEDURE IF EXISTS `verifier_alchimiste`;

DELIMITER // 
CREATE PROCEDURE `verifier_alchimiste` (idJoueur INT)
BEGIN 
	IF ((SELECT `Joueurs`.`estAlchimiste` FROM `Joueurs` where `Joueurs`.`id` = idJoueur) = 0)
	THEN
		 IF  ((SELECT COUNT(`enigmesJoueurs`.`id`) FROM `enigmesJoueurs`
			INNER JOIN `enigmes` on `enigmesJoueurs`.`idEnigme` = `enigmes`.`id`
			INNER JOIN  `typesEnigmes` on `enigmes`.`idType` = `typesEnigmes`.`id`
			where (`enigmesJoueurs`.`idJoueur` = idJoueur) AND (`enigmesJoueurs`.`estReussi`= 1) AND (`typesEnigmes`.`type` = 'Potion' OR `typesEnigmes`.`type` = 'Élément')) > 2 )
		THEN	
			START TRANSACTION;
				UPDATE `Joueurs` set `joueurs`.`estAlchimiste` = 1 WHERE  `Joueurs`.`id`= idJoueur;
				UPDATE `Joueurs` set `joueurs`.`idNiveau` = 1 WHERE  `Joueurs`.`id`= idJoueur; 
			COMMIT;
	END IF;
    END IF;
END;
// DELIMITER ;

DROP PROCEDURE IF EXISTS `repondre_enigme`;

DELIMITER // 
CREATE PROCEDURE `repondre_enigme` (idJoueur INT, idEnigme INT, estReussi TINYINT(0))
BEGIN 
	DECLARE nbrPoints INT;

    IF( estReussi = 1 )THEN
		SELECT `difficultesEnigmes`.`points` FROM `enigmes`
		INNER JOIN `difficultesEnigmes` on `enigmes`.`idDifficulte` = `difficultesEnigmes`.`id`
		WHERE `enigmes`.`id`= idEnigme INTO nbrPoints;
		
		START TRANSACTION;
            UPDATE `Joueurs` set `Joueurs`.`solde`= `Joueurs`.`solde` + nbrPoints where `Joueurs`.`id` = idJoueur;
		COMMIT;
	END IF;
		START TRANSACTION;    
			INSERT INTO `enigmesJoueurs` (`idJoueur`,`idEnigme`,`estReussi`) VALUES (idJoueur,idEnigme,estReussi);
		COMMIT;
        
	call verifier_alchimiste(idJoueur);
    CALL update_progression_enigmes(idJoueur);
END;
// DELIMITER ;

DROP PROCEDURE IF EXISTS `random_enigme`;

DELIMITER // 
CREATE PROCEDURE `random_enigme` (idDifficulte INT, idJoueur INT)
BEGIN 
	SELECT `enigmes`.`id` FROM `enigmes`
    WHERE `enigmes`.`id`NOT IN ( SELECT `enigmesJoueurs`.`idEnigme` FROM `enigmesJoueurs` where `enigmesJoueurs`.`idJoueur` = idJoueur and `enigmesJoueurs`.`estReussi` = 1) and 
		`enigmes`.`idDifficulte`= idDifficulte ORDER BY RAND() LIMIT 1;
END;
// DELIMITER ;


DROP PROCEDURE IF EXISTS `random_enigmeAleatoire`;

DELIMITER // 
CREATE PROCEDURE `random_enigmeAleatoire` ( idJoueur INT)
BEGIN 
	SELECT `enigmes`.`id` FROM `enigmes`
    WHERE `enigmes`.`id`NOT IN ( SELECT `enigmesJoueurs`.`idEnigme` FROM `enigmesJoueurs` where `enigmesJoueurs`.`idJoueur` = idJoueur and `enigmesJoueurs`.`estReussi` = 1) 
	ORDER BY RAND() LIMIT 1;
END;
// DELIMITER ;

-- -----------------------------------------------------
-- ElementPotion
-- -----------------------------------------------------

DROP PROCEDURE IF EXISTS `concocter_potion`;

DELIMITER // 
CREATE PROCEDURE `concocter_potion` (idPotion INT, idJoueur INT, quantite INT)
BEGIN 
	DECLARE idItem1 INT;
    DECLARE idItem2 INT;
	DECLARE quantiteItem1 INT;
    DECLARE quantiteItem2 INT;
    
    IF((SELECT `Joueurs`.`estAlchimiste` from `Joueurs` where `Joueurs`.`id`= idJoueur) =1)THEN
		
  
    SELECT `elementPotion`.`idElement` from `elementPotion` where `elementPotion`.`idPotion`= idPotion LIMIT 1 INTO idItem1;
	SELECT `elementPotion`.`idElement` from `elementPotion` where `elementPotion`.`idPotion`= idPotion AND `elementPotion`.`idElement`!= idItem1 LIMIT 1 INTO idItem2;
     
	SELECT `Inventaire`.`quantite` FROM `Inventaire` where `Inventaire`.`idItem` =idItem1 AND `Inventaire`.`idJoueur`= idJoueur INTO quantiteitem1;
    SELECT `Inventaire`.`quantite` FROM `Inventaire` where `Inventaire`.`idItem` =idItem2 AND `Inventaire`.`idJoueur`= idJoueur INTO quantiteitem2;
    
    
     
     IF( isnull(quantiteItem1) = false AND quantiteItem1 - quantite >-1)
     THEN
		 IF( isnull(quantiteItem2) = false AND quantiteItem2 - quantite > -1 )
         THEN
			START TRANSACTION;
				UPDATE `Inventaire` SET `Inventaire`.`quantite`= `Inventaire`.`quantite`- quantite where `Inventaire`.`idItem` = idItem1 AND `Inventaire`.`idJoueur`= idJoueur;
                UPDATE `Inventaire` SET `Inventaire`.`quantite`= `Inventaire`.`quantite`- quantite where `Inventaire`.`idItem` = idItem2 AND `Inventaire`.`idJoueur`= idJoueur;
                call add_inventaireV3(idJoueur, idPotion, quantite);
                DELETE FROM `Inventaire` where `Inventaire`.`idJoueur`=idJoueur and `Inventaire`.`idItem` =idItem1 AND`Inventaire`.`quantite` <1;
				DELETE FROM `Inventaire` where `Inventaire`.`idJoueur`=idJoueur and `Inventaire`.`idItem` =idItem2 AND `Inventaire`.`quantite` <1;
                call add_potionJoueur(idPotion, idJoueur, quantite);
			COMMIT;

            call concocter_verif_niveau(idJoueur);
            CALL increment_concoctions(idJoueur, quantite);
            
END IF; END IF; END IF;
	
END;
// DELIMITER ;

DROP PROCEDURE IF EXISTS `concocter_verif_niveau`;

DELIMITER // 
CREATE PROCEDURE `concocter_verif_niveau` (idJoueur INT)
BEGIN 
	IF( SELECT COUNT(`Joueurs`.`id`) FROM `Joueurs` 
		INNER JOIN `NiveauxJoueurs` on `Joueurs`.`idNiveau` = `NiveauxJoueurs`.`id` 
		where `NiveauxJoueurs`.`niveau` = 'Débutant' and `Joueurs`.`id` = idJoueur > 0)
        THEN	
			IF( (SELECT SUM(`potionsJoueurs`.`quantite`) FROM `potionsJoueurs`
				INNER JOIN `potions`on `potionsJoueurs`.`idPotion` = `potions`.`idItem`
                INNER JOIN `typesPotions` on `potions`.`idType`=`typesPotions`.`id`
                WHERE `typesPotions`.`type`= 'Attaque' AND `potionsJoueurs`.`idJoueur`= idJoueur) >2 
                OR
                (SELECT SUM(`potionsJoueurs`.`quantite`) FROM `potionsJoueurs`
				INNER JOIN `potions`on `potionsJoueurs`.`idPotion` = `potions`.`idItem`
                INNER JOIN `typesPotions` on `potions`.`idType`=`typesPotions`.`id`
                WHERE `typesPotions`.`type`= 'Défense' AND `potionsJoueurs`.`idJoueur`= idJoueur) > 4)
                THEN
                    START TRANSACTION;
						Update `joueurs` SET `idNiveau`=
                        (SELECT `id` from `niveauxJoueurs`where `niveau` = 'Intermédiaire') where `joueurs`.`id`=idJoueur ;
					COMMIT;
			END IF; END IF;
	IF( (SELECT SUM(`potionsJoueurs`.`quantite`) FROM `potionsJoueurs`
		INNER JOIN `potions`on `potionsJoueurs`.`idPotion` = `potions`.`idItem`
		INNER JOIN `typesPotions` on `potions`.`idType`=`typesPotions`.`id`
		WHERE `typesPotions`.`type`= 'Attaque' AND `potionsJoueurs`.`idJoueur`= idJoueur) >4
		OR
		(SELECT SUM(`potionsJoueurs`.`quantite`) FROM `potionsJoueurs`
		INNER JOIN `potions`on `potionsJoueurs`.`idPotion` = `potions`.`idItem`
		INNER JOIN `typesPotions` on `potions`.`idType`=`typesPotions`.`id`
		WHERE `typesPotions`.`type`= 'Défense' AND `potionsJoueurs`.`idJoueur`= idJoueur) > 9)
		THEN
			START TRANSACTION;
				Update `joueurs` SET `idNiveau`= (SELECT `id` from `niveauxJoueurs`where `niveau` = 'Expert')
				where `joueurs`.`id`= idJoueur;
			COMMIT;
                 
		 END IF;
END;
// DELIMITER ;

-- -----------------------------------------------------
-- PotionJoueur
-- -----------------------------------------------------

DROP PROCEDURE IF EXISTS `add_potionJoueur`;

DELIMITER // 
CREATE PROCEDURE `add_potionJoueur` (idPotion INT,idJoueur INT, quantity INT)
BEGIN 
	IF((SELECT COUNT(`potionsJoueurs`.`idPotion`) FROM `potionsJoueurs` 
		WHERE `potionsJoueurs`.`idPotion` = idPotion and `potionsJoueurs`.`idJoueur`= idJoueur)=0) 
        THEN
			INSERT INTO `potionsJoueurs` (`idPotion`, `idJoueur`, `quantite`) 
			VALUES(idPotion, idJoueur , quantity);
	else 
		UPDATE `potionsJoueurs` SET `potionsJoueurs`.`quantite` = `potionsJoueurs`.`quantite` + quantity 
        WHERE `potionsJoueurs`.`idPotion` = idPotion and `potionsJoueurs`.`idJoueur`= idJoueur;
        
	END IF;
END;
// DELIMITER ;

-- -----------------------------------------------------
-- InsertInventaire
-- -----------------------------------------------------

DROP PROCEDURE IF EXISTS `insertPlayer`;

DELIMITER // 
CREATE PROCEDURE `insertPlayer` (idPlayer int)
BEGIN 


	Insert into `inventaire` VALUES(33,idPlayer,6);
    Insert into `inventaire` VALUES(34,idPlayer,6);
    Insert into `inventaire` VALUES(35,idPlayer,6);
    Insert into `inventaire` VALUES(36,idPlayer,6);
	Insert into `inventaire` VALUES(37,idPlayer,6);
    Insert into `inventaire` VALUES(38,idPlayer,6);
    Insert into `inventaire` VALUES(39,idPlayer,6);
    Insert into `inventaire` VALUES(40,idPlayer,6);
    Insert into `inventaire` VALUES(41,idPlayer,6);
    Insert into `inventaire` VALUES(42,idPlayer,6);
    Insert into `inventaire` VALUES(43,idPlayer,6);
    Insert into `inventaire` VALUES(44,idPlayer,6);
    Insert into `inventaire` VALUES(45,idPlayer,6);
    Insert into `inventaire` VALUES(46,idPlayer,6);
    Insert into `inventaire` VALUES(47,idPlayer,6);
  COMMIT;
    
    END;
// DELIMITER ;

-- -----------------------------------------------------
-- Évaluations
-- -----------------------------------------------------

DROP PROCEDURE IF EXISTS `add_evaluation`;

DELIMITER //
CREATE PROCEDURE `add_evaluation` (idItem INT, idJoueur INT, commentaire VARCHAR(1000), note INT)
BEGIN 
		INSERT INTO `Evaluations` (`idItem`, `idJoueur`, `commentaire`, `note`) 
		VALUES( idItem, idJoueur , commentaire, note);
        CALL increment_evaluations(idJoueur);
END;
// DELIMITER ;

DROP PROCEDURE IF EXISTS `update_evaluation`;

DELIMITER // 
CREATE PROCEDURE `update_evaluation` (idItem INT, idJoueur INT, commentaire VARCHAR(1000), note INT)
BEGIN 
		UPDATE `evaluations`
        SET `evaluations`.`commentaire` = commentaire
        WHERE `evaluations`.`idItem` = idItem and `evaluations`.`idJoueur`= idJoueur;
		
        UPDATE `evaluations` 
		SET `evaluations`.`note` = note
        WHERE `evaluations`.`idItem` = idItem and `evaluations`.`idJoueur`= idJoueur;
END;
// DELIMITER ;


DROP PROCEDURE IF EXISTS `remove_evaluation`;

DELIMITER // 
CREATE PROCEDURE `remove_evaluation` (idItem INT, idJoueur INT)
BEGIN 
	DELETE FROM `Evaluations` 
	WHERE `Evaluations`.`idJoueur` = idJoueur
		AND `Evaluations`.`idItem` = idItem;
	CALL decrement_evaluations(idJoueur);
END;
// DELIMITER ;

-- -----------------------------------------------------
-- StatistiqueJoueur
-- -----------------------------------------------------

-- NbAchats
DROP PROCEDURE IF EXISTS `increment_achats`;

DELIMITER //
CREATE PROCEDURE `increment_achats` (idJoueur INT)
BEGIN
    UPDATE `StatistiqueJoueur`
    SET `nbAchats` = `nbAchats` + 1
    WHERE `idJoueur` = idJoueur;
END;

// DELIMITER ;

-- TotalEcusDepense
DROP PROCEDURE IF EXISTS `add_totalspent`;

DELIMITER //
CREATE PROCEDURE `add_totalspent` (idJoueur INT, prixItem INT, quantite INT)
BEGIN
	UPDATE `StatistiqueJoueur`
	SET `totalEcusDepense` = `totalEcusDepense` + (prixItem * quantite)
	WHERE `idJoueur` = idJoueur;
END;

// DELIMITER ;

-- ItemsInventaire
DROP PROCEDURE IF EXISTS `update_items_inventaire`;

DELIMITER //
CREATE PROCEDURE `update_items_inventaire` (idJoueur INT)
BEGIN
    DECLARE totalItems INT;
    
    SELECT SUM(`quantite`) INTO totalItems
    FROM `Inventaire`
    WHERE `Inventaire`.`idJoueur` = idJoueur;
    
    UPDATE `StatistiqueJoueur`
    SET `itemsInventaire` = totalItems
    WHERE `StatistiqueJoueur`.`idJoueur` = idJoueur;
END;

// DELIMITER ;

-- NbConcoctions
DROP PROCEDURE IF EXISTS `increment_concoctions`;

DELIMITER //
CREATE PROCEDURE `increment_concoctions` (idJoueur INT, quantite INT)
BEGIN
    UPDATE `StatistiqueJoueur`
    SET `nbConcoctions` = `nbConcoctions` + quantite
    WHERE `StatistiqueJoueur`.`idJoueur` = idJoueur;
END;

// DELIMITER ;

-- ProgressionEnigmes
DROP PROCEDURE IF EXISTS `update_progression_enigmes`;

DELIMITER //
CREATE PROCEDURE `update_progression_enigmes`(IN idJoueur INT)
BEGIN
    DECLARE facile_progress FLOAT DEFAULT 0;
    DECLARE moyenne_progress FLOAT DEFAULT 0;
    DECLARE difficile_progress FLOAT DEFAULT 0;
    DECLARE total_progress FLOAT DEFAULT 0;
    DECLARE total_facile INT DEFAULT 0;
    DECLARE total_moyenne INT DEFAULT 0;
    DECLARE total_difficile INT DEFAULT 0;

    SELECT COUNT(*) INTO total_facile FROM Enigmes WHERE idDifficulte = 0;
    SELECT COUNT(*) INTO total_moyenne FROM Enigmes WHERE idDifficulte = 1;
    SELECT COUNT(*) INTO total_difficile FROM Enigmes WHERE idDifficulte = 2;

    IF total_facile > 0 THEN
        SELECT 
            (COUNT(*) / total_facile) * 100
        INTO facile_progress
        FROM EnigmesJoueurs
        WHERE `EnigmesJoueurs`.`idJoueur` = idJoueur AND estReussi = 1 AND idEnigme IN (SELECT id FROM Enigmes WHERE idDifficulte = 0);
    END IF;

    IF total_moyenne > 0 THEN
        SELECT 
            (COUNT(*) / total_moyenne) * 100
        INTO moyenne_progress
        FROM EnigmesJoueurs
        WHERE `EnigmesJoueurs`.`idJoueur` = idJoueur AND estReussi = 1 AND idEnigme IN (SELECT id FROM Enigmes WHERE idDifficulte = 1);
    END IF;

    IF total_difficile > 0 THEN
        SELECT 
            (COUNT(*) / total_difficile) * 100
        INTO difficile_progress
        FROM EnigmesJoueurs
        WHERE `EnigmesJoueurs`.`idJoueur` = idJoueur AND estReussi = 1 AND idEnigme IN (SELECT id FROM Enigmes WHERE idDifficulte = 2);
    END IF;

    SET total_progress = (facile_progress + moyenne_progress + difficile_progress) / 3;

    UPDATE StatistiqueJoueur
    SET `progressionEnigmes` = CONCAT('Facile: ', ROUND(facile_progress, 2), '% | Moyenne: ', ROUND(moyenne_progress, 2), '% | Difficile: ', ROUND(difficile_progress, 2), '% | Total: ', ROUND(total_progress, 2), '%')
    WHERE `StatistiqueJoueur`.`idJoueur` = idJoueur;
END;

// DELIMITER ;

-- NbEvaluations
DROP PROCEDURE IF EXISTS `increment_evaluations`;

DELIMITER // 
CREATE PROCEDURE `increment_evaluations` (idJoueur INT)
BEGIN 
    UPDATE `StatistiqueJoueur`
    SET `nbEvaluations` = `nbEvaluations` + 1
    WHERE `StatistiqueJoueur`.`idJoueur` = idJoueur;
END;

// DELIMITER ;

DROP PROCEDURE IF EXISTS `decrement_evaluations`;

DELIMITER // 
CREATE PROCEDURE `decrement_evaluations` (idJoueur INT)
BEGIN 
    UPDATE `StatistiqueJoueur`
    SET `nbEvaluations` = `nbEvaluations` - 1
    WHERE `StatistiqueJoueur`.`idJoueur` = idJoueur;
END;

// DELIMITER ;

-- -----------------------------------------------------
-- Évaluations
-- -----------------------------------------------------

DROP PROCEDURE IF EXISTS `add_evaluation`;

DELIMITER //
CREATE PROCEDURE `add_evaluation` (idItem INT, idJoueur INT, commentaire VARCHAR(1000), note INT)
BEGIN 
		INSERT INTO `Evaluations` (`idItem`, `idJoueur`, `commentaire`, `note`) 
		VALUES( idItem, idJoueur , commentaire, note);
        CALL increment_evaluations(idJoueur);
END;
// DELIMITER ;

DROP PROCEDURE IF EXISTS `update_evaluation`;

DELIMITER // 
CREATE PROCEDURE `update_evaluation` (idItem INT, idJoueur INT, commentaire VARCHAR(1000), note INT)
BEGIN 
		UPDATE `evaluations`
        SET `evaluations`.`commentaire` = commentaire
        WHERE `evaluations`.`idItem` = idItem and `evaluations`.`idJoueur`= idJoueur;
		
        UPDATE `evaluations` 
		SET `evaluations`.`note` = note
        WHERE `evaluations`.`idItem` = idItem and `evaluations`.`idJoueur`= idJoueur;
END;
// DELIMITER ;


DROP PROCEDURE IF EXISTS `remove_evaluation`;

DELIMITER // 
CREATE PROCEDURE `remove_evaluation` (idItem INT, idJoueur INT)
BEGIN 
	DELETE FROM `Evaluations` 
	WHERE `Evaluations`.`idJoueur` = idJoueur
		AND `Evaluations`.`idItem` = idItem;
	CALL decrement_evaluations(idJoueur);
END;
// DELIMITER ;
