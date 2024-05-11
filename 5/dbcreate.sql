CREATE TABLE IF NOT EXISTS login_and_password (
    id int(10) unsigned NOT NULL AUTO_INCREMENT PRIMARY KEY,
    login varchar(40) NOT NULL DEFAULT '',
    password varchar(40) NOT NULL DEFAULT ''
);