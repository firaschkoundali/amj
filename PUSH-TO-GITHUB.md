# 🚀 Guide : Pousser le code sur GitHub

Votre code est déjà commité localement. Suivez ces étapes pour le pousser sur GitHub.

## Étape 1 : Créer un repository sur GitHub

1. **Allez sur [github.com](https://github.com)** et connectez-vous
2. Cliquez sur le bouton **"+"** en haut à droite → **"New repository"**
3. Remplissez les informations :
   - **Repository name** : `symfony-amj` (ou le nom de votre choix)
   - **Description** : `Application Symfony pour les 16èmes Journées Médicales de l'AMJ`
   - **Visibility** : 
     - ✅ **Public** (gratuit, visible par tous)
     - ⚠️ **Private** (gratuit aussi, mais seulement vous pouvez voir)
   - ⚠️ **NE COCHEZ PAS** "Add a README file" (on a déjà un README)
   - ⚠️ **NE COCHEZ PAS** "Add .gitignore" (on a déjà un .gitignore)
4. Cliquez sur **"Create repository"**

## Étape 2 : Copier l'URL du repository

Après la création, GitHub vous affichera une page avec des instructions. **Copiez l'URL HTTPS** qui ressemble à :
```
https://github.com/votre-username/symfony-amj.git
```

## Étape 3 : Connecter votre repository local à GitHub

Exécutez ces commandes dans votre terminal (dans le dossier `symfony-amj`) :

```bash
# Ajouter le remote GitHub
git remote add origin https://github.com/votre-username/symfony-amj.git

# Renommer la branche en 'main' (si nécessaire)
git branch -M main

# Pousser le code
git push -u origin main
```

**Remplacez `votre-username` par votre nom d'utilisateur GitHub !**

## Étape 4 : Authentification

Si c'est la première fois que vous poussez sur GitHub depuis cet ordinateur :

### Option A : Avec GitHub CLI (recommandé)
```bash
# Installer GitHub CLI si pas déjà fait
# Puis :
gh auth login
```

### Option B : Avec un Personal Access Token
1. Allez sur GitHub → **Settings** → **Developer settings** → **Personal access tokens** → **Tokens (classic)**
2. Cliquez sur **"Generate new token"**
3. Donnez-lui un nom (ex: "Symfony AMJ")
4. Cochez la permission **"repo"**
5. Cliquez sur **"Generate token"**
6. **Copiez le token** (vous ne le reverrez plus !)
7. Quand Git vous demande le mot de passe, utilisez ce token au lieu de votre mot de passe

### Option C : Avec SSH (plus sécurisé)
```bash
# Générer une clé SSH (si pas déjà fait)
ssh-keygen -t ed25519 -C "votre-email@example.com"

# Copier la clé publique
cat ~/.ssh/id_ed25519.pub

# Ajouter la clé sur GitHub : Settings → SSH and GPG keys → New SSH key
# Puis utiliser l'URL SSH au lieu de HTTPS :
git remote set-url origin git@github.com:votre-username/symfony-amj.git
git push -u origin main
```

## ✅ Vérification

Après le push, allez sur votre repository GitHub. Vous devriez voir tous vos fichiers !

## 🔄 Commandes utiles pour les prochains push

```bash
# Ajouter les modifications
git add .

# Créer un commit
git commit -m "Description de vos modifications"

# Pousser sur GitHub
git push
```

## ⚠️ Fichiers à NE JAMAIS pousser

Ces fichiers sont déjà dans `.gitignore` :
- `.env` (variables d'environnement sensibles)
- `/var/` (cache Symfony)
- `/vendor/` (dépendances, seront installées sur le serveur)

---

## 🆘 Problèmes courants

### Erreur : "remote origin already exists"
```bash
# Supprimer l'ancien remote
git remote remove origin

# Ajouter le nouveau
git remote add origin https://github.com/votre-username/symfony-amj.git
```

### Erreur : "Authentication failed"
- Vérifiez que vous utilisez un Personal Access Token (pas votre mot de passe)
- Ou configurez SSH

### Erreur : "Permission denied"
- Vérifiez que vous avez les droits sur le repository
- Vérifiez que l'URL du repository est correcte

---

## 📚 Prochaines étapes

Une fois le code sur GitHub, vous pouvez :
1. **Déployer sur Render.com** (voir `GUIDE-RAPIDE-RENDER.md`)
2. **Déployer sur Railway.app**
3. **Déployer sur Fly.io**

Tous ces services peuvent se connecter automatiquement à votre repository GitHub !

