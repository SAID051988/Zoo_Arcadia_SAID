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
  PRIMARY KEY (`id_animal`),
  KEY `id_habitat` (`id_habitat`),
  KEY `id_race` (`id_race`),
  CONSTRAINT `animal_ibfk_1` FOREIGN KEY (`id_habitat`) REFERENCES `habitats` (`id_habitat`) ON DELETE CASCADE,
  CONSTRAINT `animal_ibfk_2` FOREIGN KEY (`id_race`) REFERENCES `races` (`id_race`)
) ENGINE=InnoDB AUTO_INCREMENT=28 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `animal`
--

LOCK TABLES `animal` WRITE;
/*!40000 ALTER TABLE `animal` DISABLE KEYS */;
INSERT INTO `animal` VALUES (1,'Girafe','En bonne santé',1,1,'img/animaux/girafe.jpg'),(2,'Lion','En bonne santé',2,2,'img/animaux/Lion.jpg'),(3,'Koala','En observation',3,3,'img/animaux/koala.jpg'),(4,'zebre','En bonne santé',1,1,'img/animaux/zebre.jpg'),(5,'Kangourou','En bonne santé',2,2,'img/animaux/Kangourou.jpg'),(12,'Singe','En bonne santé',3,3,'img/animaux/singe.jpg'),(13,'Tigre','En bonne santé',4,4,'img/animaux/Tigre.jpg'),(14,'Éléphant','En bonne santé',5,5,'img/animaux/Elephant.jpg'),(15,'Vache','En bonne santé',4,6,'img/animaux/vache.jpg'),(16,'Caméléon','En bonne santé',6,7,'img/animaux/caméléon.jpg'),(17,'Lézard','En bonne santé',6,8,'img/animaux/Lezard.jpg'),(18,'Tortue','En bonne santé',6,8,'img/animaux/tortue.jpg'),(26,'Chevre','Bonne santé',8,4,'img/animaux/chevre.jpg'),(27,'Chameaux','Bonne santé',8,3,'img/animaux/chameaux.jpg');
/*!40000 ALTER TABLE `animal` ENABLE KEYS */;
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
) ENGINE=MyISAM AUTO_INCREMENT=25 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `avis`
--

LOCK TABLES `avis` WRITE;
/*!40000 ALTER TABLE `avis` DISABLE KEYS */;
INSERT INTO `avis` VALUES (2,'Sébastien Cauet','sebastiencauet@gmail.com','Animateur','Très bon accueil, délais respectés, et tarifs très compétitifs pour l\'achat d\'un abonnement annuel. Je recommande vivement ZooArcadia !',4,'Sebastien_Cauet.jpg','2024-01-14 20:36:44',1),(3,'Riadh HAJJI','hajj@gmail.com','Etudiant','Un peu tôt pour savoir si ZooArcadia répondra parfaitement à mes attentes, mais ma première visite et mon expérience sur place sont plutôt positives.',3,'Riadh_HAJJI.jpg','2024-01-15 08:39:51',1),(4,'Monica STYLE','monicastyle200@gmail.com','Animatrice','Bon accueil, prix attractifs, personnel agréable et professionnel. ZooArcadia est une adresse que je recommande vivement !',5,'Monica_STYLE.jpg','2024-01-15 10:39:51',1),(5,'Sara SBITT','sara.sbittgmail.com','Professeur','Je ne mets pas 5 étoiles car il manquait une information sur l\'animal que je recherchais. Mais l\'équipe de ZooArcadia a su me satisfaire dans la journée. Une équipe professionnelle et sympathique !',4,'Sara_SBITT.jpg','2024-01-15 11:39:51',1),(6,'Louane  Emera','Louane-emra','Chanteuse','Service client réactif et courtois ! L\'équipe de ZooArcadia a pris en charge ma demande avec soin, répondant rapidement et avec beaucoup de professionnalisme.',5,'Louane_ Emera.jpg','2024-01-15 13:39:51',0),(1,'Sébastien Cauet','sebastiencauet@gmail.com','Animateur','Très bon accueil, délais respectés et tarifs très intéressants pour les services proposés. Je recommande vivement ZooArcadia !',4,'Sebastien_Cauet.jpg','2024-01-14 20:36:44',0),(24,'kkkk','hajjriadh@gmail.com','libre','kllkjljljlkj',4,'kkkk.jpg','2024-12-08 14:15:09',0);
/*!40000 ALTER TABLE `avis` ENABLE KEYS */;
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
-- Table structure for table `plats`
--

DROP TABLE IF EXISTS `plats`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `plats` (
  `idPlats` int NOT NULL AUTO_INCREMENT,
  `Platscol` varchar(255) NOT NULL,
  `description` tinytext NOT NULL,
  `prix` float NOT NULL,
  `image` varchar(255) NOT NULL,
  PRIMARY KEY (`idPlats`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `plats`
--

LOCK TABLES `plats` WRITE;
/*!40000 ALTER TABLE `plats` DISABLE KEYS */;
/*!40000 ALTER TABLE `plats` ENABLE KEYS */;
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
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_0900_ai_ci;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `races`
--

LOCK TABLES `races` WRITE;
/*!40000 ALTER TABLE `races` DISABLE KEYS */;
INSERT INTO `races` VALUES (1,'Lion d’Afrique','2024-11-09 06:41:03','2024-11-09 06:41:03'),(2,'Éléphant d’Asie','2024-11-09 06:41:03','2024-11-09 06:41:03'),(3,'Chameau arabe','2024-11-09 06:41:03','2024-11-09 06:41:03'),(4,'Koala','2024-11-09 08:01:42','2024-11-09 08:01:42'),(5,'Kangourou','2024-11-09 08:01:42','2024-11-09 08:01:42'),(6,'Lion','2024-11-09 08:06:39','2024-11-09 08:06:39'),(7,'Tigre','2024-11-09 08:06:39','2024-11-09 08:06:39'),(8,'Éléphant','2024-11-09 08:06:39','2024-11-09 08:06:39'),(9,'Singe','2024-11-09 08:06:39','2024-11-09 08:06:39'),(10,'Caméléon','2024-11-09 08:06:39','2024-11-09 08:06:39'),(11,'Lézard','2024-11-09 08:06:39','2024-11-09 08:06:39');
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

-- Dump completed on 2024-12-22  9:40:00
