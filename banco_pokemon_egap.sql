#drop database pokemonegap;

create database pokemonegap;

use pokemonegap;

create table treinador(
	nome varchar(100),
    senha text,
    telefone varchar(11),
    primary	key(nome)
);

create table adm(
	administrador varchar(60),
	primary key(administrador),
    foreign key(administrador) references treinador(nome)
); 

create table equipe(
    nome_treinador varchar(45),
    imagem_treinador enum("m1", "m2", "m3", "f1", "f2", "f3"),
	situacao BOOLEAN DEFAULT FALSE,
	p1 varchar(50),
    p2 varchar(50),
    p3 varchar(50),
    p4 varchar(50),
    p5 varchar(50),
    p6 varchar(50),
    foreign key(nome_treinador) references treinador(nome),
    primary key(nome_treinador)
);

insert into treinador values ("elton", md5("EgSf!@#11052005"), "84992308570"); 
insert into adm values ("elton");







