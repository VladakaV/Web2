
CREATE TABLE IF NOT EXISTS users (
    id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    fio varchar(150) NOT NULL DEFAULT '',
    tel varchar(12) NOT NULL DEFAULT '',
    email varchar(50) NOT NULL DEFAULT '',
    birth varchar(11) NOT NULL DEFAULT '',
    radio_sex varchar(10) NOT NULL DEFAULT '',
    biography varchar(255) NOT NULL DEFAULT '', 
    checkbox_agree BOOLEAN NOT NULL DEFAULT FALSE
);

CREATE TABLE IF NOT EXISTS users_and_languages (
    id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    id_user int unsigned NOT NULL DEFAULT 0,
    id_lang int unsigned NOT NULL DEFAULT 0
);

CREATE TABLE IF NOT EXISTS languages (
    id int unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    name varchar(50) NOT NULL DEFAULT ''
);

INSERT INTO languages (name) VALUES ('1');
INSERT INTO languages (name) VALUES ('2');
INSERT INTO languages (name) VALUES ('3');
INSERT INTO languages (name) VALUES ('4');
INSERT INTO languages (name) VALUES ('5');
INSERT INTO languages (name) VALUES ('6');
INSERT INTO languages (name) VALUES ('7');
INSERT INTO languages (name) VALUES ('8');
INSERT INTO languages (name) VALUES ('9');
INSERT INTO languages (name) VALUES ('10');
INSERT INTO languages (name) VALUES ('11');

