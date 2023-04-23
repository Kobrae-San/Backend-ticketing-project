CREATE DATABASE authentification;
USE authentification;



CREATE TABLE users (
    id INT(11) NOT NULL AUTO_INCREMENT,
    login VARCHAR(32) NOT NULL,
    password VARCHAR(255) NOT NULL,
    CONSTRAINT pk_user PRIMARY KEY (`user`)
) ENGINE=InnoDB;


CREATE TABLE token (
    user_id INT(11) NOT NULL,
    token VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    CONSTRAINT fk_user FOREIGN KEY (`id`)
) ENGINE=InnoDB;    