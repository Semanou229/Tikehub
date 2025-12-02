# Scripts de Déploiement Automatique

## Scripts disponibles

### 1. `auto-commit.ps1` (Windows PowerShell)
Script PowerShell pour commit et push automatique sur Windows.

**Utilisation :**
```powershell
# Avec message personnalisé
.\scripts\auto-commit.ps1 -Message "feat: Nouvelle fonctionnalité"

# Sans message (utilisera un message par défaut avec timestamp)
.\scripts\auto-commit.ps1
```

### 2. `auto-commit.sh` (Linux/Mac)
Script Bash pour commit et push automatique sur Linux/Mac.

**Utilisation :**
```bash
# Avec message personnalisé
./scripts/auto-commit.sh "feat: Nouvelle fonctionnalité"

# Sans message (utilisera un message par défaut avec timestamp)
./scripts/auto-commit.sh
```

**Rendre le script exécutable (Linux/Mac) :**
```bash
chmod +x scripts/auto-commit.sh
```

## Workflows GitHub Actions

### 1. Déploiement Automatique (`.github/workflows/deploy.yml`)
- Se déclenche automatiquement à chaque push sur `main`
- Vérifie la syntaxe PHP
- Nettoie et optimise les caches Laravel
- Prêt pour intégration avec un serveur de production

### 2. Tests Automatiques (`.github/workflows/tests.yml`)
- Se déclenche sur les pull requests et les pushes
- Exécute les tests PHPUnit
- Vérifie la compatibilité avec MySQL

## Hook Git Pre-Push

Un hook `pre-push` est disponible dans `.git/hooks/pre-push` qui :
- Vérifie la syntaxe PHP avant chaque push
- Empêche le commit de fichiers sensibles (.env)
- Avertit si vous n'êtes pas sur la branche main

**Pour activer le hook (Linux/Mac) :**
```bash
chmod +x .git/hooks/pre-push
```

**Note :** Les hooks Git ne sont pas versionnés par défaut. Copiez le hook manuellement si nécessaire.

## Configuration recommandée

1. **Pour un workflow automatique complet :**
   - Utilisez les scripts `auto-commit` pour commit et push
   - Les workflows GitHub Actions se déclencheront automatiquement

2. **Pour un contrôle manuel :**
   - Faites vos commits normalement avec `git commit`
   - Les workflows GitHub Actions se déclencheront toujours automatiquement

## Exemple d'utilisation quotidienne

```powershell
# Windows
.\scripts\auto-commit.ps1 -Message "fix: Correction du bug d'authentification"
```

```bash
# Linux/Mac
./scripts/auto-commit.sh "fix: Correction du bug d'authentification"
```

