SQLite format 3   @     ,                                                               , .0:   � T0�                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       ��gtablegallonsgallonsCREATE TABLE gallons (
date_vente DATE,
heure_vente TIME,
quantite REAL NOT NULL,
commenataires VARCHAR(50)
)��tableachatsachatsCREATE TABLE achats (
id INTEGER PRIMARY KEY AUTOINCREMENT, 
date_achat DATE,
heure_achat TIME,
id_produit INTEGER NOT NULL, 
id_client INTEGER NOT NULL,
FOREIGN KEY (id_produit) REFERENCES produits(id),
FOREIGN KEY (id_client) REFERENCES clients(id)
)�O�utableclientsclientsCREATE TABLE clients (
id INTEGER PRIMARY KEY AUTOINCREMENT, 
first_name TEXT NOT NULL, 
last_name TEXT NOT NULL, 
phone1 TEXT,
phone2 TEXT,
adresse TEXT,
email TEXT,
niveau TEXT
)P++Ytablesqlite_sequencesqlite_sequenceCREATE TABLE sqlite_sequence(name,seq)�)�%tableproduitsproduitsCREATE TABLE produits (
id INTEGER PRIMARY KEY AUTOINCREMENT, 
description TEXT NOT NULL, 
categorie TEXT NOT NULL, 
prix INTEGER NOT NULL
)   & ���qG#���uS+���sM&                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        % 5!Bouteille 150 livresbouteilles �$ 5!Bouteille 100 livresbouteillesx# 3!Bouteille 60 livresbouteillesF# 3!Bouteille 25 livresbouteilles-# 3!Bouteille 20 livresbouteilles( ;#Adaptateur de reservoirConnecteurs %#pare-flammesequipements& 7#propane regulateur 83Connecteurs  +#Grille Barbecueequipements*%
 5#Indicateurs de jaugeequipements,	 C#Gants barbecue refractairesequipements' =Rechaud Propane 6 foyersrechauds^. E#Barbecue au propane portatifrechaud BBQ �" 5Rechaud foyer uniquerechauds1( =!Tuyau plastique 10 piedstuyauterie -rechaud 2 foyersrechaudsA$ 3#detendeur inverseurConnecteurs4# 1#Coupleur BaionetteConnecteurs" /#Regulateur 37mBarConnecteurs   � ���                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                           
achatsclientsproduits   F ���qP-	����hF                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                     	     JeromeMESADIEU4035-6549	     OliverJEAN4987-8798	     EricABIDAL3298-7785
	     JuniorPIERRE4554-3146!		     KarineBIEN-AIME3101-0088 	     JohannaGRANVIL4618-2107"	     CarolaneBAPTISTE3698-5012!	     RobertGUILLAUME3715-9087	     EmmanuelLEGER3562-1100 	     CharlesBRONSON4115-2852$	 #    Marie BediaCENATUS2112-6804"	 !    ManouchekaGENTIL4818-7551!	     RicardinGUIRAND4739-5058   � ���                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                        !2020-09-2409:08
 !2020-09-2309:50 !2020-09-2009:10   � ����                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                               ! 2020-03-2408:15@+      ! 2020-03-2407:46@      ! 2020-03-2407:40! 2020-03-2407:30@      