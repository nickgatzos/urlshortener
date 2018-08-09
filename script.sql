DROP DATABASE IF EXISTS urlshortener;
CREATE DATABASE urlshortener;
USE urlshortener;

CREATE TABLE sites (
  title        VARCHAR(25),
  og_url       TEXT,
  redirect_url VARCHAR(60),
  PRIMARY KEY (title)
);

