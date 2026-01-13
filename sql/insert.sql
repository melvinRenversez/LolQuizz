insert into especes (libelle) values ("Humain");

insert into regions (nom) values ("Demacia"), ("Noxus"), ("Ionia"), ("Shurima");

insert into roles (libelle) values ("Top"), ("Jungle");

insert into genres (libelle) values ("Male"), ("Femelle");

insert into ressources (libelle) values ("Mana"), ("Sans mana");

insert into portees (libelle) values ("Melee");

insert into champions (nom, annee, fk_genre, fk_ressource) values ("Garen", "2010", 1, 2);

insert into appartenir (champion_id, espece_id) values (1, 1);

insert into venir (champion_id, region_id) values (1, 1);

insert into jouer (champion_id, role_id) values (1, 1);

insert into avoir (champion_id, portee_id) values (1, 1);
