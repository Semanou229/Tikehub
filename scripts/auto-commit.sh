#!/bin/bash
# Script pour commit et push automatique

# Couleurs pour les messages
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

echo -e "${YELLOW}🔄 Commit et push automatique...${NC}"

# Vérifier s'il y a des modifications
if [ -z "$(git status --porcelain)" ]; then
    echo -e "${GREEN}✅ Aucune modification à commiter${NC}"
    exit 0
fi

# Demander le message de commit
if [ -z "$1" ]; then
    echo -e "${YELLOW}Entrez le message de commit (ou appuyez sur Entrée pour un message par défaut):${NC}"
    read -r commit_message
    if [ -z "$commit_message" ]; then
        commit_message="chore: Mise à jour automatique - $(date '+%Y-%m-%d %H:%M:%S')"
    fi
else
    commit_message="$1"
fi

# Ajouter tous les fichiers
echo -e "${YELLOW}📦 Ajout des fichiers...${NC}"
git add .

# Créer le commit
echo -e "${YELLOW}💾 Création du commit...${NC}"
git commit -m "$commit_message"

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ Commit créé avec succès${NC}"
    
    # Pousser vers le dépôt distant
    echo -e "${YELLOW}🚀 Push vers le dépôt distant...${NC}"
    git push origin main
    
    if [ $? -eq 0 ]; then
        echo -e "${GREEN}✅ Push réussi !${NC}"
    else
        echo -e "${RED}❌ Erreur lors du push${NC}"
        exit 1
    fi
else
    echo -e "${RED}❌ Erreur lors de la création du commit${NC}"
    exit 1
fi

echo -e "${GREEN}🎉 Terminé avec succès !${NC}"

