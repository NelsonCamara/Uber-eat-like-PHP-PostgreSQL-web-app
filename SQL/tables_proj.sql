CREATE TABLE Restaurant(
    ID_rest integer PRIMARY KEY,
    nom_rest varchar(25),
    adresse varchar (50),
    ville varchar (30),
    page_web varchar(25), 
    horaire_ouverture  time, 
    horaire_fermeture time, 
    prix_livraison integer
);

CREATE TABLE Client (
    ID_cli integer PRIMARY KEY,
    nom varchar(25), 
    prenom varchar(25), 
    mail varchar(50), 
    telephone varchar(10), 
    mot_de_passe varchar(25), 
    num_cb varchar(20), 
    adresse varchar(50),
    ville varchar(30), 
    point_fidel integer,
    parrain_id integer

);

CREATE TABLE Livreur (
    matricule integer PRIMARY KEY,
    nom varchar(25), 
    prenom varchar(25), 
    telephone varchar(10), 
    adresse varchar(100),
    ville varchar(30), 
    mot_de_passe varchar(25), 
    etat varchar(25)

);

CREATE TABLE Ville(
    code_postal char(5) PRIMARY KEY,
    nom_ville varchar(25), 
    pays varchar(25)
);

CREATE TABLE Plat(
    ID_plat varchar(10) PRIMARY KEY,
    nom_plat varchar(25), 
    prix integer, 
    description_plat text, 
    ID_rest integer,
    FOREIGN KEY (ID_rest) REFERENCES Restaurant(ID_rest)
);

CREATE TABLE Commande(
    num_commande integer PRIMARY KEY,
    timestampe timestamp, 
    etat varchar(25), 
    matricule integer, 
    ID_cli integer, 
    ID_rest integer,

    FOREIGN KEY (ID_cli) REFERENCES Client(ID_cli),

    FOREIGN KEY (ID_rest) REFERENCES Restaurant(ID_rest),
    FOREIGN KEY (matricule) REFERENCES Livreur(matricule)

);



CREATE TABLE Specialite(
    mot_def varchar(25) PRIMARY KEY,
    ID_rest integer,
    FOREIGN KEY (ID_rest) REFERENCES Restaurant(ID_rest)

);

CREATE TABLE fermeture_exceptionnelle(
    date_fermeture date,
    ID_rest integer,
    raison varchar(25),
    PRIMARY KEY(date_fermeture, ID_rest),
    FOREIGN KEY (ID_rest) REFERENCES Restaurant(ID_rest)

);


CREATE TABLE Commenter(
    ID_cli integer,
    ID_rest integer ,
    note integer ,
    commentaire text,
    ID_plat varchar(10),
    PRIMARY KEY(ID_cli, ID_rest),
    FOREIGN KEY (ID_cli) REFERENCES Client(ID_cli),
    FOREIGN KEY (ID_rest) REFERENCES Restaurant(ID_rest),
    FOREIGN KEY (ID_plat) REFERENCES Plat(ID_plat)

);


CREATE TABLE Contenir(
    num_commande integer,
    ID_plat varchar(10),
    nb_plat integer,
    PRIMARY KEY (num_commande, ID_plat),
    FOREIGN KEY (ID_plat) REFERENCES Plat(ID_plat)
);





INSERT INTO Restaurant VALUES (1, 'MCDO','Avenue du President Salvador Allende','Meaux','mcdo.php','8:00','23:59',5);
INSERT INTO Restaurant VALUES (2, 'KFC','2 Avenue des Sablons Bouillants','Chelles','kfc.php','11:00','22:00',7);
INSERT INTO Restaurant VALUES (3, 'Burger King','Avenue de la Haute Borne','Meaux','burger_king.php','9:00','23:00',5);
INSERT INTO Restaurant VALUES (4, 'Del Arte','Val D Europe',' Chessy','del_arte.php','18:00','23:59',3);
INSERT INTO Restaurant VALUES (5, 'Pizza Hut','Avenue de la victoire', 'Paris','pizza_hut.php','13:00','23:59',8);
INSERT INTO Restaurant VALUES (6, 'La riviere','Boulevard de la riviere', 'Champs sur Marne','la_riviere.php','16:00','23:00',4);
INSERT INTO Restaurant VALUES (7, 'Le bistrot','Rue du Bistrot', 'Paris','le_bistrot.php','10:00','20:00',8);
INSERT INTO Restaurant VALUES (8, 'O Cafe','Allee des affaires', 'Pantin','o_cafe.php','15:00','23:00',3);
INSERT INTO Restaurant VALUES (9, 'O Tacos','Centre commercial aux Saisons', 'Meaux','o_tacos.php','18:00','23:59',5);
INSERT INTO Restaurant VALUES (10, 'Pizza 2 folies','Champs Elysees', 'Paris','pizza_2_folies.php','16:00','23:59',10);

INSERT INTO Client VALUES(1,'Da Silva','Adrien','adrien.silva@outlook.com','0675893021','adrien22','3255 2591 3641 5691' ,'75600  25 rue des invalides', 'Paris',29);
INSERT INTO Client VALUES(2,'Dupont','Patrick','patick.dupont@outlook.com','0793829013','dpat2034','5562 3841 3697 7410','75400  10 Avenue Des Champs','Paris',115);
INSERT INTO Client VALUES(3,'Rose','Kylian','kylian.rose@outlook.com','0653426738','kr1998','9963 1424 3394 5268','77700  87 rue de la paris','Serris',32);
INSERT INTO Client VALUES(4,'Santana','Elena','elena.s@outlook.com','0632003813','santana19','5225 5331 6941 2311','75300  9 place d arianne','Paris',403);
INSERT INTO Client VALUES(5,'Mallet','Nathan','nat.mallet@outlook.com','0688263700','mallet10','2255 3369 5147 3337','78930 28 rue de la fourche','Saint-Germain',43);
INSERT INTO Client VALUES(6,'Lavigne','Alphonso','alphonso.lavi@outlook.com','0699389201','allav987','5239 7456 6695 8889','77100  58 rue de la tour','Champs sur Marne',76);
INSERT INTO Client VALUES(7,'Sarri','Medhi','medhi.sarri@outlook.com','0676337890','dime10','5556 1133 2514 9696','75500 9 avenue montaigne','Paris',402);
INSERT INTO Client VALUES(8,'Vidal','Astrid','astid.vidal@live.com','0683725110','cdelz10','9968 8745 5969 9990','75300 11 rue de londres','Paris',115);
INSERT INTO Client VALUES(9,'Rodriguez','Sarah','sarah.ro@live.com','0683728901','sarah1998','0002 5203 0960 0300','77800  10 rue des flammes','Bussy',256);
INSERT INTO Client VALUES(10,'Noris','Kyle','noris.kyle@live.com','0684736210','kyle98','5599 6324 2875 2664','75800  54 rue des martyrs','Paris',938);

INSERT INTO Livreur VALUES(1,'Fournier','Paul','0696357413','41 avenue des chasseurs','Pantin','panini12','En Ligne');
INSERT INTO Livreur VALUES(2,'Dupuit','Leo','0611475630','102 avenue des du General de Gaulle','Meaux','glouglou96','Hors Ligne');
INSERT INTO Livreur VALUES(3,'Le','Pierre','0751668820','2 avenue des glycine','Chessy','binks94','Attente de Commande');
INSERT INTO Livreur VALUES(4,'Giraudo','Patrick','0656013600','69 rue du Moulin','Paris','Bandit93','En livraison');
INSERT INTO Livreur VALUES(5,'Francis','Bernard','0623659874','10 impasse Potiront','Paris','bouh1234','En livraison');
INSERT INTO Livreur VALUES(6,'Rodrigues','Andre','0734448569','25 avenue des coquelicot','Paris','simon75','En Ligne');
INSERT INTO Livreur VALUES(7,'Gomez','Selena','0720205817','9 rue Jean Macet','Paris','nissangtr1000','En Ligne');
INSERT INTO Livreur VALUES(8,'Foulon','Charlotte','0735941839','89 boulevard descartes','Champs sur Marne','barbecue77','Hors Ligne');
INSERT INTO Livreur VALUES(9,'Vincent','Said','0600453791','72 avenue du Lac','Bussy','MfDs8M22','En Ligne');
INSERT INTO Livreur VALUES(10,'Chonion','Martine','0789356284','6 rue de la Marne','Paris','76Gfc2d','En Attente de Commande');


INSERT INTO Ville VALUES (77100,'Meaux','France');
INSERT INTO Ville VALUES (77500,'Chelles','France');
INSERT INTO Ville VALUES (77700,'Chessy','France');
INSERT INTO Ville VALUES (77420,'Champs sur Marne','France');
INSERT INTO Ville VALUES (77000,'Paris','France');
INSERT INTO Ville VALUES (93500,'Pantin','France');
INSERT INTO Ville VALUES (77300,'Bussy','France');


INSERT INTO Plat VALUES ('MXBSTOF','BigMac',6,'Somptueux burger americain',1);
INSERT INTO Plat VALUES ('BUCKET','Tenders',15,'Sceau de tenders succulents',2);
INSERT INTO Plat VALUES ('MARGRITA','Margherita',7,'La fameuse Marguerita chez Del arte !',4);
INSERT INTO Plat VALUES ('TARTR','Tartare de canard confit',16,'Notre specialite,le canard confit ! Bon appetit',6);
INSERT INTO Plat VALUES ('COUSS','Couscous Marocain maison',8,'Couscous Marocain fait sur place ! ', 7);
INSERT INTO Plat VALUES ('CAFDEJ','petit dej cappucino',7,'Classique petit dej avant d aller au boulot',8);
INSERT INTO Plat VALUES ('REGINA','Regina',6,'Notre succulente Regina à prix bas !',10);
INSERT INTO Plat VALUES ('STKHSE','Double Steakhouse',13,'Le menu Double Steakhouse avec ses deux viandes de boeuf grillees à la flamme disponible chez Enjoy ! ',3);
INSERT INTO Plat VALUES ('4FRMG','4 Fromages',8,'La celebre 4 Fromages livree chez vous ',5);
INSERT INTO Plat VALUES ('4FROMAGES','4fromages',6,'Notre succulente 4 fromages à prix bas !',10);
INSERT INTO Plat VALUES ('TCOS','Tacos',5,'Creez votre Tacos à votre goûts et deguster le a domicile !',9);


INSERT INTO Commande VALUES(1, '29-11-20 20:30', 'Livrer',10,1,5);
INSERT INTO Commande VALUES(2, '29-11-20 20:15', 'En livraison',4,2,10);
INSERT INTO Commande VALUES(3, '29-11-20 20:00', 'Livrer',7,9,6);

INSERT INTO Specialite VALUES ('Canard',6);

INSERT INTO fermeture_exceptionnelle VALUES('2020-12-01',1,'COVID Drive ouvert');
INSERT INTO fermeture_exceptionnelle VALUES('2020-12-01',2,'COVID Drive ouvert');
INSERT INTO fermeture_exceptionnelle VALUES('2020-12-01',3,'COVID Drive ouvert');

INSERT INTO Commenter VALUES (1, 7, 8 , 'Tres bon restaurant');
INSERT INTO Commenter VALUES (6, 1, 4 , 'Temps d attente tres long ');
INSERT INTO Commenter VALUES (3, 5, 9 , 'Pizza Super !!');

INSERT INTO Contenir VALUES (1,'4FRMG', 2);
INSERT INTO Contenir VALUES (2,'REGINA', 3);
INSERT INTO Contenir VALUES (3,'TARTR', 1);


