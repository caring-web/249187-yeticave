CREATE DATABASE yeticave
  DEFAULT CHARACTER SET utf8
  DEFAULT COLLATE utf8_general_ci;
USE yeticave;

CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category CHAR(128) NOT NULL
);

CREATE TABLE lots (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name CHAR(128) NOT NULL,
  category_id INT NOT NULL,
  date_start TIMESTAMP NOT NULL,
  description TEXT NOT NULL,
  img_lot CHAR(255),
  start_price INT NOT NULL,
  date_end TIMESTAMP,
  bet_step INT NOT NULL,
  user_id INT NOT NULL,
  winner_id INT
);

CREATE TABLE bets (
  id INT AUTO_INCREMENT PRIMARY KEY,
  bet_amount INT NOT NULL,
  date_bet TIMESTAMP NOT NULL,
  user_id INT NOT NULL,
  lot_id INT NOT NULL
);

CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  registration_date TIMESTAMP NOT NULL,
  email_user CHAR(128) NOT NULL UNIQUE,
  name_user CHAR(128) NOT NULL,
  password_user CHAR(64) NOT NULL,
  avatar_user CHAR(255),
  contacts_user CHAR(128)
);
