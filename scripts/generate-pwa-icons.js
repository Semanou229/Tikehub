/**
 * Script Node.js pour générer les icônes PWA à partir d'un fichier SVG
 * 
 * Prérequis : 
 *   npm install sharp
 * 
 * Usage : node scripts/generate-pwa-icons.js
 */

const fs = require('fs');
const path = require('path');

// Vérifier si sharp est disponible
let sharp;
try {
  sharp = require('sharp');
} catch (e) {
  console.error('Erreur : Le module "sharp" n\'est pas installé.');
  console.error('Installez-le avec : npm install sharp');
  process.exit(1);
}

const sizes = [72, 96, 128, 144, 152, 192, 384, 512];
const sourceSvg = path.join(__dirname, '../public/icons/icon.svg');
const outputDir = path.join(__dirname, '../public/icons/');

// Vérifier que le fichier source existe
if (!fs.existsSync(sourceSvg)) {
  console.error(`Erreur : Le fichier source ${sourceSvg} n'existe pas.`);
  process.exit(1);
}

// Créer le dossier de sortie s'il n'existe pas
if (!fs.existsSync(outputDir)) {
  fs.mkdirSync(outputDir, { recursive: true });
}

console.log('Génération des icônes PWA...\n');

// Générer les icônes
async function generateIcons() {
  for (const size of sizes) {
    const outputFile = path.join(outputDir, `icon-${size}x${size}.png`);
    
    try {
      await sharp(sourceSvg)
        .resize(size, size, {
          fit: 'contain',
          background: { r: 255, g: 255, b: 255, alpha: 0 }
        })
        .png()
        .toFile(outputFile);
      
      console.log(`✓ Généré : icon-${size}x${size}.png`);
    } catch (error) {
      console.error(`✗ Erreur pour ${size}x${size}:`, error.message);
    }
  }
  
  console.log('\n✓ Génération terminée !');
  console.log(`Les icônes sont disponibles dans : ${outputDir}`);
}

generateIcons().catch(console.error);

