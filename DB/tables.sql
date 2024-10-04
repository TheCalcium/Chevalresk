-- -----------------------------------------------------
-- Schema dbchevalersk17
-- -----------------------------------------------------
CREATE SCHEMA IF NOT EXISTS `dbchevalersk17` DEFAULT CHARACTER SET utf8mb4 ;
USE `dbchevalersk17` ;

DROP TABLE IF EXISTS `dbchevalersk17`.`StatistiqueJoueur` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`PotionsJoueurs` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`EnigmesJoueurs` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`Reponses` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`ElementPotion` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`Enigmes` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`DifficultesEnigmes` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`TypesEnigmes` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`Evaluations` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`Inventaire` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`Panier` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`Demandes` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`PotionsJoueurs` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`Joueurs` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`NiveauxJoueurs` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`Armes` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`GenresArmes` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`Armures` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`TaillesArmures` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`Elements` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`TypesElements` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`Potions` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`TypesPotions` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`Items` ;
DROP TABLE IF EXISTS `dbchevalersk17`.`TypesItems` ;




-- -----------------------------------------------------
-- Table `dbchevalersk17`.`TypesItems`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`TypesItems` (
  `id` INT NOT NULL,
  `type` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`Items`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`Items` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `nom` VARCHAR(30) NOT NULL,
  `stock` INT NOT NULL,
  `idType` INT NULL DEFAULT NULL,
  `prix` INT NOT NULL,
  `photo` VARCHAR(2848) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_items_typesItems`
    FOREIGN KEY (`idType`)
    REFERENCES `dbchevalersk17`.`TypesItems` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`GenresArmes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`GenresArmes` (
  `id` INT NOT NULL,
  `genre` VARCHAR(30) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`Armes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`Armes` (
  `idItem` INT NOT NULL,
  `efficacite` INT NOT NULL,
  `idGenre` INT NOT NULL,
  `description` VARCHAR(400) NOT NULL,
  PRIMARY KEY (`idItem`),
  CONSTRAINT `fk_armes_Items`
    FOREIGN KEY (`idItem`)
    REFERENCES `dbchevalersk17`.`Items` (`id`),
  CONSTRAINT `fk_armes_genresArmes`
    FOREIGN KEY (`idGenre`)
    REFERENCES `dbchevalersk17`.`GenresArmes` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`TaillesArmures`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`TaillesArmures` (
  `id` INT NOT NULL,
  `taille` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`Armures`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`Armures` (
  `idItem` INT NOT NULL,
  `matiere` VARCHAR(50) NOT NULL,
  `idTaille` INT NOT NULL,
  PRIMARY KEY (`idItem`),
  CONSTRAINT `fk_armures_items`
    FOREIGN KEY (`idItem`)
    REFERENCES `dbchevalersk17`.`Items` (`id`),
  CONSTRAINT `fk_armures_taillesArmures`
    FOREIGN KEY (`idTaille`)
    REFERENCES `dbchevalersk17`.`TaillesArmures` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`NiveauxJoueurs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`NiveauxJoueurs` (
  `id` INT NOT NULL,
  `niveau` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`Joueurs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`Joueurs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `alias` VARCHAR(16) NOT NULL UNIQUE,
  `nom` VARCHAR(16) NOT NULL,
  `prenom` VARCHAR(16) NOT NULL,
  `email` VARCHAR(190) NOT NULL UNIQUE,
  `solde` INT NOT NULL DEFAULT '1000',
  `idNiveau` INT NOT NULL DEFAULT '0',
  `estAlchimiste` TINYINT(1) NOT NULL DEFAULT '0',
  `estAdmin` TINYINT(1) NOT NULL DEFAULT '0',
  `salt` CHAR(16) NOT NULL,
  `hash` CHAR(128) NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_Joueurs_NiveauxJoueurs`
    FOREIGN KEY (`idNiveau`)
    REFERENCES `dbchevalersk17`.`NiveauxJoueurs` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`Demandes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`Demandes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idJoueur` INT NOT NULL,
  `date` DATE NOT NULL,
  `etat` TINYINT(1) NULL DEFAULT NULL,
  `message` VARCHAR(200) NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_demandes_joueurs`
    FOREIGN KEY (`idJoueur`)
    REFERENCES `dbchevalersk17`.`Joueurs` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`DifficultesEnigmes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`DifficultesEnigmes` (
  `id` INT NOT NULL,
  `difficulte` VARCHAR(16) NOT NULL,
  `points` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`TypesElements`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`TypesElements` (
  `id` INT NOT NULL,
  `type` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`Elements`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`Elements` (
  `idItem` INT NOT NULL,
  `idType` INT NOT NULL,
  `rarete` INT NOT NULL,
  `dangerosite` INT NOT NULL,
  PRIMARY KEY (`idItem`),
  CONSTRAINT `fk_elements_items`
    FOREIGN KEY (`idItem`)
    REFERENCES `dbchevalersk17`.`Items` (`id`),
  CONSTRAINT `fk_elements_typesElements`
    FOREIGN KEY (`idType`)
    REFERENCES `dbchevalersk17`.`TypesElements` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`TypesEnigmes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`TypesEnigmes` (
  `id` INT NOT NULL,
  `type` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`Enigmes`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`Enigmes` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `question` varchar(200) NOT NULL,
  `idDifficulte` INT NOT NULL,
  `idType` INT NOT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_enigmes_difficultesEnigmes`
    FOREIGN KEY (`idDifficulte`)
    REFERENCES `dbchevalersk17`.`DifficultesEnigmes` (`id`),
  CONSTRAINT `fk_enigmes_typesEnigmes`
    FOREIGN KEY (`idType`)
    REFERENCES `dbchevalersk17`.`TypesEnigmes` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`EnigmesJoueurs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`EnigmesJoueurs` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `idJoueur` INT NOT NULL,
  `idEnigme` INT NOT NULL,
  `estReussi` TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_enigmesJoueurs_Enigmes`
    FOREIGN KEY (`idEnigme`)
    REFERENCES `dbchevalersk17`.`Enigmes` (`id`),
  CONSTRAINT `fk_enigmesJoueurs_Joueurs`
    FOREIGN KEY (`idJoueur`)
    REFERENCES `dbchevalersk17`.`Joueurs` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`Inventaire`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`Inventaire` (
  `idItem` INT NOT NULL,
  `idJoueur` INT NOT NULL,
  `quantite` INT NOT NULL,
  PRIMARY KEY (`idItem`, `idJoueur`),
  CONSTRAINT `fk_inventaire_items`
    FOREIGN KEY (`idItem`)
    REFERENCES `dbchevalersk17`.`Items` (`id`),
  CONSTRAINT `fk_inventaire_joueurs`
    FOREIGN KEY (`idJoueur`)
    REFERENCES `dbchevalersk17`.`Joueurs` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`Evaluations`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`Evaluations` (
  `idItem` INT NOT NULL,
  `idJoueur` INT NOT NULL,
  `commentaire` VARCHAR(1000) NOT NULL,
  `note` DECIMAL(4,2) NOT NULL,
  PRIMARY KEY (`idItem`, `idJoueur`),
  -- CONSTRAINT `fk_evaluations_inventaire`
  --   FOREIGN KEY (`idItem`)
  --   REFERENCES `dbchevalersk17`.`Inventaire` (`idItem`),
  -- CONSTRAINT `fk_evalutaions_inventaire`
  --   FOREIGN KEY (`idItem` , `idJoueur`)
  --   REFERENCES `dbchevalersk17`.`Inventaire` (`idItem` , `idJoueur`))
  CONSTRAINT `fk_evaluations_items`
    FOREIGN KEY (`idItem`)
    REFERENCES `dbchevalersk17`.`Items` (`id`),
  CONSTRAINT `fk_evaluations_joueurs`
    FOREIGN KEY (`idJoueur`)
    REFERENCES `dbchevalersk17`.`Joueurs` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`Panier`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`Panier` (
  `idItem` INT NOT NULL,
  `idJoueur` INT NOT NULL,
  `quantite` INT NOT NULL,
  PRIMARY KEY (`idItem`, `idJoueur`),
  CONSTRAINT `fk_panier_items`
    FOREIGN KEY (`idItem`)
    REFERENCES `dbchevalersk17`.`Items` (`id`),
  CONSTRAINT `fk_panier_joueurs`
    FOREIGN KEY (`idJoueur`)
    REFERENCES `dbchevalersk17`.`Joueurs` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`TypesPotions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`TypesPotions` (
  `id` INT NOT NULL,
  `type` VARCHAR(16) NOT NULL,
  PRIMARY KEY (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`Potions`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`Potions` (
  `idItem` INT NOT NULL,
  `effet` VARCHAR(50) NOT NULL,
  `duree` INT NOT NULL,
  `idType` INT NOT NULL,
  PRIMARY KEY (`idItem`),
  CONSTRAINT `fk_potions_items`
    FOREIGN KEY (`idItem`)
    REFERENCES `dbchevalersk17`.`Items` (`id`),
  CONSTRAINT `fk_potions_typesPotions`
    FOREIGN KEY (`idType`)
    REFERENCES `dbchevalersk17`.`TypesPotions` (`id`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;


-- -----------------------------------------------------
-- Table `dbchevalersk17`.`PotionsJoueurs`
-- -----------------------------------------------------
CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`PotionsJoueurs` (
  `idPotion` INT NOT NULL,
  `idJoueur` INT NOT NULL,
  `quantite` INT NULL DEFAULT '0',
  CONSTRAINT `fk_potionsJoueurs_joueurs`
    FOREIGN KEY (`idJoueur`)
    REFERENCES `dbchevalersk17`.`Joueurs` (`id`),
  CONSTRAINT `fk_potionsJoueurs_potions`
    FOREIGN KEY (`idPotion`)
    REFERENCES `dbchevalersk17`.`Potions` (`idItem`))
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `dbchevalersk17`.`REPONSES`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`Reponses`(
  `id` INT NOT NULL AUTO_INCREMENT,
  `idQuestion` INT NOT NULL,
  `texte` VARCHAR(512) NOT NULL,
  `isTrue` TINYINT(1) NOT NULL DEFAULT '0',
  PRIMARY KEY(`id`),
  CONSTRAINT `fk_Responses_Questions` 
  FOREIGN KEY (`idQuestion`)
  REFERENCES `dbchevalersk17`.`Enigmes` (`id`))

ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `dbchevalersk17`.`ElementPotion`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`ElementPotion`(
  `idPotion` INT NOT NULL ,
  `idElement` INT NOT NULL,
  PRIMARY KEY (`idPotion`, `idElement`),
  CONSTRAINT `fk_elementPotion_potions`
    FOREIGN KEY (`idPotion`)
   REFERENCES `dbchevalersk17`.`Potions` (`idItem`),
  CONSTRAINT `fk_elementPotion_elements`
    FOREIGN KEY (`idElement`)
    REFERENCES `dbchevalersk17`.`Elements` (`idItem`)
    )

ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;

-- -----------------------------------------------------
-- Table `dbchevalersk17`.`StatistiqueJoueur`
-- -----------------------------------------------------

CREATE TABLE IF NOT EXISTS `dbchevalersk17`.`StatistiqueJoueur`(
	`idJoueur` INT NOT NULL,
    `dateCreation` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    `nbAchats` INT,
    `itemsInventaire` INT,
    `nbConcoctions` INT,
    `progressionEnigmes` VARCHAR(100) NOT NULL,
    `nbEvaluations` INT,
    `totalEcusDepense` INT,
    PRIMARY KEY (`idJoueur`),
  CONSTRAINT `fk_statistiqueJoueurs_joueurs`
    FOREIGN KEY (`idJoueur`)
    REFERENCES `dbchevalersk17`.`Joueurs` (`id`)
)
ENGINE = InnoDB
DEFAULT CHARACTER SET = utf8mb4;