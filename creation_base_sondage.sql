--
-- base de donn�es: 'baseavion'
--
create database if not exists basesondage default character set utf8 collate utf8_general_ci;
use basesondage;
-- --------------------------------------------------------
-- creation des tables

set foreign_key_checks =0;

-- table sondage
drop table if exists sondage;
create table sondage (
	son_id int not null auto_increment primary key,
	son_titre varchar(255) not null,
	son_date_debut date not null, 
	son_date_fin date not null
)engine=innodb;

-- table question
drop table if exists question;
create table question (
	que_id int not null auto_increment primary key,
	que_texte varchar (255) not null,
	que_sondage int not null
)engine=innodb; 

-- table reponse_possible
drop table if exists reponse_possible;
create table reponse_possible (
	rep_id int not null auto_increment primary key,
	rep_texte varchar(255) not null,
	rep_question int not null
)engine=innodb; 

-- table visiteur
drop table if exists visiteur;
create table visiteur (
	vis_id int not null auto_increment primary key,
	vis_ip varchar(20) not null
)engine=innodb; 

-- table choix
drop table if exists choix;
create table choix (
	cho_id int not null auto_increment primary key,
	cho_visiteur int not null,
	cho_reponse int not null,
	cho_question int not null,
	unique key repondre (cho_visiteur, cho_question)
)engine=innodb; 


-- contraintes
alter table question add constraint cs1 foreign key (que_sondage) references sondage(son_id);
alter table reponse_possible add constraint cs2 foreign key (rep_question) references question(que_id);
alter table choix add constraint cs3 foreign key (cho_visiteur) references visiteur(vis_id);
alter table choix add constraint cs4 foreign key (cho_reponse) references reponse_possible(rep_id);
alter table choix add constraint cs5 foreign key (cho_question) references question(que_id);

set foreign_key_checks = 1;

-- jeu de données

