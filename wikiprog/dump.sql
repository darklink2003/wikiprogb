-- MySQL dump 10.13  Distrib 8.0.34, for Win64 (x86_64)
--
-- Host: 127.0.0.1    Database: wikiprog
-- ------------------------------------------------------
-- Server version	5.5.5-10.4.20-MariaDB

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
-- Table structure for table `archivo`
--

DROP TABLE IF EXISTS `archivo`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `archivo` (
  `archivo_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `nombre_archivo` varchar(45) DEFAULT NULL,
  `tamaño` varchar(45) DEFAULT NULL,
  `privacidad_id` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `archivo` longtext NOT NULL,
  PRIMARY KEY (`archivo_id`),
  KEY `usuario_id` (`usuario_id`),
  KEY `privacidad_id` (`privacidad_id`),
  CONSTRAINT `archivo_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`),
  CONSTRAINT `archivo_ibfk_2` FOREIGN KEY (`privacidad_id`) REFERENCES `privacidad` (`privacidad_id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `archivo`
--

LOCK TABLES `archivo` WRITE;
/*!40000 ALTER TABLE `archivo` DISABLE KEYS */;
/*!40000 ALTER TABLE `archivo` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `categoria`
--

DROP TABLE IF EXISTS `categoria`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `categoria` (
  `categoria_id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`categoria_id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `categoria`
--

LOCK TABLES `categoria` WRITE;
/*!40000 ALTER TABLE `categoria` DISABLE KEYS */;
INSERT INTO `categoria` VALUES (1,'Codigo','2024-05-31 21:36:38'),(2,'Logica del programador','2024-05-31 21:36:38'),(3,'Estilo','2024-05-31 21:36:38'),(4,'Base de datos','2024-05-31 21:36:38'),(5,'otro','2024-05-31 21:36:38'),(6,'jax','2024-06-12 17:21:57');
/*!40000 ALTER TABLE `categoria` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `comentario`
--

DROP TABLE IF EXISTS `comentario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `comentario` (
  `comentario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `curso_id` int(11) NOT NULL,
  `comentario` text NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`comentario_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `comentario_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `comentario`
--

LOCK TABLES `comentario` WRITE;
/*!40000 ALTER TABLE `comentario` DISABLE KEYS */;
INSERT INTO `comentario` VALUES (1,14,33,'xd','2024-06-27 12:52:43'),(2,14,26,'hola','2024-06-27 15:46:55'),(3,21,32,'5151','2024-07-04 21:52:10'),(4,21,1,'asdsd','2024-07-04 22:03:17'),(5,21,1,'asdsd','2024-07-04 22:05:54'),(6,21,1,'ghghgh','2024-07-04 22:12:12'),(7,21,1,'asdsadqwewewe','2024-07-04 22:13:04'),(8,21,27,'asdsadfxzcxc','2024-07-04 22:18:08'),(9,21,36,'56161','2024-07-05 02:17:50'),(10,21,27,'123123132','2024-07-05 02:46:15'),(11,21,27,'gfsd','2024-07-05 16:15:14'),(12,21,27,'hola','2024-07-05 16:41:02'),(13,21,29,'xd','2024-07-07 23:18:50');
/*!40000 ALTER TABLE `comentario` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `curso`
--

DROP TABLE IF EXISTS `curso`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `curso` (
  `curso_id` int(11) NOT NULL AUTO_INCREMENT,
  `titulo_curso` varchar(30) DEFAULT NULL,
  `descripcion` varchar(45) DEFAULT NULL,
  `categoria_id` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `megusta` int(11) NOT NULL DEFAULT 0,
  `dislike` int(11) NOT NULL DEFAULT 0,
  `usuario_id` int(11) NOT NULL,
  PRIMARY KEY (`curso_id`),
  KEY `categoria_id` (`categoria_id`),
  KEY `curso_ibfk_usuario` (`usuario_id`),
  CONSTRAINT `curso_ibfk_1` FOREIGN KEY (`categoria_id`) REFERENCES `categoria` (`categoria_id`),
  CONSTRAINT `curso_ibfk_usuario` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB AUTO_INCREMENT=39 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `curso`
--

LOCK TABLES `curso` WRITE;
/*!40000 ALTER TABLE `curso` DISABLE KEYS */;
INSERT INTO `curso` VALUES (27,'asdw','qweqwe',1,'2024-06-11 15:38:56',0,0,14),(28,'motos','rapidos',5,'2024-06-11 15:55:11',0,0,14),(29,'matematicas','numero y cosas',5,'2024-06-17 12:36:47',0,0,14),(32,'español','lenguaje',5,'2024-06-17 12:44:49',0,0,14),(33,'informaticas','compus',1,'2024-06-17 12:59:46',0,0,14),(34,'artes','dibujo',3,'2024-06-21 11:55:08',0,0,14),(35,'youtube ','videos',5,'2024-06-22 20:44:55',0,0,21),(36,'sql','numero y cosas',4,'2024-06-27 16:22:09',0,0,21),(38,'ejemplos','otros',5,'2024-07-02 20:30:05',0,0,21);
/*!40000 ALTER TABLE `curso` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `inscripción`
--

DROP TABLE IF EXISTS `inscripción`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `inscripción` (
  `inscripción_id` int(11) NOT NULL AUTO_INCREMENT,
  `curso_id` int(11) NOT NULL,
  `usuario_id` int(11) NOT NULL,
  `nombre` varchar(50) NOT NULL,
  `nota` int(45) NOT NULL,
  `fecha_registro` datetime NOT NULL,
  PRIMARY KEY (`inscripción_id`),
  KEY `curso_id` (`curso_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `inscripción_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`curso_id`),
  CONSTRAINT `inscripción_ibfk_2` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `inscripción`
--

LOCK TABLES `inscripción` WRITE;
/*!40000 ALTER TABLE `inscripción` DISABLE KEYS */;
/*!40000 ALTER TABLE `inscripción` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `leccion`
--

DROP TABLE IF EXISTS `leccion`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `leccion` (
  `leccion_id` int(11) NOT NULL AUTO_INCREMENT,
  `curso_id` int(11) NOT NULL,
  `titulo_leccion` varchar(255) NOT NULL,
  `contenido` varchar(255) NOT NULL,
  `archivo_leccion` varchar(255) DEFAULT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`leccion_id`),
  KEY `curso_id` (`curso_id`),
  CONSTRAINT `leccion_ibfk_1` FOREIGN KEY (`curso_id`) REFERENCES `curso` (`curso_id`)
) ENGINE=InnoDB AUTO_INCREMENT=41 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `leccion`
--

LOCK TABLES `leccion` WRITE;
/*!40000 ALTER TABLE `leccion` DISABLE KEYS */;
INSERT INTO `leccion` VALUES (24,27,'45654645654','456456456456',NULL,'2024-06-11 15:38:56'),(25,28,'fiau','veloz',NULL,'2024-06-11 15:55:11'),(26,28,'harry','potter',NULL,'2024-06-12 13:10:04'),(27,29,'suma','esta',NULL,'2024-06-17 12:36:47'),(28,29,'resta','con esta ',NULL,'2024-06-17 12:36:47'),(29,32,'letras','y numeor','archivos_leccion/66702fc11f6ae_logica.txt','2024-06-17 12:44:49'),(30,33,'teclado','numerico','archivos_leccion/6670334290376_wikiprog.sql','2024-06-17 12:59:46'),(31,33,'mouse','mover','archivos_leccion/66703342905f9_export1667333521277.mdp','2024-06-17 12:59:46'),(32,34,'trazos','lineas','../archivos_leccion/66756a1bec5d8_descarga (1).jpg','2024-06-21 11:55:08'),(33,35,'tutoriales','loquendo','../archivos_leccion/667737c74b4ed_Pablo_Mondragon.jpg','2024-06-22 20:44:55'),(34,36,'create','crea esta','../archivos_leccion/667d91b10ac1c_ADSO-14 - EV03 ajedrez validaciones v1.py','2024-06-27 16:22:09'),(35,38,'prueba','1','../archivos_leccion/66846b3508203_arnol2.jpg','2024-07-02 20:30:05'),(36,38,'2','2','../archivos_leccion/6684634d8a239_arnol2.jpg','2024-07-02 20:30:05'),(37,38,'3','3','../archivos_leccion/6684634d90621_arnol2.jpg','2024-07-02 20:30:05'),(38,38,'4','4','../archivos_leccion/6684634d90987_arnol2.jpg','2024-07-02 20:30:05'),(39,38,'5','5','../archivos_leccion/6684634d90bd9_arnol2.jpg','2024-07-02 20:30:05'),(40,38,'6','6','../archivos_leccion/6684634d90e19_arnol2.jpg','2024-07-02 20:30:05');
/*!40000 ALTER TABLE `leccion` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `nivel`
--

DROP TABLE IF EXISTS `nivel`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `nivel` (
  `nivel_id` int(11) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(45) NOT NULL,
  `leccion_id` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`nivel_id`),
  KEY `leccion_id` (`leccion_id`),
  CONSTRAINT `nivel_ibfk_1` FOREIGN KEY (`leccion_id`) REFERENCES `leccion` (`leccion_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `nivel`
--

LOCK TABLES `nivel` WRITE;
/*!40000 ALTER TABLE `nivel` DISABLE KEYS */;
/*!40000 ALTER TABLE `nivel` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `privacidad`
--

DROP TABLE IF EXISTS `privacidad`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `privacidad` (
  `privacidad_id` int(11) NOT NULL AUTO_INCREMENT,
  `tipo` varchar(45) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`privacidad_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `privacidad`
--

LOCK TABLES `privacidad` WRITE;
/*!40000 ALTER TABLE `privacidad` DISABLE KEYS */;
/*!40000 ALTER TABLE `privacidad` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `rango`
--

DROP TABLE IF EXISTS `rango`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `rango` (
  `rango_id` int(11) NOT NULL AUTO_INCREMENT,
  `descripcion` varchar(45) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`rango_id`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `rango`
--

LOCK TABLES `rango` WRITE;
/*!40000 ALTER TABLE `rango` DISABLE KEYS */;
INSERT INTO `rango` VALUES (1,'usuario','2024-06-04 12:05:53'),(2,'administrador','2024-06-04 12:05:53'),(3,'evaluador','2024-06-20 16:45:05');
/*!40000 ALTER TABLE `rango` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `registrar`
--

DROP TABLE IF EXISTS `registrar`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `registrar` (
  `registrar_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario_id` int(11) NOT NULL,
  `correo` varchar(100) NOT NULL,
  `contraseña` varchar(255) NOT NULL,
  `terminos_y_condiciones` tinyint(1) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  PRIMARY KEY (`registrar_id`),
  KEY `usuario_id` (`usuario_id`),
  CONSTRAINT `registrar_ibfk_1` FOREIGN KEY (`usuario_id`) REFERENCES `usuario` (`usuario_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `registrar`
--

LOCK TABLES `registrar` WRITE;
/*!40000 ALTER TABLE `registrar` DISABLE KEYS */;
/*!40000 ALTER TABLE `registrar` ENABLE KEYS */;
UNLOCK TABLES;

--
-- Table structure for table `usuario`
--

DROP TABLE IF EXISTS `usuario`;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!50503 SET character_set_client = utf8mb4 */;
CREATE TABLE `usuario` (
  `usuario_id` int(11) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(45) NOT NULL,
  `img_usuario` varchar(45) NOT NULL DEFAULT 'null',
  `correo` varchar(50) NOT NULL,
  `biografia` varchar(45) NOT NULL,
  `contraseña` varchar(45) NOT NULL,
  `rango_id` int(11) NOT NULL,
  `fecha_registro` timestamp NOT NULL DEFAULT current_timestamp(),
  `intentos_fallidos` int(11) DEFAULT 0,
  `cuenta_bloqueada` tinyint(1) DEFAULT 0,
  PRIMARY KEY (`usuario_id`),
  KEY `rango_id` (`rango_id`),
  CONSTRAINT `usuario_ibfk_1` FOREIGN KEY (`rango_id`) REFERENCES `rango` (`rango_id`)
) ENGINE=InnoDB AUTO_INCREMENT=31 DEFAULT CHARSET=utf8mb4;
/*!40101 SET character_set_client = @saved_cs_client */;

--
-- Dumping data for table `usuario`
--

LOCK TABLES `usuario` WRITE;
/*!40000 ALTER TABLE `usuario` DISABLE KEYS */;
INSERT INTO `usuario` VALUES (14,'marzo','','marzo@gmail.com','marzo','marzo2000',1,'2024-06-04 21:20:05',0,0),(16,'mike','Maicol_Sanchez.jpg','mike@gmail.com','soy un programador','mike2003',1,'2024-06-11 16:39:27',0,0),(21,'pablo','arnol2.jpg','pablomondragonacevedo@gmail.com','aaaa','123',2,'2024-06-21 11:59:35',0,0),(27,'juan','null','juan@gmail.com','castalleda','456',1,'2024-06-26 19:13:50',0,0),(29,'julian','null','julian@gmail.com','cine','$2y$10$gbp6yhVUU99ssOGcvpUpCePVviyoikG3JrXPZ7',1,'2024-06-28 15:45:50',0,0),(30,'andres','null','andres@gmail.com','andres','andres',1,'2024-06-28 16:17:05',0,0);
/*!40000 ALTER TABLE `usuario` ENABLE KEYS */;
UNLOCK TABLES;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

-- Dump completed on 2024-07-08 12:13:12
