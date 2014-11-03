CREATE TABLE users (
user_id serial,
login text,
password text
);
CREATE TABLE users_privilieges (
priviliege_id integer,
user_id integer,
description text
);
CREATE TABLE privilieges (
priviliege_id serial,
name text
);