
select 
    cha.id,
    cha.nom,
    cha.annee,
    cha.image,
    gen.libelle as genre,
    res.libelle as ressource,
    
    group_concat(distinct esp.libelle) as espece,
    group_concat(distinct por.libelle) as portee,
    
    group_concat(distinct rol.libelle) as role,
    group_concat(distinct reg.nom) as regions

-- from
from champions cha
-- genres
join genres gen on gen.id = cha.fk_genre

-- resources
join ressources res on res.id = cha.fk_ressource

-- especes
join appartenir app on app.champion_id = cha.id
join especes esp on app.espece_id = esp.id

-- portees
join avoir avo on avo.champion_id = cha.id
join portees por on avo.portee_id = por.id

-- roles
join jouer jou on jou.champion_id = cha.id
join roles rol on jou.role_id = rol.id

-- regions 
join venir ven on ven.champion_id = cha.id
join regions reg on ven.region_id = reg.id

group by 
	cha.id,
    cha.nom,
    cha.annee,
    cha.image,
    gen.libelle,
    res.libelle;
;