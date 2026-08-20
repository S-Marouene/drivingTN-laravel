# Permis TN — Préparation à l’examen du permis tunisien

Application Laravel avec Bootstrap 5 permettant aux candidats de pratiquer des examens de 30 questions, avec questions en arabe tunisien, images, audio et trois propositions. La réussite est calculée à partir de **24 bonnes réponses sur 30**.

## Fonctionnalités

L’accueil présente tous les examens publiés et autorise un nombre illimité de tentatives. Le candidat répond à 30 questions obligatoires, consulte l’illustration et écoute l’enregistrement associé, puis reçoit immédiatement son score et le statut « Examen réussi » ou « Examen non réussi ».

Le panneau d’administration est disponible à `/admin`. Il permet de créer un examen, de le publier ou de le laisser en brouillon, puis d’ajouter, modifier et supprimer ses questions. Une validation empêche de dépasser 30 questions par examen. Chaque question possède un texte arabe, trois propositions, un index de bonne réponse, une image et un fichier audio facultatifs.

## Installation

```bash
git clone https://github.com/S-Marouene/drivingTN-laravel.git
cd drivingTN-laravel
composer install
cp .env.example .env
php artisan key:generate
# Dans .env : DB_CONNECTION=mysql, DB_DATABASE=code_de_la_route et renseigner vos identifiants MySQL
php artisan migrate:fresh --seed
php artisan storage:link
php artisan serve
```

Puis ouvrir [http://127.0.0.1:8000](http://127.0.0.1:8000). Les seeders créent deux examens de démonstration contenant chacun exactement 30 questions en arabe, une illustration locale et un audio public de test. La base de données utilisée est MySQL, avec `code_de_la_route` comme nom par défaut. En environnement de production, il est recommandé d’ajouter une authentification et une autorisation dédiées à `/admin`.

## Structure

| Élément | Responsabilité |
|---|---|
| `ExamController` | Accueil, affichage, soumission et résultat candidat |
| `AdminController` | CRUD des examens et des questions, téléversement des médias |
| `Exam`, `Question`, `ExamAttempt` | Modèles métier et relations Eloquent |
| `database/migrations` | Schéma des examens, questions et tentatives |
| `database/seeders/DatabaseSeeder.php` | Données de démonstration immédiatement testables |
| `resources/views` | Interface Bootstrap 5 en français et contenu arabe RTL |

## Routes utiles

| URL | Usage |
|---|---|
| `/` | Accueil candidat |
| `/examens/{exam}` | Passer un examen |
| `/admin` | Tableau de bord administrateur |
| `/admin/examens/nouveau` | Créer un examen |

## Vérifications effectuées

Les migrations MySQL, le seeding, le lien de stockage, la liste des routes, l’accueil, l’affichage d’un examen de 30 questions, la soumission de 30 réponses et le calcul d’un résultat de 30/30 ont été vérifiés localement.
