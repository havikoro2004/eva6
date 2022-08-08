/** Creation de l'user "Maddy_11" qui a le rôle manager avec Tous les droits sur la base de donnée **/
CREATE USER 'Maddy11'@'localhost' IDENTIFIED BY '$2y$10$PSdPi3vgnGjF5tYk71hqq.5iQ9hsN3e0KHZ5aJQhtkhfT6ftUX8Bi';
GRANT ALL
    ON kgb.*
    TO 'Maddy11'@'localhost';

/** Creation de l'user Jenine02 qui a le rôle de Lecture seul des tables suivantes contact,speciality,agent,hideout par exemple **/
CREATE USER 'Jenine02'@'localhost' IDENTIFIED BY '$2y$10$9Mqq.W/fSYlL4wVuYWmqb.TbF2pQDvk1HwEfcYZD59DRiLLNzmkla';
GRANT SELECT
    ON kgb.contact
    TO 'Jenine02'@'localhost';
GRANT SELECT
    ON kgb.speciality
    TO 'Jenine02'@'localhost';
GRANT SELECT
    ON kgb.agent
    TO 'Jenine02'@'localhost';
GRANT SELECT
    ON kgb.hideout
    TO 'Jenine02'@'localhost';