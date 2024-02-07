CREATE TABLE Groupe (
    idGroupe INT,
    Nom Varchar,
    PRIMARY KEY (idGroupe)
);

CREATE TABLE Album (
    idAlbum INT,
    idGroupe INT,
    imageAlbum Varchar,
    titre Varchar,
    anneePublication INT,
    entryID INT,
    PRIMARY KEY (idAlbum, idGroupe),
    FOREIGN KEY (idGroupe) REFERENCES Groupe(idGroupe)
);

CREATE TABLE Chanson (
    idChanson INT,
    idAlbum INT,
    titre Varchar,
    PRIMARY KEY (idChanson, idAlbum),
    FOREIGN KEY (idAlbum) REFERENCES Album(idAlbum)
);

CREATE TABLE Genre (
    IdGenre INT,
    NomGenre Varchar,
    PRIMARY KEY (IdGenre)
);

CREATE TABLE AlbumGenres (
    idAlbum INT,
    IdGenre INT,
    PRIMARY KEY (idAlbum, IdGenre),
    FOREIGN KEY (idAlbum) REFERENCES Album(idAlbum),
    FOREIGN KEY (IdGenre) REFERENCES Genre(IdGenre)
);

CREATE TABLE ROLE(
    idRole INT,
    NomRole Varchar,
    PRIMARY KEY (idRole)
);

CREATE TABLE UTILISATEUR(
    idUtilisateur INT,
    idRole INT,
    Nom Varchar,
    Prenom Varchar,
    Email Varchar,
    Mdp Varchar,
    PRIMARY KEY (idUtilisateur)
    FOREIGN KEY (idRole) REFERENCES ROLE(idRole)
);

CREATE TABLE PlaylistLike(
    idUtilisateur INT,
    idChanson INT,
    PRIMARY KEY (idPlaylist, idChanson),
    FOREIGN KEY (idUtilisateur) REFERENCES UTILISATEUR(idUtilisateur)
    FOREIGN KEY (idChanson) REFERENCES Chanson(idChanson)
);

CREATE TABLE AlbumsLike(
    idUtilisateur INT,
    idAlbum INT,
    PRIMARY KEY (idUtilisateur, idAlbum),
    FOREIGN KEY (idUtilisateur) REFERENCES UTILISATEUR(idUtilisateur)
    FOREIGN KEY (idAlbum) REFERENCES Album(idAlbum)
);

CREATE TABLE Notation(
    idUtilisateur INT,
    idChanson INT,
    Note INT,
    PRIMARY KEY (idUtilisateur, idChanson),
    FOREIGN KEY (idUtilisateur) REFERENCES UTILISATEUR(idUtilisateur)
    FOREIGN KEY (idChanson) REFERENCES Chanson(idChanson)
);