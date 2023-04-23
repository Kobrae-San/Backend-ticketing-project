CREATE DATABASE authentification;
USE authentification;



CREATE TABLE users (
    id INT NOT NULL AUTO_INCREMENT,
    login VARCHAR(32) NOT NULL,
    password VARCHAR(64) NOT NULL,
    PRIMARY KEY (id)
);


CREATE TABLE token (
    id INT NOT NULL AUTO_INCREMENT,
    user_id INT NOT NULL,
    token VARCHAR(255) NOT NULL,
    PRIMARY KEY (id),
    FOREIGN KEY (user_id) REFERENCES users(id)
);