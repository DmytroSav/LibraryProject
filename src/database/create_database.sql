
-- CREATE A 'library_app' DATABASE:

CREATE DATABASE library_app;

-- SWITCH TO CREATED DATABASE:

USE library_app;

-- ADD 'library' TABLE:

CREATE TABLE library (
id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
book_name varchar(255)
);

-- ADD SOME DATA SO THE FIRST USER WILL HAVE A FEW BOOKS LISTED

INSERT INTO library (user_id, book_name) values
(1, 'Kurt Vonnegut Galapogoses'),
(1, 'Richard Dawkins Selfish gene'),
(2, 'Stephen King Doctor Sleep'),
(2, 'Stephen King It'),
(3, 'Jorje Borjes The send Book'),
(3, 'Ein Reynd Atlas shrugged');
