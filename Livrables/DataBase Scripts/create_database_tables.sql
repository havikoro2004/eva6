/** Supprimer la base de donnée du nom kgb si elle existe **/
DROP SCHEMA IF EXISTS kgb;

    /** Création de la base de donnée du nom kgb  **/
    CREATE SCHEMA IF NOT EXISTS kgb CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci ;

        /**  Création des tables selon l'ordre  **/
        CREATE TABLE kgb.user (
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            firstName VARCHAR(255) NOT NULL ,
            lastName VARCHAR(255) NOT NULL ,
            email VARCHAR(255) NOT NULL ,
            password VARCHAR(255) NOT NULL ,
            createdAt DATETIME NOT NULL
        ) ENGINE=InnoDB;

        CREATE TABLE kgb.speciality(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            name VARCHAR(255) NOT NULL
        )ENGINE=InnoDB;

        CREATE TABLE kgb.mission_type (
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            name VARCHAR(255) NOT NULL
        )ENGINE=InnoDB;

        CREATE TABLE kgb.status(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            name VARCHAR(255) NOT NULL
        )ENGINE=InnoDB;

        CREATE TABLE kgb.planque_type(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            name VARCHAR(255) NOT NULL
        )ENGINE=InnoDB;

        
        CREATE TABLE kgb.agent(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            firstName VARCHAR(255) NOT NULL ,
            lastName VARCHAR(255) NOT NULL ,
            birthDay DATE NOT NULL ,
            code VARCHAR(255) NOT NULL  ,
            nationality VARCHAR(255) NOT NULL 
        )ENGINE=InnoDB;
        
        CREATE TABLE kgb.agent_speciality(
            agenId INT(10) NOT NULL ,
            specialityId INT(10) NOT NULL ,
            PRIMARY KEY (agenId,specialityId),
            FOREIGN KEY (agenId) REFERENCES agent(id),
            FOREIGN KEY (specialityId) REFERENCES speciality(id)
        )ENGINE=InnoDB;
        
        CREATE TABLE kgb.contact(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            firstName VARCHAR(255) NOT NULL ,
            lastName VARCHAR(255) NOT NULL ,
            birthDay DATE NOT NULL ,
            code VARCHAR(255) NOT NULL  ,
            nationality VARCHAR(255) NOT NULL 
        )ENGINE=InnoDB;

               CREATE TABLE kgb.planque(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            name VARCHAR(255) NOT NULL ,
            adresse TEXT NOT NULL ,
            country VARCHAR(255) NOT NULL ,
            type INT(10) NOT NULL ,
            FOREIGN KEY (type) REFERENCES planque_type(id)
        )ENGINE=InnoDB;
        
        CREATE TABLE kgb.target(
            id INT(10) NOT NULL AUTO_INCREMENT PRIMARY KEY ,
            firstName VARCHAR(255) NOT NULL ,
            lastName VARCHAR(255) NOT NULL ,
            birthDay DATE NOT NULL ,
            code VARCHAR(255) NOT NULL  ,
            nationality VARCHAR(255) NOT NULL 
        )ENGINE=InnoDB;

        CREATE TABLE kgb.mission(
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

        CREATE TABLE kgb.agent_mission(
            agenId INT(10) NOT NULL ,
            missionId INT(10) NOT NULL ,
            PRIMARY KEY (agenId,missionId),
            FOREIGN KEY (agenId) REFERENCES agent(id),
            FOREIGN KEY (missionId) REFERENCES mission(id)
        )ENGINE=InnoDB;

        CREATE TABLE kgb.target_mission(
            targetId INT(10) NOT NULL ,
            missionId INT(10) NOT NULL ,
            PRIMARY KEY (targetId,missionId),
            FOREIGN KEY (targetId) REFERENCES target(id),
            FOREIGN KEY (missionId) REFERENCES mission(id)
        )ENGINE=InnoDB;

        
        CREATE TABLE kgb.planque_mission(
            planqueId INT(10) NOT NULL ,
            missionId INT(10) NOT NULL ,
            PRIMARY KEY (planqueId,missionId),
            FOREIGN KEY (planqueId) REFERENCES planque(id),
            FOREIGN KEY (missionId) REFERENCES mission(id)
        )ENGINE=InnoDB;

        CREATE TABLE kgb.contact_mission(
            missionId INT(10) NOT NULL ,
            contactId INT(10) NOT NULL ,
            PRIMARY KEY (missionId,contactId),
            FOREIGN KEY (missionId) REFERENCES mission(id),
            FOREIGN KEY (contactId) REFERENCES contact(id)
        )ENGINE=InnoDB;


 

