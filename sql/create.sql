
create table especes(
    id int primary key not null auto_increment,
    libelle varchar(100) not null
);

create table regions(
    id int primary key not null auto_increment,
    nom varchar(100) not null
);

create table roles(
    id int primary key not null auto_increment,
    libelle varchar(100) not null
);

create table genres(
    id int primary key not null auto_increment,
    libelle varchar(100) not null
);

create table ressources(
    id int primary key not null auto_increment,
    libelle varchar(100) not null
);

create table portees(
    id int primary key not null auto_increment,
    libelle varchar(100) not null
);

create table champions(
    id int primary key not null auto_increment,
    nom varchar(50) not null,
    annee int not null,
    image text,
    
    fk_genre int not null,
    FOREIGN KEY (fk_genre) REFERENCES genres(id),
    fk_ressource int not null,
    FOREIGN KEY (fk_ressource) REFERENCES ressources(id)
);

CREATE TABLE appartenir (
    champion_id INT NOT NULL,
    espece_id INT NOT NULL,

    PRIMARY KEY (champion_id, espece_id),
    FOREIGN KEY (champion_id) REFERENCES champions(id), 
    FOREIGN KEY (espece_id) REFERENCES especes(id)
);

create table venir(
    champion_id int not null,
    region_id int not null,

    PRIMARY KEY (champion_id, region_id),
    FOREIGN KEY (champion_id) REFERENCES champions(id),
    FOREIGN KEY (region_id) REFERENCES regions(id)
);

create table jouer(
    champion_id int not null,
    role_id int not null,

    PRIMARY KEY (champion_id, role_id),
    FOREIGN KEY (champion_id) REFERENCES champions(id),
    FOREIGN KEY (role_id) REFERENCES roles(id)    
);

create table AVOIR (
    champion_id int not null,
    portee_id int not null,

    PRIMARY KEY (champion_id, portee_id),
    FOREIGN KEY (champion_id) REFERENCES champions(id),
    FOREIGN KEY (portee_id) REFERENCES portees(id)
);