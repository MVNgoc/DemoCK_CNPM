CREATE DATABASE IF NOT EXISTS restaurant DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci;
USE restaurant;

CREATE TABLE admin_account (
  id varchar(15) NOT NULL,
  username varchar(64) NOT NULL,
  pass varchar(255) NOT NULL
);

CREATE TABLE user (
  id varchar(15) NOT NULL,
  email varchar(64) NOT NULL,
  pass varchar(255) NOT NULL,
  username varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  phone_number varchar(15) NOT NULL,
  user_address varchar(255) COLLATE utf8_unicode_ci NOT NULL
);

CREATE TABLE category (
  id varchar(15) NOT NULL,
  title varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  img_name varchar(225) COLLATE utf8_unicode_ci DEFAULT 'food-placeholder.png',
  featured varchar(225) COLLATE utf8_unicode_ci NOT NULL
);

CREATE TABLE food_order (
  id varchar(15) NOT NULL,
  food_name varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  img_food varchar(225) COLLATE utf8_unicode_ci DEFAULT 'food-placeholder.png',
  quantity int(10) NOT NULL,
  username varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  phone_number varchar(15) NOT NULL,
  email varchar(64) NOT NULL,
  user_address varchar(255) COLLATE utf8_unicode_ci NOT NULL
);

CREATE TABLE food (
  id varchar(15) NOT NULL,
  title varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  img_food varchar(225) COLLATE utf8_unicode_ci DEFAULT 'food-placeholder.png',
  description_food varchar(225) COLLATE utf8_unicode_ci NOT NULL,
  price int(255) NOT NULL,
  category_name varchar(64) COLLATE utf8_unicode_ci NOT NULL
);

INSERT INTO admin_account (id, username, pass) VALUES
('51900147', 'admin', '$2a$12$W2.bMpn35X9w/uQpeDWnkOVIYVnYYzpya5r1ySc5AoGOkjj353mcO');

ALTER TABLE admin_account
  ADD PRIMARY KEY (id);

ALTER TABLE admin_account
  MODIFY id int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;

ALTER TABLE user
  ADD PRIMARY KEY (id);

ALTER TABLE user
  MODIFY id int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;

ALTER TABLE category
ADD PRIMARY KEY (id);

ALTER TABLE category
  MODIFY id int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;

ALTER TABLE food_order
ADD PRIMARY KEY (id);

ALTER TABLE food_order
MODIFY id int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;

ALTER TABLE food
ADD PRIMARY KEY (id);

ALTER TABLE food
  MODIFY id int(11) NOT NULL AUTO_INCREMENT COMMENT 'id', AUTO_INCREMENT=1;