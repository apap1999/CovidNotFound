CREATE DATABASE covid;
USE covid;

CREATE TABLE IF NOT EXISTS users
(
    user_id INTEGER NOT NULL AUTO_INCREMENT,
    name VARCHAR(100),
    surname VARCHAR(100),
    email VARCHAR(100) NOT NULL,
    password TEXT NOT NULL,
    is_admin BOOLEAN NOT NULL DEFAULT 0,
    PRIMARY KEY (user_id)
);

CREATE TABLE IF NOT EXISTS pois
(
    poi_id CHAR(27) NOT NULL,
    name TEXT,
    address TEXT,
    latitude FLOAT,
    longitude FLOAT,
    rating INTEGER,
    rating_n INTEGER,
    populartimes TEXT,
    PRIMARY KEY (poi_id)
);

CREATE TABLE IF NOT EXISTS types
(
    type_id INTEGER NOT NULL AUTO_INCREMENT,
    name TEXT NOT NULL,
    PRIMARY KEY (type_id)
);

CREATE TABLE IF NOT EXISTS pois_type
(
    poi_id CHAR(27) NOT NULL,
    type_id INTEGER NOT NULL,
    PRIMARY KEY (poi_id, type_id),
    FOREIGN KEY (poi_id)    REFERENCES pois (poi_id),
    FOREIGN KEY (type_id)    REFERENCES types (type_id)
);

CREATE TABLE IF NOT EXISTS visits
(
    visit_id INTEGER NOT NULL AUTO_INCREMENT,
    user_id INTEGER NOT NULL,
    poi_id CHAR(27) NOT NULL,
    visit_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    estimation INT NOT NULL,
    PRIMARY KEY (visit_id),
    FOREIGN KEY (poi_id)    REFERENCES pois (poi_id),
    FOREIGN KEY (user_id)    REFERENCES users (user_id)
);

CREATE TABLE IF NOT EXISTS covid_cases
(
    case_id INTEGER NOT NULL AUTO_INCREMENT,
    user_id INTEGER NOT NULL,
    date DATE DEFAULT '2020-01-01',
    PRIMARY KEY (case_id),
    FOREIGN KEY (user_id)    REFERENCES users (user_id)
);