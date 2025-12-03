<?php
/**
 * Script pour générer les icônes PWA à partir d'un fichier SVG source
 * 
 * Prérequis : ImageMagick doit être installé
 * Usage : php scripts/generate-pwa-icons.php
 */

$sizes = [72, 96, 128, 144, 152, 192, 384, 512];
$sourceSvg = __DIR__ . '/../public/icons/icon.svg';
$outputDir = __DIR__ . '/../public/icons/';

if (!file_exists($sourceSvg)) {
    echo "Erreur : Le fichier source $sourceSvg n'existe pas.\n";
    exit(1);
}

// Vérifier si ImageMagick est disponible
$imagickAvailable = extension_loaded('imagick');
$commandAvailable = shell_exec('which convert') || shell_exec('where convert');

if (!$imagickAvailable && !$commandAvailable) {
    echo "Attention : ImageMagick n'est pas installé.\n";
    echo "Vous pouvez installer ImageMagick ou utiliser un outil en ligne.\n";
    echo "Voir public/icons/README.md pour plus d'informations.\n\n";
    
    // Générer des instructions
    echo "Pour générer les icônes manuellement :\n";
    foreach ($sizes as $size) {
        echo "  - Créez icon-{$size}x{$size}.png à partir de icon.svg\n";
    }
    exit(0);
}

echo "Génération des icônes PWA...\n\n";

foreach ($sizes as $size) {
    $outputFile = $outputDir . "icon-{$size}x{$size}.png";
    
    if ($imagickAvailable) {
        // Utiliser Imagick PHP
        try {
            $imagick = new Imagick();
            $imagick->setBackgroundColor(new ImagickPixel('transparent'));
            $imagick->readImage($sourceSvg);
            $imagick->setImageFormat('png');
            $imagick->resizeImage($size, $size, Imagick::FILTER_LANCZOS, 1);
            $imagick->writeImage($outputFile);
            $imagick->clear();
            echo "✓ Généré : icon-{$size}x{$size}.png\n";
        } catch (Exception $e) {
            echo "✗ Erreur pour {$size}x{$size}: " . $e->getMessage() . "\n";
        }
    } else {
        // Utiliser la commande convert
        $command = sprintf(
            'convert -background transparent -resize %dx%d %s %s',
            $size,
            $size,
            escapeshellarg($sourceSvg),
            escapeshellarg($outputFile)
        );
        
        exec($command, $output, $returnCode);
        
        if ($returnCode === 0 && file_exists($outputFile)) {
            echo "✓ Généré : icon-{$size}x{$size}.png\n";
        } else {
            echo "✗ Erreur pour {$size}x{$size}\n";
        }
    }
}

echo "\n✓ Génération terminée !\n";
echo "Les icônes sont disponibles dans : public/icons/\n";

