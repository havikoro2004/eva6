/** Supprimer la base de donnée du nom teste si elle existe **/
DROP SCHEMA IF EXISTS teste;

    /** Création de la base de donnée du nom teste  **/
    CREATE SCHEMA IF NOT EXISTS teste CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ;

        /**  Création des tables selon l'ordre  **/
        CREATE TABLE teste.user (
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            firstName VARCHAR(255) NOT NULL ,
            lastName VARCHAR(255) NOT NULL ,
            email VARCHAR(255) NOT NULL ,
            password VARCHAR(255) NOT NULL ,
            createdAt DATETIME NOT NULL
        ) ENGINE=InnoDB;

        CREATE TABLE teste.speciality(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            name VARCHAR(255) NOT NULL
        )ENGINE=InnoDB;

        CREATE TABLE teste.mission_type (
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            name VARCHAR(255) NOT NULL
        )ENGINE=InnoDB;

        CREATE TABLE teste.status(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            name VARCHAR(255) NOT NULL
        )ENGINE=InnoDB;

        CREATE TABLE teste.planque_type(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            name VARCHAR(255) NOT NULL
        )ENGINE=InnoDB;

        CREATE TABLE teste.mission(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            code VARCHAR(255) NOT NULL,
            title VARCHAR(255) NOT NULL ,
            description TEXT NOT NULL ,
            country VARCHAR(255) NOT NULL ,
            dateDebut DATE NOT NULL ,
            dateFin DATE NOT NULL ,
            type INT(10) NOT NULL ,
            status INT(10) NOT NULL ,
            speciality INT(10) NOT NULL ,
            FOREIGN KEY (type) REFERENCES mission_type(id),
            FOREIGN KEY (status) REFERENCES status(id),
            FOREIGN KEY (speciality) REFERENCES speciality(id)
        )ENGINE=InnoDB;

        CREATE TABLE teste.agent(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            firstName VARCHAR(255) NOT NULL ,
            lastName VARCHAR(255) NOT NULL ,
            birthDay DATE NOT NULL ,
            code VARCHAR(255) NOT NULL  ,
            nationality VARCHAR(255) NOT NULL 
        )ENGINE=InnoDB;

        CREATE TABLE teste.agent_speciality(
            agenId INT(10) NOT NULL ,
            specialityId INT(10) NOT NULL ,
            PRIMARY KEY (agenId,specialityId),
            FOREIGN KEY (agenId) REFERENCES agent(id),
            FOREIGN KEY (specialityId) REFERENCES speciality(id)
        )ENGINE=InnoDB;

        CREATE TABLE teste.agent_mission(
            agenId INT(10) NOT NULL ,
            missionId INT(10) NOT NULL ,
            PRIMARY KEY (agenId,missionId),
            FOREIGN KEY (agenId) REFERENCES agent(id),
            FOREIGN KEY (missionId) REFERENCES mission(id)
        )ENGINE=InnoDB;

        CREATE TABLE teste.contact(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            firstName VARCHAR(255) NOT NULL ,
            lastName VARCHAR(255) NOT NULL ,
            birthDay DATE NOT NULL ,
            code VARCHAR(255) NOT NULL  ,
            nationality VARCHAR(255) NOT NULL 
        )ENGINE=InnoDB;

        CREATE TABLE teste.contact_mission(
            missionId INT(10) NOT NULL ,
            contactId INT(10) NOT NULL ,
            PRIMARY KEY (missionId,contactId),
            FOREIGN KEY (missionId) REFERENCES mission(id),
            FOREIGN KEY (contactId) REFERENCES contact(id)
        )ENGINE=InnoDB;

        CREATE TABLE teste.target(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            firstName VARCHAR(255) NOT NULL ,
            lastName VARCHAR(255) NOT NULL ,
            birthDay DATE NOT NULL ,
            code VARCHAR(255) NOT NULL  ,
            nationality VARCHAR(255) NOT NULL ,
            mission INT(10) ,
            FOREIGN KEY (mission) REFERENCES mission(id)
        )ENGINE=InnoDB;

        CREATE TABLE teste.planque(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            name VARCHAR(255) NOT NULL ,
            adresse TEXT NOT NULL ,
            country VARCHAR(255) NOT NULL ,
            type INT(10) NOT NULL ,
            mission INT(10) NOT NULL ,
            FOREIGN KEY (type) REFERENCES planque_type(id),
            FOREIGN KEY (mission) REFERENCES mission(id)
        )ENGINE=InnoDB;

