/** ***************** Insertion des tables executable en même temps ******************** **/
/** Table admin **/
INSERT INTO user (firstName, lastName, email, password, createdAt) VALUES
('najib','flata','havikoro2004@gmail.com','$2y$10$7HeFCHLE8gmlYF6s/xSEfej0H9ZjrGxLsoJA2OzWapaWuV6VJPDtC',NOW()),
('yassine','ramy','kilikou@gmail.com','$fy$10$7HeFCHLE8gmlYF6s/xSEfej0H9ZjrGxLsoJA2OzWapaWuV6VJPDtC',NOW()),
('chakib','mandi','lil_chak@gmail.com','$2y$10$7HeFCHLE8gmlYF64/xSEfej0H9ZjrGxLsoJA2OzWapaWuV6VJPDtC',NOW()),
('kamal','rwiha','rwiha@gmail.com','5dlf10$7HeFCHLE8gmlYF6s/xSEfej0H9ZjrGxLsoJA2OzWapaWuV6VJPDtC',NOW());

/** Table speciality **/
INSERT INTO speciality (name) VALUES ('avion'),('chasse à l\'homme'),('Jeux combat');

/** Table mission_type **/
INSERT INTO mission_type (name) VALUES ('jungle'),('iles de kaka'),('verdunsk');

/** Table status **/
INSERT INTO status (name) VALUES ('en cours'),('terminée'),('echec');

/** Table planque_type **/
INSERT INTO planque_type (name) VALUES ('maroc'),('asie'),('italie');

/** Table mission **/
INSERT INTO mission (code, title, description, country, dateDebut, dateFin, type, status, speciality) VALUES
('20231','verdon','dans un coin de ...','France','2022-06-20','2024-02-05',1,1,1),
('zedz22','Ossova','kill le maitre ...','USA','2023-06-20','2023-12-05',2,2,2),
('202zzed31','zulu','Zulu est un membre de...','UK','2022-06-20','2024-02-24',1,1,1);

/** Table agent **/
INSERT INTO agent (firstName, lastName, birthDay, code, nationality) VALUES
('mala','amine','1990-02-23','malabo','Francaise'),
('koka','badih','1982-02-07','bunkuk','Germagny'),
('zola','marime','1980-02-23','nunga','niger'),
('karim','jean','1979-01-10','nunga','niger');

/** Table agent_speciality **/
INSERT INTO agent_speciality (agenId, specialityId) VALUES (2,1),(2,2),(3,1),(4,3);

/** Table agent_mission **/
INSERT INTO agent_mission (agenId, missionId) VALUES (2,1),(2,2),(3,1),(4,3);

/** Table contact **/
INSERT INTO contact (firstName, lastName, birthDay, code, nationality) VALUES
('Mr bein','Joe','1990-02-16','2013z','Quebecoise'),
('Alpimp','borak','1982-02-04','sedzed','Marocaine'),
('Jean','Senna','1975-12-16','xsqq','Francaise'),
('Jean baptiste','kora','1975-12-16','azsazsz','Francaise');

/** Table contact_mission **/
INSERT INTO contact_mission (contactId, missionId) VALUES (2,1),(2,2),(3,1),(4,3);

/** Table target **/
INSERT INTO target (firstName, lastName, birthDay, code, nationality, mission) VALUES
('emile','zola','1990-12-02','05zfer','italienne','1'),
('zata','morkov','1992-05-13','zedzed','russe','2'),
('Najat','bassla','1874-06-03','05zfer','marocaine','1');

/** Table planque **/
INSERT INTO planque (name, adresse, country, type, mission) VALUES
('ruch','106 impasse de la kokat 74144 ','france',1,1),
('baltek','2013 avenue saint pierre 74144 ','usa',2,2),
('ruch','106 impasse de la malto 74144 ','uk',3,3);




