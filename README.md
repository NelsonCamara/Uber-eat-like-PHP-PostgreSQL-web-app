# Enjoy — Plateforme de livraison de repas (type Uber Eats)

Application web de livraison de repas développée en **PHP** avec une base de données **PostgreSQL**. La plateforme connecte trois acteurs : les **clients** qui commandent, les **restaurants** qui proposent leurs plats, et les **livreurs** qui assurent la livraison. Le système intègre un moteur de recherche multi-critères, un programme de fidélité, un système de parrainage, et une assignation automatique des livreurs par géolocalisation.

---

## À propos du projet

Enjoy reproduit les fonctionnalités clés d'une plateforme de livraison : inscription et authentification, catalogue de 10 restaurants avec leurs menus, passage de commandes avec calcul du prix, attribution automatique d'un livreur disponible dans la même ville que le client, suivi de commande (en préparation → en livraison → livrée), notation et commentaire des restaurants, et un système de points de fidélité avec parrainage. Les livreurs disposent de leur propre interface pour gérer leur statut et leurs livraisons.

---

## Architecture & Structure

```
Uber-eat-like-PHP-PostgreSQL-web-app/
├── SQL/
│   └── tables_proj.sql          → Schéma BDD complet (10 tables + données)
├── pages/
│   ├── accueil.html             → Page d'accueil (inscription/connexion)
│   ├── Accueil.css              → Feuille de style globale
│   ├── connexion.inc.php        → Configuration PDO PostgreSQL
│   ├── connexion_utilisateur.php → Authentification client
│   ├── connexion_livreur.php    → Authentification livreur
│   ├── inscription_utilisateur.php → Inscription client
│   ├── deconnexion.php          → Destruction de session
│   ├── recherche_restos.php     → Moteur de recherche multi-critères
│   ├── page_profil_personnel.php → Profil client (commandes, notes, parrainage)
│   ├── page_profil_professionnel.php → Profil livreur (statut, livraisons)
│   ├── mcdo.php                 → Page restaurant McDonald's
│   ├── kfc.php                  → Page restaurant KFC
│   ├── burger_king.php          → Page restaurant Burger King
│   ├── pizza_hut.php            → Page restaurant Pizza Hut
│   ├── del_arte.php             → Page restaurant Del Arte
│   ├── la_riviere.php           → Page restaurant La Rivière
│   ├── le_bistrot.php           → Page restaurant Le Bistrot
│   ├── o_cafe.php               → Page restaurant Ô Café
│   ├── o_tacos.php              → Page restaurant O'Tacos
│   └── pizza_2_folies.php       → Page restaurant Pizza 2 Folies
├── images/
│   ├── logo.png                 → Logo de la plateforme
│   └── logo1.png                → Logo variante
└── rapport_Enjoy.pdf            → Rapport de projet
```

**21 fichiers** (PHP + HTML + CSS + SQL) | **10 restaurants** | **10 tables SQL**

---

## Compétences techniques démontrées

### Conception de base de données relationnelle (PostgreSQL)

- **Modèle Entité-Association complet** — 10 tables avec clés primaires, clés étrangères et contraintes d'intégrité : `Restaurant`, `Client`, `Livreur`, `Ville`, `Plat`, `Commande`, `Specialite`, `fermeture_exceptionnelle`, `Commenter`, `Contenir`
- **Relations N:M** — Tables de jointure `Contenir` (Commande ↔ Plat avec quantité) et `Commenter` (Client ↔ Restaurant avec note et commentaire)
- **Intégrité référentielle** — Clés étrangères systématiques : `Plat.ID_rest → Restaurant`, `Commande.ID_cli → Client`, `Commande.matricule → Livreur`, `Commande.ID_rest → Restaurant`
- **Typage SQL précis** — `timestamp` pour les commandes, `time` pour les horaires d'ouverture/fermeture, `date` pour les fermetures exceptionnelles, `text` pour les descriptions et commentaires, `varchar` avec tailles adaptées
- **Jeu de données cohérent** — 10 restaurants, 10 clients, 10 livreurs, 11 plats, 7 villes, 3 commandes, 3 commentaires avec données réalistes

### Développement web back-end (PHP + PDO)

- **PDO avec requêtes préparées** — Utilisation systématique de `$cnx->prepare()` avec paramètres nommés (`:id_rest`, `:mail`, `:matricule`) et `bindParam()` pour toutes les opérations CRUD, protection contre les injections SQL
- **Gestion de sessions** — `session_start()`, `$_SESSION['login']` pour maintenir l'authentification client, `$_SESSION['matricule']` pour les livreurs, `session_destroy()` pour la déconnexion
- **Opérations CRUD complètes** — `INSERT` (inscription, commande, notation), `SELECT` (menus, profils, recherche), `UPDATE` (statut livreur, points fidélité, annulation), logique métier côté serveur
- **Traitement de formulaires** — Validation avec `isset($_POST[...])`, traitement conditionnel, feedback utilisateur dynamique

### Logique métier & fonctionnalités

- **Assignation automatique des livreurs** — Requête SQL croisant `livreur.ville = client.ville` avec filtre `etat = 'En Ligne'` pour trouver un livreur disponible géographiquement compatible
- **Moteur de recherche multi-critères** — 4 modes de recherche : par nom (avec `LIKE` et wildcards `%`), par notes (sous-requête avec `ORDER BY note DESC`), par nombre d'avis (`COUNT` + `GROUP BY` + `NATURAL JOIN`), affichage complet
- **Filtrage intelligent** — Triple vérification : restaurant ouvert (`CURRENT_TIME BETWEEN horaire_ouverture AND horaire_fermeture`), pas de fermeture exceptionnelle (`NOT IN (SELECT ... FROM fermeture_exceptionnelle WHERE CURRENT_DATE ...)`), livreur disponible dans la ville du client
- **Programme de fidélité** — Points incrémentés à chaque commande (+50 pts), parrainage entre clients avec bonus, stockage en base via `UPDATE Client SET point_fidel`
- **Système de parrainage** — Le client peut parrainer un autre client via son email, vérification d'existence en base, mise à jour du `parrain_id` et bonus de points
- **Gestion des commandes** — Cycle de vie complet : En préparation → En livraison → Livrée, possibilité d'annulation par le client, mise à jour automatique du statut du livreur

### Requêtes SQL avancées

- **Sous-requêtes imbriquées** — `SELECT ... FROM (SELECT ... ORDER BY ...) AS web` pour le tri par notes et nombre d'avis
- **Jointures multi-tables** — `FROM livreur, client WHERE livreur.ville = client.ville` pour la correspondance géographique
- **Fonctions temporelles PostgreSQL** — `CURRENT_TIME(0)`, `CURRENT_DATE`, opérateur `BETWEEN` pour la gestion des horaires et fermetures exceptionnelles
- **Agrégation** — `COUNT(note)`, `GROUP BY`, `NATURAL JOIN` pour les statistiques de restaurants
- **Pattern matching** — `LIKE :nom` avec wildcards dynamiques côté PHP (`'%'.$_POST['recherche'].'%'`)

### Front-end & UX

- **Interface cohérente** — CSS personnalisé avec palette violette (#59319F, #8764C5, #896ABD), composants réutilisables (`.box1`, `.box2`, `.boutonInscription`)
- **Navigation fluide** — Accueil → Connexion → Recherche → Restaurant → Commande → Profil, avec liens de retour vers l'accueil via le logo
- **Formulaires interactifs** — Sélecteurs de quantité (`min=1 max=10`), menus déroulants pour les critères de recherche et le statut livreur, champs de saisie pour notes et commentaires
- **Feedback utilisateur** — Messages dynamiques PHP : "Commande bien enregistrée !", "Aucun livreur dispo", "Adresse mail ou mot de passe incorrect..."

---

## Schéma de la base de données

```
Restaurant ──────┬──── Plat (1:N)
    │            ├──── Specialite (1:N)
    │            ├──── fermeture_exceptionnelle (1:N)
    │            └──── Commenter ←── Client
    │                                  │
    └──── Commande ───────────────────┘
              │                        
              ├──── Livreur (N:1)
              └──── Contenir ←── Plat (N:M)

Ville (référentiel géographique)
```

**Tables principales** : `Restaurant` (10), `Client` (10), `Livreur` (10), `Plat` (11), `Commande`, `Contenir`, `Commenter`, `Ville` (7), `Specialite`, `fermeture_exceptionnelle`

---

## Installation & Lancement

### Prérequis
- **PHP** (≥ 7.0) avec extension `pdo_pgsql`
- **PostgreSQL** (≥ 9.6)
- **Serveur web** (Apache recommandé)

### Configuration de la base de données

1. Créer la base de données PostgreSQL :
```bash
createdb Projet
```

2. Importer le schéma et les données :
```bash
psql -d Projet -f SQL/tables_proj.sql
```

3. Modifier les identifiants de connexion dans `pages/connexion.inc.php` :
```php
$user = "votre_utilisateur";
$pass = "votre_mot_de_passe";
```

### Lancement
Placer le projet dans le répertoire du serveur web (ex: `/var/www/html/`) et accéder à :
```
http://localhost/pages/accueil.html
```

### Comptes de test

**Client** : `adrien.silva@outlook.com` / `adrien22`

**Livreur** : matricule `1` / `panini12`

---

## Fonctionnalités par rôle

### 👤 Client
| Fonctionnalité | Description |
|----------------|-------------|
| Inscription | Création de compte avec nom, email, téléphone, CB, adresse |
| Connexion | Authentification par email + mot de passe |
| Recherche restaurants | Par nom, note, nombre d'avis, ou tous |
| Commander | Choix du plat, quantité, assignation automatique du livreur |
| Profil | Historique commandes, annulation, notation, parrainage |
| Points fidélité | +50 pts par commande, bonus parrainage |

### 🚴 Livreur
| Fonctionnalité | Description |
|----------------|-------------|
| Connexion | Authentification par matricule + mot de passe |
| Gestion statut | En Ligne / Hors Ligne / Attente de Commande / En livraison |
| Couverture ville | Changement de ville de couverture |
| Livraisons | Consultation et validation des commandes assignées |

---

## 🛠️ Technologies

| Technologie | Usage |
|-------------|-------|
| PHP | Back-end, logique métier, rendu dynamique |
| PostgreSQL | Base de données relationnelle |
| PDO | Interface d'accès BDD avec requêtes préparées |
| HTML5 | Structure des pages |
| CSS3 | Mise en forme et design |
| Sessions PHP | Gestion de l'authentification |

---

## 📄 Documentation

Le rapport complet du projet est disponible dans `rapport_Enjoy.pdf`.

---

## 👤 Auteur

**Nelson Camara** — Étudiant en Master Informatique

---

*Projet académique — Application web full-stack de livraison de repas avec PHP et PostgreSQL.*
