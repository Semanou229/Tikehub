# Script PowerShell pour commit et push automatique

param(
    [string]$Message = ""
)

# Couleurs pour les messages
function Write-ColorOutput($ForegroundColor) {
    $fc = $host.UI.RawUI.ForegroundColor
    $host.UI.RawUI.ForegroundColor = $ForegroundColor
    if ($args) {
        Write-Output $args
    }
    $host.UI.RawUI.ForegroundColor = $fc
}

Write-ColorOutput Yellow "🔄 Commit et push automatique..."

# Vérifier s'il y a des modifications
$status = git status --porcelain
if ([string]::IsNullOrWhiteSpace($status)) {
    Write-ColorOutput Green "✅ Aucune modification à commiter"
    exit 0
}

# Demander le message de commit
if ([string]::IsNullOrWhiteSpace($Message)) {
    Write-ColorOutput Yellow "Entrez le message de commit (ou appuyez sur Entrée pour un message par défaut):"
    $Message = Read-Host
    if ([string]::IsNullOrWhiteSpace($Message)) {
        $Message = "chore: Mise à jour automatique - $(Get-Date -Format 'yyyy-MM-dd HH:mm:ss')"
    }
}

# Ajouter tous les fichiers
Write-ColorOutput Yellow "📦 Ajout des fichiers..."
git add .

# Créer le commit
Write-ColorOutput Yellow "💾 Création du commit..."
git commit -m $Message

if ($LASTEXITCODE -eq 0) {
    Write-ColorOutput Green "✅ Commit créé avec succès"
    
    # Pousser vers le dépôt distant
    Write-ColorOutput Yellow "🚀 Push vers le dépôt distant..."
    git push origin main
    
    if ($LASTEXITCODE -eq 0) {
        Write-ColorOutput Green "✅ Push réussi !"
    } else {
        Write-ColorOutput Red "❌ Erreur lors du push"
        exit 1
    }
} else {
    Write-ColorOutput Red "❌ Erreur lors de la création du commit"
    exit 1
}

Write-ColorOutput Green "🎉 Terminé avec succès !"

