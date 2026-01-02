# 🎁 MyMom'sBox

> Plateforme e-commerce de box mensuelles pour mamans et bébés avec système d'abonnement Stripe

![Symfony](https://img.shields.io/badge/Symfony-5.1-000000?style=flat&logo=symfony)
![PHP](https://img.shields.io/badge/PHP-7.4-777BB4?style=flat&logo=php)
![MySQL](https://img.shields.io/badge/MySQL-5.7-4479A1?style=flat&logo=mysql)
![Stripe](https://img.shields.io/badge/Stripe-Integrated-008CDD?style=flat&logo=stripe)

## 📋 Description

MyMom'sBox est une plateforme e-commerce permettant aux mamans de recevoir chaque mois une box surprise contenant des produits sélectionnés pour elles et leur bébé. Le site propose également un système d'abonnement mensuel, trimestriel et annuel avec paiement sécurisé via Stripe.

## ✨ Fonctionnalités principales

- 🛒 **E-commerce complet** : Catalogue de produits avec catégories, panier, commandes
- 💳 **Paiement Stripe** : Intégration complète de Stripe Checkout pour les paiements sécurisés
- 📦 **Système d'abonnement** : Abonnements récurrents (mensuel, trimestriel, annuel)
- 👤 **Gestion utilisateurs** : Inscription, connexion, profil, historique de commandes
- 📍 **Gestion d'adresses** : Multiples adresses de livraison par utilisateur
- 🚚 **Transporteurs** : Choix du mode de livraison (Colissimo, Chronopost, Mondial Relay)
- 📧 **Formulaire de contact** : System de demandes de contact avec historique
- 🔐 **Sécurité** : Authentification Symfony, protection des données sensibles

## 🛠️ Technologies utilisées

### Backend
- **Symfony 5.1** - Framework PHP
- **Doctrine ORM** - Gestion de la base de données
- **Twig** - Moteur de templates

### Frontend
- **HTML/CSS** - Interface utilisateur
- **JavaScript** - Interactions dynamiques

### Paiement & Services
- **Stripe** - Paiement en ligne et abonnements
- **Faker** - Génération de données de test

### Base de données
- **MySQL 5.7** - Stockage des données

## 📦 Installation

### Prérequis

- PHP 7.4+
- Composer
- MySQL 5.7+
- Serveur web (Apache/Nginx) ou Symfony CLI

### Étapes d'installation

1. **Cloner le repository**
```bash
git clone https://github.com/Gagz71/sf5MyMomsBox.git
cd sf5MyMomsBox
```

2. **Installer les dépendances**
```bash
composer install
```

3. **Configurer l'environnement**
```bash
cp .env.example .env
```

Éditer le fichier `.env` et configurer :
- `DATABASE_URL` : Connexion à votre base de données
- `STRIPE_SECRET_KEY` : Votre clé secrète Stripe
- `STRIPE_PUBLISHABLE_KEY` : Votre clé publique Stripe

4. **Créer la base de données**
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

5. **Charger les données de test (optionnel)**
```bash
php bin/console doctrine:fixtures:load
```

6. **Lancer le serveur**
```bash
symfony serve
# ou
php -S localhost:8000 -t public
```

L'application sera accessible sur `http://localhost:8000`

## ⚙️ Configuration

### Variables d'environnement

Créer un fichier `.env.local` avec vos propres valeurs :

```env
DATABASE_URL=mysql://user:password@127.0.0.1:3306/mymomsbox?serverVersion=5.7

# Stripe
STRIPE_PUBLISHABLE_KEY=pk_test_your_key
STRIPE_SECRET_KEY=sk_test_your_key
STRIPE_WEBHOOK_SECRET=whsec_your_secret

# Price IDs pour les abonnements
MONTH_PRICE_ID=price_your_monthly_id
TRIMESTER_PRICE_ID=price_your_quarterly_id
YEAR_PRICE_ID=price_your_yearly_id
```

### Compte de test

Après avoir chargé les fixtures, vous pouvez vous connecter avec :
- **Email** : test@test.com
- **Password** : password

## 📸 Screenshots

### Page d'accueil
![Homepage](docs/screenshots/homepage.png)

### Checkout Stripe
![Stripe](docs/screenshots/stripe-checkout.png)

### Abonnements
![Subscriptions](docs/screenshots/subscriptions.png)

## 🗂️ Structure du projet

```
sf5MyMomsBox/
├── src/
│   ├── Controller/       # Contrôleurs
│   ├── Entity/          # Entités Doctrine
│   ├── Repository/      # Repositories
│   ├── DataFixtures/    # Données de test
│   └── Form/            # Formulaires
├── templates/           # Templates Twig
├── public/              # Fichiers publics
│   ├── css/
│   ├── js/
│   └── uploads/
├── config/              # Configuration
└── migrations/          # Migrations de base de données
```

## 🔑 Fonctionnalités techniques

### Entities principales

- **User** : Utilisateurs avec gestion des rôles
- **Product** : Produits avec catégories
- **Order** : Commandes avec détails
- **Subscription** : Abonnements Stripe
- **Address** : Adresses de livraison
- **Carrier** : Modes de transport

### Sécurité

- Authentification Symfony Security
- Hashage des mots de passe (bcrypt)
- Protection CSRF sur les formulaires
- Variables d'environnement pour les secrets

## 🚀 Déploiement

Pour le déploiement en production :

1. Compiler les assets
```bash
composer dump-env prod
```

2. Optimiser l'autoloader
```bash
composer install --no-dev --optimize-autoloader
```

3. Vider le cache
```bash
php bin/console cache:clear --env=prod
```

## 📝 Licence

Ce projet a été réalisé dans un cadre éducatif.

## 👤 Auteur

**Gagz71**
- GitHub: [@Gagz71](https://github.com/Gagz71)

## 🙏 Remerciements

- Symfony pour le framework
- Stripe pour l'API de paiement
- Faker pour la génération de données de test

---

⭐ N'hésitez pas à star ce projet si vous le trouvez utile !