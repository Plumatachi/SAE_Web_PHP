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

CREATE TABLE AlbumGenres (
    idAlbum INT,
    IdGenre INT,
    PRIMARY KEY (idAlbum, IdGenre),
    FOREIGN KEY (idAlbum) REFERENCES Album(idAlbum),
    FOREIGN KEY (IdGenre) REFERENCES Genre(IdGenre)
);

CREATE TABLE Genre (
    IdGenre INT,
    NomGenre Varchar,
    PRIMARY KEY (IdGenre)
);

