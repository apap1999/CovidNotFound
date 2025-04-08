CREATE DATABASE covid;

BEGIN TRANSACTION;

CREATE TABLE IF NOT EXISTS public.users
(
    user_id serial NOT NULL,
    name character varying(100),
    surname character varying(100),
    email character varying(100) NOT NULL,
    password text NOT NULL,
    is_admin boolean NOT NULL DEFAULT false,
    PRIMARY KEY (user_id)
);

CREATE TABLE IF NOT EXISTS public.pois
(
    poi_id character(27) NOT NULL,
    name text,
    address text,
    rating integer,
    rating_n integer,
    populartimes text,
    PRIMARY KEY (poi_id)
);

CREATE TABLE IF NOT EXISTS public.coords
(
    poi_id character(27) NOT NULL,
    latitude real NOT NULL,
    longitude real NOT NULL,
    PRIMARY KEY (poi_id),
    CONSTRAINT poi_id FOREIGN KEY (poi_id)
    REFERENCES public.pois (poi_id)
);

CREATE TABLE IF NOT EXISTS public.types
(
    type_id serial NOT NULL,
    name text NOT NULL,
    PRIMARY KEY (type_id)
);

CREATE TABLE IF NOT EXISTS public.pois_type
(
    poi_id character(27) NOT NULL,
    type_id integer NOT NULL,
    PRIMARY KEY (poi_id, type_id),
    CONSTRAINT poi_id FOREIGN KEY (poi_id)
    REFERENCES public.pois (poi_id),
    CONSTRAINT type_id FOREIGN KEY (type_id)
    REFERENCES public.types (type_id)
);

CREATE TABLE IF NOT EXISTS public.visits
(
    visit_id serial NOT NULL,
    user_id integer NOT NULL,
    poi_id character(27) NOT NULL,
    visit_time timestamp without time zone DEFAULT '2020-01-01 00:00:00-00',
    PRIMARY KEY (visit_id),
    CONSTRAINT poi_id FOREIGN KEY (poi_id)
    REFERENCES public.pois (poi_id),
    CONSTRAINT user_id FOREIGN KEY (user_id)
    REFERENCES public.users (user_id)
);

CREATE TABLE IF NOT EXISTS public.covid_cases
(
    case_id serial NOT NULL,
    user_id integer NOT NULL,
    date date DEFAULT '2020-01-01',
    PRIMARY KEY (case_id),
    CONSTRAINT user_id FOREIGN KEY (user_id)
    REFERENCES public.users (user_id)
);

--  COMMIT
--  ROLLBACK