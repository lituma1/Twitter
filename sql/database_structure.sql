/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Author:  pp
 * Created: 2016-11-26
 */

CREATE DATABASE twitter; 
CREATE TABLE Users (id INT unsigned NOT NULL auto_increment, email VARCHAR(255) UNIQUE, username VARCHAR(255), hashed_password VARCHAR(255), PRIMARY KEY(id));
CREATE TABLE Tweet (id INT unsigned NOT NULL auto_increment, user_id INT unsigned NOT NULL, tweet_text VARCHAR(140), PRIMARY KEY(id), FOREIGN KEY(user_id) REFERENCES Users(id) ON DELETE CASCADE);
ALTER TABLE Tweet ADD creation_date DATETIME;
INSERT INTO Users (username, email, hashed_password) VALUES('$this->username', '$this->email', '$this->hashedPassword');
UPDATE Users SET username = '$this->username', email = '$this->email',hashed_password = '$this->hashedPassword' WHERE id= $this->id;
SELECT * FROM Users
SELECT id, username, email, hashed_password FROM Users WHERE id=$id;
DELETE FROM Users WHERE id=$this->id;