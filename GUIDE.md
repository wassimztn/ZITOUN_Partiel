# Guide de démarrage - Application Conférences Médicales

## 🚀 Comptes de test

Deux comptes sont pré-créés :

### Admin
- **Email** : `admin@example.com`
- **Mot de passe** : `password`
- **Accès** : CRUD complet sur toutes les conférences

### Médecin
- **Email** : `medecin@example.com`
- **Mot de passe** : `password`
- **Accès** : Lecture seule de ses propres conférences

## 🔧 Installation

```bash
# Installer les dépendances
composer install

# Créer la base de données
php bin/console doctrine:database:create --if-not-exists

# Créer les tables
php bin/console doctrine:migrations:migrate

# Charger les données de test
php bin/console doctrine:fixtures:load --no-interaction
```

## 📱 Fonctionnalités

### Accueil
- Page publique accessible sans connexion
- Lien vers la connexion
- Liens vers les conférences (une fois connecté)

### Authentification
- Connexion par email/mot de passe
- Déconnexion depuis la navbar
- Redirection automatique si non connecté

### Gestion des Conférences (Admin)
- ✅ Créer une conférence
- ✅ Lire toutes les conférences
- ✅ Modifier une conférence
- ✅ Supprimer une conférence
- ✅ Filtrer par pathologie (via URL: `/conference/pathologie/{id}`)

### Consultation des Conférences (Médecin)
- ✅ Voir la liste de ses conférences
- ✅ Voir les détails d'une conférence
- ❌ Pas de création, modification ou suppression

## 🏥 Pathologies disponibles
- Épilepsie
- Diabète
- Asthme

## 📝 Routes disponibles

- `/` - Accueil (public)
- `/login` - Connexion (public)
- `/logout` - Déconnexion (authentifié)
- `/conference` - Liste des conférences (authentifié)
- `/conference/new` - Créer une conférence (admin uniquement)
- `/conference/{id}` - Détails d'une conférence (authentifié)
- `/conference/{id}/edit` - Modifier une conférence (admin uniquement)
- `/conference/{id}` POST - Supprimer une conférence (admin uniquement)
- `/conference/pathologie/{id}` - Conférences d'une pathologie (admin uniquement)
