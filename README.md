# Documentation

## User Documentation

### Feature

#### Management

- Dashboard (Stats widget to record sales total and review)
- Product Management
- Record Transaction
- Sales Management
- Review Management

#### Security

- Login Page
- Editing Profile
- Activity Logs

## Developer Documentation

### Tech-Stack

This program is build with:

- Framework: Laravel
- Login: Breeze
- Role Permission: Spatie
- Dashboard Management: Filament

### How To Use

Just running this syntax if you using VScode you can Right Click and Run. This file I saved in custom-tools/automation-command in root file.

#### Step 1

install-dependency.bat

#### Step 2

new-migration.bat

#### Optional

Added Seeder

add-seeder.bat

#### Tips

If you want to create new resource just follow this syntax or read Filament documentation

Create Resource

```Create Resource
php artisan make:filament-resource {Name Model}
```

Create model

```Create model
php artisan make:model {Name Model} -m
```
