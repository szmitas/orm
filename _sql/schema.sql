CREATE TABLE users (
user_id serial PRIMARY KEY,
login text,
password text
);

CREATE TABLE "privileges" (
privilege_id serial,
"name" text DEFAULT 'maciej',
PRIMARY KEY (privilege_id)
);

CREATE TABLE users_privileges (
privilege_id integer REFERENCES privileges (privilege_id),
user_id integer  REFERENCES users (user_id),
description text,
UNIQUE (user_id, privilege_id)
);