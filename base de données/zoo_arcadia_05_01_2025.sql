-- MySQL dump 10.13  Distrib 8.0.40, for Win64 (x86_64)
--
-- Host: localhost    Database: zooarcadia
-- ------------------------------------------------------
-- Server version	8.0.40

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!50503 SET NAMES utf8 */;
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Table structure for table `animal`
--

DROP TABLE IF EXISTS `animal`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `animal` (
  `id_animal` int NOT NULL AUTO_INCREMENT,
  `nom_animal` varchar(255) NOT NULL,
  `status_animal` varchar(255) NOT NULL,
  `id_habitat` int DEFAULT NULL,
  `id_race` int DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `view_animal` int DEFAULT '0',
  PRIMARY KEY (`id_animal`),
  KEY `id_habitat` (`id_habitat`),
  KEY `id_race` (`id_race`),
  CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`id_habitat`) REFERENCES `habitats` (`id_habitat`) ON DELETE CASCADE,
  CONSTRAINT `animal_ibfk_2` FOREIGN KEY (`id_race`) REFERENCES `races` (`id_race`)
) ENGINE=InnoDB AUTO_INCREMENT=69 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animal`
--

LOCK TABLES `animal` WRITE;
/*!40000 ALTER TABLE `animal` DISABLE KEYS */;
INSERT INTO `animal` VALUES (1,'Girafe','En bonne santé',1,12,'img/animaux/girafe.jpg',9),(2,'Lion','En bonne santé',6,6,'img/animaux/Lion.jpg',1),(3,'Koala','En observation',4,4,'img/animaux/koala.jpg',4),(4,'zebre','En bonne santé',1,13,'img/animaux/zebre.jpg',0),(5,'Kangourou','En bonne santé',5,5,'img/animaux/Kangourou.jpg',4),(6,'Singe','En bonne santé',7,9,'img/animaux/singe.jpg',5),(7,'Tigre','En bonne santé',7,7,'img/animaux/Tigre.jpg',1),(8,'Éléphant','En bonne santé',1,8,'img/animaux/Elephant.jpg',0),(9,'Vache','En bonne santé',8,14,'img/animaux/vache.jpg',4),(10,'Caméléon','En bonne santé',7,10,'img/animaux/caméléon.jpg',0),(11,'Lézard','En bonne santé',3,11,'img/animaux/Lezard.jpg',0),(12,'Tortue','En bonne santé',3,15,'img/animaux/tortue.jpg',0),(13,'Chevre','Bonne santé',8,24,'img/animaux/chevre.jpg',0),(14,'Chameaux','Bonne santé',3,3,'img/animaux/chameaux.jpg',0),(15,'Gorille','Actif',5,25,'img/animaux/gorille.jpg',0),(16,'Panda','Actif',7,26,'img/animaux/panda.jpg',0),(17,'Requin','Actif',8,27,'img/animaux/requin.jpg',0),(18,'Ours','Actif',9,17,'img/animaux/ours.jpg',0),(19,'Serpent','Actif',9,18,'img/animaux/serpent.jpg',0),(20,'Rhinocéros','Actif',9,19,'img/animaux/rhinoceros.jpg',0),(21,'Lynx','Actif',9,20,'img/animaux/lynx.jpg',0),(22,'Crocodile','Actif',9,21,'img/animaux/crocodile.jpg',0),(23,'Flamant rose','Actif',9,22,'img/animaux/flamant_rose.jpg',0),(24,'Coyote','Actif',9,23,'img/animaux/coyote.jpg',0),(58,'Gorille','Actif',5,25,'img/animaux/gorille.jpg',0),(59,'Panda','Actif',7,26,'img/animaux/panda.jpg',0),(60,'Requin','Actif',8,16,'img/animaux/requin.jpg',0),(61,'Ours','Actif',9,17,'img/animaux/ours.jpg',0),(62,'Serpent','Actif',9,18,'img/animaux/serpent.jpg',0),(63,'Rhinocéros','Actif',9,19,'img/animaux/rhinoceros.jpg',0),(64,'Lynx','Actif',9,20,'img/animaux/lynx.jpg',0),(65,'Crocodile','Actif',9,21,'img/animaux/crocodile.jpg',0),(66,'Flamant rose','Actif',9,22,'img/animaux/flamant_rose.jpg',0),(67,'Coyote','Actif',9,23,'img/animaux/coyote.jpg',0),(68,'Hippopotame','Actif',8,28,'img/animaux/hippopotame.jpg',0);
/*!40000 ALTER TABLE `animal` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `animal_nourriture`
--

DROP TABLE IF EXISTS `animal_nourriture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `animal_nourriture` (
  `id_animal` int NOT NULL,
  `id_nourriture` int NOT NULL,
  `quantite_max_journaliere` int DEFAULT NULL,
  `est_preferee` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id_animal`,`id_nourriture`),
  KEY `id_nourriture` (`id_nourriture`),
  CONSTRAINT `animal_nourriture_ibfk_1` FOREIGN KEY (`id_animal`) REFERENCES `animal` (`id_animal`) ON DELETE CASCADE,
  CONSTRAINT `animal_nourriture_ibfk_2` FOREIGN KEY (`id_nourriture`) REFERENCES `nourriture` (`id_nourriture`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animal_nourriture`
--

LOCK TABLES `animal_nourriture` WRITE;
/*!40000 ALTER TABLE `animal_nourriture` DISABLE KEYS */;
INSERT INTO `animal_nourriture` VALUES (1,1,500,1),(1,4,300,0),(2,2,600,1),(3,3,700,1),(3,6,700,1),(4,4,800,1),(4,5,500,0),(5,4,550,1),(5,5,250,0),(6,1,1,0),(6,4,1,0),(6,6,1,0),(6,7,200,0),(6,9,1,0),(7,2,10,0),(8,4,20,1),(8,5,300,0),(8,10,20,1),(9,4,10,10),(9,5,200,0),(9,9,3,1),(10,1,1,0),(10,7,0,1),(11,7,100,1),(12,1,450,1),(12,4,500,0),(13,4,700,1),(13,5,250,0),(14,4,650,1),(14,5,300,0),(15,6,500,1),(15,9,200,0),(16,3,600,1),(16,6,200,0),(17,2,700,1),(18,6,300,1),(18,7,100,0),(19,2,500,1),(20,4,800,1),(20,5,300,0),(21,2,600,1),(22,2,700,1),(23,7,150,0),(23,9,200,1),(24,2,600,1);
/*!40000 ALTER TABLE `animal_nourriture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `avis`
--

DROP TABLE IF EXISTS `avis`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `avis` (
  `id_avis` int NOT NULL AUTO_INCREMENT,
  `nom_avis` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `email_avis` varchar(100) DEFAULT NULL,
  `profession_avis` varchar(45) DEFAULT NULL,
  `message_avis` text,
  `note_avis` int DEFAULT NULL,
  `image_avis` varchar(100) DEFAULT NULL,
  `date_avis` datetime DEFAULT NULL,
  `valider_avis` tinyint DEFAULT NULL,
  PRIMARY KEY (`id_avis`)
) ENGINE=MyISAM AUTO_INCREMENT=40 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avis`
--

LOCK TABLES `avis` WRITE;
/*!40000 ALTER TABLE `avis` DISABLE KEYS */;
INSERT INTO `avis` VALUES (2,'Sébastien Cauet','sebastiencauet@gmail.com','Animateur','Très bon accueil, délais respectés, et tarifs très compétitifs pour l\'achat d\'un abonnement annuel. Je recommande vivement ZooArcadia !',4,'Sebastien_Cauet.jpg','2024-01-14 20:36:44',1),(3,'Riadh HAJJI','hajj@gmail.com','Etudiant','Un peu tôt pour savoir si ZooArcadia répondra parfaitement à mes attentes, mais ma première visite et mon expérience sur place sont plutôt positives.',3,'Riadh_HAJJI.jpg','2024-01-15 08:39:51',1),(4,'Monica STYLE','monicastyle200@gmail.com','Animatrice','Bon accueil, prix attractifs, personnel agréable et professionnel. ZooArcadia est une adresse que je recommande vivement !',5,'Monica_STYLE.jpg','2024-01-15 10:39:51',1),(5,'Sara SBITT','sara.sbittgmail.com','Professeur','Je ne mets pas 5 étoiles car il manquait une information sur l\'animal que je recherchais. Mais l\'équipe de ZooArcadia a su me satisfaire dans la journée. Une équipe professionnelle et sympathique !',4,'Sara_SBITT.jpg','2024-01-15 11:39:51',1),(6,'Louane  Emera','Louane-emra','Chanteuse','Service client réactif et courtois ! L\'équipe de ZooArcadia a pris en charge ma demande avec soin, répondant rapidement et avec beaucoup de professionnalisme.',5,'Louane_ Emera.jpg','2024-01-15 13:39:51',0),(1,'Sébastien Cauet','sebastiencauet@gmail.com','Animateur','Très bon accueil, délais respectés et tarifs très intéressants pour les services proposés. Je recommande vivement ZooArcadia !',4,'Sebastien_Cauet.jpg','2024-01-14 20:36:44',0),(7,'Paul Durant','paul.durant@gmail.com','Architecte','Expérience exceptionnelle au ZooArcadia ! L’organisation et la propreté sont remarquables.',5,'Paul_Durant.jpg','2024-01-16 09:15:30',1),(8,'Clara Leblanc','clara.leblanc@gmail.com','Photographe','Super endroit pour capturer de magnifiques photos d’animaux. Je reviendrai !',4,'Clara_Leblanc.jpg','2024-01-16 11:22:45',1),(9,'Hugo Martin','hugo.martin@yahoo.com','Étudiant','Un très bon moment passé au ZooArcadia, mais les files d’attente étaient un peu longues.',3,'Hugo_Martin.jpg','2024-01-16 14:50:20',0),(10,'Emma Dubois','emma.dubois@gmail.com','Infirmière','Une visite inoubliable ! Mes enfants ont adoré le spectacle des oiseaux.',5,'Emma_Dubois.jpg','2024-01-17 08:20:55',1),(11,'Lucas Morel','lucas.morel@gmail.com','Développeur','Les tarifs sont un peu élevés, mais la qualité des installations est impeccable.',4,'Lucas_Morel.jpg','2024-01-17 09:30:15',1),(12,'Juliette Bernard','juliette.bernard@gmail.com','Comptable','Les informations sur les animaux sont très instructives, et le personnel est chaleureux.',5,'Juliette_Bernard.jpg','2024-01-17 12:10:35',1),(13,'Alexandre Dupuis','alexandre.dupuis@gmail.com','Avocat','Une belle expérience, mais le café pourrait être amélioré.',3,'Alexandre_Dupuis.jpg','2024-01-17 14:45:50',0),(14,'Camille Lefèvre','camille.lefevre@hotmail.com','Designer','La variété des animaux est impressionnante, et le personnel est attentionné.',5,'Camille_Lefevre.jpg','2024-01-18 10:20:10',1),(15,'Léa Rousseau','lea.rousseau@gmail.com','Étudiante','Très bon accueil et de nombreuses activités intéressantes pour les enfants.',4,'Lea_Rousseau.jpg','2024-01-18 11:40:00',1),(16,'Victor Girard','victor.girard@gmail.com','Médecin','Un lieu très agréable pour se détendre en famille. Une bonne surprise !',5,'Victor_Girard.jpg','2024-01-18 14:00:25',1),(17,'Elodie Simon','elodie.simon@gmail.com','Chanteuse','Un endroit unique qui offre une belle perspective sur la faune.',5,'Elodie_Simon.jpg','2024-01-18 15:30:40',1),(18,'Thomas Perrin','thomas.perrin@yahoo.com','Journaliste','Une journée agréable malgré un manque de signalisation dans certaines zones.',3,'Thomas_Perrin.jpg','2024-01-19 09:15:50',0),(19,'Sophie Marchand','sophie.marchand@gmail.com','Professeur','Mes élèves ont adoré la visite. Une expérience pédagogique réussie !',5,'Sophie_Marchand.jpg','2024-01-19 10:40:30',1),(20,'Antoine Leroy','antoine.leroy@gmail.com','Écrivain','Un cadre magnifique pour écrire et se reconnecter à la nature.',4,'Antoine_Leroy.jpg','2024-01-19 12:10:45',1),(21,'Charlotte Dumas','charlotte.dumas@gmail.com','Étudiante','Les informations sur la conservation des animaux étaient fascinantes.',5,'Charlotte_Dumas.jpg','2024-01-19 14:50:10',1);
/*!40000 ALTER TABLE `avis` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `consommation`
--

DROP TABLE IF EXISTS `consommation`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `consommation` (
  `id_consommation` int NOT NULL AUTO_INCREMENT,
  `id_animal` int NOT NULL,
  `id_nourriture` int NOT NULL,
  `date` date NOT NULL,
  `heure` time NOT NULL,
  `grammage` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id_consommation`),
  KEY `id_animal` (`id_animal`),
  KEY `id_nourriture` (`id_nourriture`),
  CONSTRAINT `consommation_ibfk_1` FOREIGN KEY (`id_animal`) REFERENCES `animal` (`id_animal`),
  CONSTRAINT `consommation_ibfk_2` FOREIGN KEY (`id_nourriture`) REFERENCES `nourriture` (`id_nourriture`)
) ENGINE=InnoDB AUTO_INCREMENT=250 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `consommation`
--

LOCK TABLES `consommation` WRITE;
/*!40000 ALTER TABLE `consommation` DISABLE KEYS */;
INSERT INTO `consommation` VALUES (168,1,1,'2024-12-01','08:00:00',5.00),(169,1,2,'2024-12-01','12:00:00',4.50),(170,2,3,'2024-12-01','09:00:00',7.00),(171,2,4,'2024-12-01','14:00:00',3.50),(172,3,5,'2024-12-01','07:30:00',6.25),(173,3,6,'2024-12-01','13:00:00',4.00),(174,4,7,'2024-12-01','08:30:00',5.75),(175,4,8,'2024-12-01','15:00:00',6.50),(176,5,1,'2024-12-01','10:00:00',5.25),(177,5,2,'2024-12-01','18:00:00',3.75),(178,6,3,'2024-12-01','09:45:00',7.25),(179,6,4,'2024-12-01','14:30:00',2.50),(180,7,5,'2024-12-01','08:15:00',6.00),(181,7,6,'2024-12-01','12:30:00',4.25),(182,8,7,'2024-12-01','10:30:00',5.50),(183,8,8,'2024-12-01','17:00:00',7.00),(184,9,1,'2024-12-01','08:00:00',5.75),(185,9,2,'2024-12-01','13:30:00',4.00),(186,10,3,'2024-12-02','09:00:00',0.50),(187,10,4,'2024-12-02','14:00:00',0.25),(188,11,5,'2024-12-02','07:30:00',1.00),(189,11,6,'2024-12-02','12:30:00',4.50),(190,12,7,'2024-12-02','08:15:00',5.25),(191,12,8,'2024-12-02','15:00:00',7.25),(192,13,1,'2024-12-02','09:00:00',6.00),(193,13,2,'2024-12-02','14:30:00',4.50),(194,14,3,'2024-12-02','10:00:00',7.00),(195,14,4,'2024-12-02','16:00:00',3.25),(196,15,5,'2024-12-02','08:30:00',5.75),(197,15,6,'2024-12-02','12:45:00',4.25),(198,16,7,'2024-12-02','09:15:00',6.25),(199,16,8,'2024-12-02','13:00:00',7.50),(200,17,1,'2024-12-03','08:30:00',5.50),(201,17,2,'2024-12-03','12:00:00',4.00),(202,18,3,'2024-12-03','09:45:00',6.75),(203,18,4,'2024-12-03','14:00:00',3.50),(204,19,5,'2024-12-03','07:45:00',5.25),(205,19,6,'2024-12-03','13:30:00',4.00),(206,20,7,'2024-12-03','08:00:00',6.00),(207,20,8,'2024-12-03','15:15:00',7.25),(208,1,1,'2024-12-04','08:00:00',5.00),(209,1,2,'2024-12-04','12:00:00',4.50),(210,2,3,'2024-12-04','09:00:00',7.00),(211,2,4,'2024-12-04','14:00:00',3.50),(212,3,5,'2024-12-04','07:30:00',6.25),(213,3,6,'2024-12-04','13:00:00',4.00),(214,4,7,'2024-12-04','08:30:00',5.75),(215,4,8,'2024-12-04','15:00:00',6.50),(216,5,1,'2024-12-04','10:00:00',5.25),(217,5,2,'2024-12-04','18:00:00',3.75),(218,6,3,'2024-12-04','09:45:00',7.25),(219,6,4,'2024-12-04','14:30:00',2.50),(220,7,5,'2024-12-04','08:15:00',6.00),(221,7,6,'2024-12-04','12:30:00',4.25),(222,8,7,'2024-12-04','10:30:00',5.50),(223,8,8,'2024-12-05','17:00:00',7.00),(224,9,1,'2024-12-05','08:00:00',5.75),(225,9,2,'2024-12-05','13:30:00',4.00),(226,10,3,'2024-12-05','09:00:00',0.50),(227,10,4,'2024-12-05','14:00:00',0.25),(228,11,5,'2024-12-05','07:30:00',6.00),(229,11,6,'2024-12-05','12:30:00',4.50),(230,12,7,'2024-12-05','08:15:00',5.25),(231,12,8,'2024-12-05','15:00:00',7.25),(232,13,1,'2024-12-05','09:00:00',6.00),(233,13,2,'2024-12-05','14:30:00',4.50),(234,14,3,'2024-12-05','10:00:00',7.00),(235,14,4,'2024-12-05','16:00:00',3.25),(236,15,5,'2024-12-05','08:30:00',5.75),(237,15,6,'2024-12-05','12:45:00',4.25),(238,16,7,'2024-12-05','09:15:00',6.25),(239,16,8,'2024-12-05','13:00:00',7.50),(240,17,1,'2024-12-06','08:30:00',5.50),(241,17,2,'2024-12-06','12:00:00',4.00),(242,18,3,'2024-12-06','09:45:00',6.75),(243,18,4,'2024-12-06','14:00:00',3.50),(244,19,5,'2024-12-06','07:45:00',5.25),(245,19,6,'2024-12-06','13:30:00',4.00),(246,20,7,'2024-12-06','08:00:00',6.00),(247,20,8,'2024-12-06','15:15:00',7.25),(248,3,3,'2024-12-13','22:06:00',2.00),(249,2,2,'2024-12-13','02:11:00',4.00);
/*!40000 ALTER TABLE `consommation` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `contacts`
--

DROP TABLE IF EXISTS `contacts`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `contacts` (
  `id` int NOT NULL AUTO_INCREMENT,
  `prenom_nom` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `sujet` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `date_creation` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `contacts`
--

LOCK TABLES `contacts` WRITE;
/*!40000 ALTER TABLE `contacts` DISABLE KEYS */;
INSERT INTO `contacts` VALUES (2,'Riadh HAJJI','hajjriadh@gmail.com','Remerciement','Merci pour tous les membres de l\'équipe','2024-12-15 15:06:37');
/*!40000 ALTER TABLE `contacts` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `habitats`
--

DROP TABLE IF EXISTS `habitats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `habitats` (
  `id_habitat` int NOT NULL AUTO_INCREMENT,
  `description_habitat` text NOT NULL,
  `nom_habitat` varchar(255) DEFAULT NULL,
  `image_path` varchar(255) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_habitat`)
) ENGINE=InnoDB AUTO_INCREMENT=10 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `habitats`
--

LOCK TABLES `habitats` WRITE;
/*!40000 ALTER TABLE `habitats` DISABLE KEYS */;
INSERT INTO `habitats` VALUES (1,'Grande savane ouverte avec quelques arbres','Savane','img/habitats/savane.jpg','2024-11-09 06:40:38','2024-11-09 06:40:38'),(2,'Zone tropicale humide avec une végétation dense','Forêt tropicale','img/habitats/foret_tropicale.jpg','2024-11-09 06:40:38','2024-11-09 06:40:38'),(3,'Région aride avec peu de végétation','Désert','img/habitats/desert.jpg','2024-11-09 06:40:38','2024-11-09 06:40:38'),(4,'Forêt d’eucalyptus adaptée aux koalas.','Forêt de Koalas','img/habitats/foret_koalas.jpg','2024-11-09 08:01:25','2024-11-09 08:01:25'),(5,'Région semi-désertique avec une végétation clairsemée.','Désert de Kangourous','img/habitats/desert_kangourous.jpg','2024-11-09 08:01:25','2024-11-09 08:01:25'),(6,'Savane africaine ouverte, maison des lions.','Savane','img/habitats/savane.jpg','2024-11-09 08:07:48','2024-11-09 08:07:48'),(7,'Forêt tropicale dense, idéale pour les tigres et singes.','Jungle','img/habitats/jungle.jpg','2024-11-09 08:07:48','2024-11-09 08:07:48'),(8,'Zone de prairies humides et d’arbres clairsemés.','Prairie','img/habitats/prairie.jpg','2024-11-09 08:07:48','2024-11-09 08:07:48'),(9,'Désert chaud avec peu de végétation, adapté aux reptiles.','Désert','img/habitats/desert.jpg','2024-11-09 08:07:48','2024-11-09 08:07:48');
/*!40000 ALTER TABLE `habitats` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `heures_visite`
--

DROP TABLE IF EXISTS `heures_visite`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `heures_visite` (
  `id` int NOT NULL AUTO_INCREMENT,
  `jour` varchar(20) NOT NULL,
  `ouverture` time DEFAULT NULL,
  `fermeture` time DEFAULT NULL,
  `ferme` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=8 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `heures_visite`
--

LOCK TABLES `heures_visite` WRITE;
/*!40000 ALTER TABLE `heures_visite` DISABLE KEYS */;
INSERT INTO `heures_visite` VALUES (1,'Lundi','09:00:00','18:00:00',0),(2,'Mardi','09:00:00','18:00:00',0),(3,'Mercredi','09:00:00','18:00:00',0),(4,'Jeudi','09:00:00','18:00:00',0),(5,'Vendredi','09:00:00','18:00:00',0),(6,'Samedi','09:00:00','18:00:00',0),(7,'Dimanche',NULL,NULL,1);
/*!40000 ALTER TABLE `heures_visite` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nourriture`
--

DROP TABLE IF EXISTS `nourriture`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nourriture` (
  `id_nourriture` int NOT NULL AUTO_INCREMENT,
  `nom` varchar(100) NOT NULL,
  `categorie` varchar(50) DEFAULT NULL,
  `unite` varchar(20) DEFAULT NULL,
  `stock` decimal(10,2) NOT NULL DEFAULT '0.00',
  PRIMARY KEY (`id_nourriture`)
) ENGINE=InnoDB AUTO_INCREMENT=11 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nourriture`
--

LOCK TABLES `nourriture` WRITE;
/*!40000 ALTER TABLE `nourriture` DISABLE KEYS */;
INSERT INTO `nourriture` VALUES (1,'Feuilles','Plantes','kg',100.00),(2,'Viande','Carnivore','kg',200.00),(3,'Feuilles d\'eucalyptus','Plantes','kg',50.00),(4,'Herbes','Plantes','kg',150.00),(5,'Foin','Herbe','kg',300.00),(6,'Fruits','Plantes','kg',120.00),(7,'Insectes','Insectes','g',80.00),(8,'Légumes','Plantes','kg',100.00),(9,'Graine','Plantes','Kg',200.00),(10,'Feuilles et branches','Plantes','Kg',150.00);
/*!40000 ALTER TABLE `nourriture` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `races`
--

DROP TABLE IF EXISTS `races`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `races` (
  `id_race` int NOT NULL AUTO_INCREMENT,
  `nom_race` varchar(255) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id_race`)
) ENGINE=InnoDB AUTO_INCREMENT=29 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `races`
--

LOCK TABLES `races` WRITE;
/*!40000 ALTER TABLE `races` DISABLE KEYS */;
INSERT INTO `races` VALUES (1,'Lion d’Afrique','2024-11-09 06:41:03','2024-11-09 06:41:03'),(2,'Éléphant d’Asie','2024-11-09 06:41:03','2024-11-09 06:41:03'),(3,'Chameau arabe','2024-11-09 06:41:03','2024-11-09 06:41:03'),(4,'Koala','2024-11-09 08:01:42','2024-11-09 08:01:42'),(5,'Kangourou','2024-11-09 08:01:42','2024-11-09 08:01:42'),(6,'Lion','2024-11-09 08:06:39','2024-11-09 08:06:39'),(7,'Tigre','2024-11-09 08:06:39','2024-11-09 08:06:39'),(8,'Éléphant','2024-11-09 08:06:39','2024-11-09 08:06:39'),(9,'Singe','2024-11-09 08:06:39','2024-11-09 08:06:39'),(10,'Caméléon','2024-11-09 08:06:39','2024-11-09 08:06:39'),(11,'Lézard','2024-11-09 08:06:39','2024-11-09 08:06:39'),(12,'Girafe','2024-12-30 16:18:07','2024-12-30 16:18:07'),(13,'Zèbre','2024-12-30 16:18:07','2024-12-30 16:18:07'),(14,'Vache','2024-12-30 16:18:07','2024-12-30 16:18:07'),(15,'Tortue','2024-12-30 16:18:07','2024-12-30 16:18:07'),(16,'Requin','2024-12-30 16:18:07','2024-12-30 16:18:07'),(17,'Ours','2024-12-30 16:18:07','2024-12-30 16:18:07'),(18,'Serpent','2024-12-30 16:18:07','2024-12-30 16:18:07'),(19,'Rhinocéros','2024-12-30 16:18:07','2024-12-30 16:18:07'),(20,'Lynx','2024-12-30 16:18:07','2024-12-30 16:18:07'),(21,'Crocodile','2024-12-30 16:18:07','2024-12-30 16:18:07'),(22,'Flamant rose','2024-12-30 16:18:07','2024-12-30 16:18:07'),(23,'Coyote','2024-12-30 16:18:07','2024-12-30 16:18:07'),(24,'Chevre','2024-12-30 16:18:07','2024-12-30 16:18:07'),(25,'Gorille','2024-12-30 16:18:07','2024-12-30 16:18:07'),(26,'Panda','2024-12-30 16:18:07','2024-12-30 16:18:07'),(27,'Requin','2024-12-30 16:18:07','2024-12-30 16:18:07'),(28,'Hippopotame',NULL,NULL);
/*!40000 ALTER TABLE `races` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `services`
--

DROP TABLE IF EXISTS `services`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `services` (
  `id_service` int NOT NULL AUTO_INCREMENT,
  `nom_service` varchar(255) NOT NULL,
  `description_service` text NOT NULL,
  `cree_le_service` datetime DEFAULT CURRENT_TIMESTAMP,
  `modifie_le_service` datetime DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id_service`)
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `services`
--

LOCK TABLES `services` WRITE;
/*!40000 ALTER TABLE `services` DISABLE KEYS */;
INSERT INTO `services` VALUES (1,'Restauration','Service de restauration proposant des repas rapides, snacks, et boissons.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(2,'Visite guidée','Visite des habitats animaliers avec un guide professionnel.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(3,'Petit train','Balade en petit train dans tout le zoo.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(4,'Boutique souvenirs','Magasin de souvenirs pour acheter des cadeaux et objets de collection.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(5,'Atelier éducatif','Ateliers pour découvrir la vie des animaux et la conservation.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(6,'Location de poussettes','Service de location de poussettes pour les familles.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(7,'Location de fauteuils roulants','Service gratuit de prêt de fauteuils roulants.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(8,'Spectacle animalier','Spectacles interactifs avec des animaux dressés.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(9,'Aire de jeux','Espace de jeux pour les enfants avec toboggans et balançoires.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(10,'Photographe','Service de photographie pour immortaliser votre visite.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(11,'Soins vétérinaires','Service vétérinaire pour les animaux du parc.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(12,'Zones de pique-nique','Espaces dédiés pour pique-niquer en famille ou entre amis.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(13,'Parking sécurisé','Parking avec vidéosurveillance pour les visiteurs.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(14,'Centre d’information','Point d’information pour répondre aux questions des visiteurs.','2024-12-01 20:30:27','2024-12-01 20:30:27'),(15,'Wifi gratuit','Accès au Wifi gratuit dans tout le parc.','2024-12-01 20:30:27','2024-12-01 20:30:27');
/*!40000 ALTER TABLE `services` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `utilisateur`
--

DROP TABLE IF EXISTS `utilisateur`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `utilisateur` (
  `id_utilisateur` int NOT NULL AUTO_INCREMENT,
  `prenom_utilisateur` varchar(100) DEFAULT NULL,
  `nom_utilisateur` varchar(100) DEFAULT NULL,
  `email_utilisateur` varchar(255) NOT NULL,
  `tel_utilisateur` varchar(45) DEFAULT NULL,
  `role_utilisateur` enum('administrateur','veterinaire','employe') NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `mot_passe_utilisateur` varchar(255) NOT NULL,
  `remember_token` varchar(100) DEFAULT NULL,
  `cree_le` datetime DEFAULT NULL,
  `modifie_le` datetime DEFAULT NULL,
  PRIMARY KEY (`id_utilisateur`),
  UNIQUE KEY `email_utilisateur` (`email_utilisateur`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `utilisateur`
--

LOCK TABLES `utilisateur` WRITE;
/*!40000 ALTER TABLE `utilisateur` DISABLE KEYS */;
INSERT INTO `utilisateur` VALUES (1,'José','Admin','admin@zoo.com',NULL,'administrateur','2024-11-30 21:20:03','$2y$10$Ko1/muZyJ.EgTFxCGDRiK.ev3JkWTsdQhyxuEWh0XKNZfVDc8zB0q',NULL,'2024-11-30 22:20:03',NULL),(2,'Marie','Dupont','veterinaire1@zoo.com',NULL,'veterinaire','2024-11-30 21:20:03','a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa7e857f6a3e8f8ae9f1e',NULL,'2024-11-30 22:20:03',NULL),(3,'Paul','Martin','veterinaire2@zoo.com',NULL,'veterinaire',NULL,'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa7e857f6a3e8f8ae9f1e',NULL,'2024-11-30 22:20:03',NULL),(4,'Julie','Durand','employe1@zoo.com',NULL,'employe','2024-11-30 21:20:03','a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa7e857f6a3e8f8ae9f1e',NULL,'2024-11-30 22:20:03',NULL),(5,'Luc','Bernard','employe2@zoo.com',NULL,'employe',NULL,'a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa7e857f6a3e8f8ae9f1e',NULL,'2024-11-30 22:20:03',NULL),(30,'abc','abc','admin1@zoo.com','123456','administrateur',NULL,'$2y$10$e0qHNy4TAMOUMc.yvc.2g.1ftJaLftXjcNuY12IGXTFREnzP182Wq',NULL,'2024-12-01 17:26:32',NULL);
/*!40000 ALTER TABLE `utilisateur` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2025-01-05 20:02:46
