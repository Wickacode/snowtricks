# ❄️ SnowTricks

Projet réalisé dans le cadre de la formation **Développeur d'application PHP/Symfony** sur OpenClassrooms.

# Mon Projet

[![SymfonyInsight](https://insight.symfony.com/projects/f382247d-3029-4cad-88fe-95a31d3f3f27/big.svg)](https://insight.symfony.com/projects/f382247d-3029-4cad-88fe-95a31d3f3f27)

Ce projet a obtenu **4 étoiles** sur [Symfony Insight](https://insight.symfony.com/).


---

## 📌 Informations Générales

- **Technologies utilisées :**
  - Symfony **7.2**
  - Composer **2.7.9**
  - WampServer **3.3.5**
    - Apache **2.4.59**
    - PHP **8.2.18**
    - MySQL **8.3.0**

- **Auteur :** Jessica Garrido

---

## 🚀 Installation et Configuration

### 1️⃣ Clonage du projet

Clonez le dépôt GitHub dans le répertoire de votre choix :

```bash
git clone https://github.com/Wickacode/snowtricks.git
```

### 2️⃣ Installation des dépendances

Dans le dossier du projet, exécutez les commandes suivantes :

```bash
composer install
npm install
```

### 3️⃣ Configuration des variables d'environnement

Créez une copie du fichier `.env` sous le nom `.env.local` à la racine du projet. 

#### 🔹 Configuration de la base de données

Modifiez la ligne ci-dessous en remplaçant `db_user`, `db_password` et `db_name` par vos propres informations. Pensez à retirer le `#` en début de ligne :

```bash
DATABASE_URL="mysql://db_user:db_password@127.0.0.1:3306/db_name?serverVersion=8.0.32&charset=utf8mb4"
```

Entrez également cette ligne pour le fonctionnement de Mailhog :
```bash
MAILER_DSN=smtp://127.0.0.1:1025
```

#### 🔹 Installation de Mailhog pour l'envoi de mails

- Téléchargez la dernière version adéquate de Mailhog :
https://github.com/mailhog/MailHog/releases
- Exécutez le fichier .exe téléchargé
- Rendez-vous sur http://localhost:8025/# pour accéder à Mailhog

---

## 🛠️ Mise en place de la base de données

### 1️⃣ Création de la base de données

Depuis le répertoire du projet, exécutez :

```bash
php bin/console doctrine:database:create
```

### 2️⃣ Génération et application des migrations

```bash
php bin/console make:migration
php bin/console doctrine:migrations:migrate
```

### 3️⃣ (Optionnel) Chargement de données fictives

Pour ajouter des données de démonstration :

```bash
php bin/console doctrine:fixtures:load
```

📌 **Note** : Le premier utilisateur créé possède les droits administrateurs :

- **Email :** `admin@gmail.com`
- **Mot de passe :** `snowtricks2024`

📌 **Note** : Pour se connecter en simple utilisateur :

- **Email :** `user@gmail.com`
- **Mot de passe :** `snowtricks2024`

---

## ▶️ Démarrage du projet

Lancez le serveur Symfony avec la commande suivante :

```bash
symfony server:start
```

Le projet est maintenant accessible depuis **http://127.0.0.1:8000/** 🎉

---

## 📜 Licence

Ce projet a été réalisé dans le cadre de la formation OpenClassrooms et est libre d'utilisation pour toute personne souhaitant l'améliorer ou s'en inspirer.

---

✨ Bon développement ! 🚀
