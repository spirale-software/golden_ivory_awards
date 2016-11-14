t_categorie	CREATE TABLE `t_categorie` (
 `categorie_id` int(11) NOT NULL AUTO_INCREMENT,
 `libelle` varchar(255) NOT NULL,
 PRIMARY KEY (`categorie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
t_honneur	CREATE TABLE `t_honneur` (
 `honneur_id` int(11) NOT NULL AUTO_INCREMENT,
 `libelle` varchar(255) NOT NULL,
 `descriptif` text NOT NULL,
 `gagnant_fk` int(11) DEFAULT NULL,
 `categorie_fk` int(11) NOT NULL,
 PRIMARY KEY (`honneur_id`),
 KEY `gagnant_fk` (`gagnant_fk`),
 KEY `categorie_fk` (`categorie_fk`),
 CONSTRAINT `t_honneur_ibfk_1` FOREIGN KEY (`gagnant_fk`) REFERENCES `t_nomine` (`nomine_id`),
 CONSTRAINT `t_honneur_ibfk_2` FOREIGN KEY (`categorie_fk`) REFERENCES `t_categorie` (`categorie_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
t_image	CREATE TABLE `t_image` (
 `image_id` int(11) NOT NULL AUTO_INCREMENT,
 `fileName` varchar(255) NOT NULL,
 `nomine_fk` int(11) DEFAULT NULL,
 `honneur_fk` int(11) DEFAULT NULL,
 PRIMARY KEY (`image_id`),
 KEY `nomine_fk` (`nomine_fk`),
 KEY `honneur_fk` (`honneur_fk`),
 CONSTRAINT `t_image_ibfk_1` FOREIGN KEY (`nomine_fk`) REFERENCES `t_nomine` (`nomine_id`),
 CONSTRAINT `t_image_ibfk_2` FOREIGN KEY (`honneur_fk`) REFERENCES `t_honneur` (`honneur_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
t_nomine	CREATE TABLE `t_nomine` (
 `nomine_id` int(11) NOT NULL AUTO_INCREMENT,
 `nom` varchar(255) NOT NULL,
 `descriptif` text NOT NULL,
 `actualite` text NOT NULL,
 `categorie_fk` int(11) NOT NULL,
 PRIMARY KEY (`nomine_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
t_user	CREATE TABLE `t_user` (
 `user_id` int(11) NOT NULL AUTO_INCREMENT,
 `prenom` varchar(255) NOT NULL,
 `email` varchar(255) NOT NULL,
 `pwd` varchar(255) NOT NULL,
 `salt` varchar(255) NOT NULL,
 `role` enum('ROLE_USER','ROLE_ADMIN','','') NOT NULL,
 PRIMARY KEY (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8
t_vote	CREATE TABLE `t_vote` (
 `vote_id` int(11) NOT NULL AUTO_INCREMENT,
 `nomine_fk` int(11) NOT NULL,
 `user_fk` int(11) NOT NULL,
 PRIMARY KEY (`vote_id`),
 KEY `nomine_fk` (`nomine_fk`),
 KEY `user_fk` (`user_fk`),
 CONSTRAINT `t_vote_ibfk_1` FOREIGN KEY (`nomine_fk`) REFERENCES `t_nomine` (`nomine_id`),
 CONSTRAINT `t_vote_ibfk_2` FOREIGN KEY (`user_fk`) REFERENCES `t_user` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8