<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class LogoController extends Controller
{
    // Types de logos avec dimensions recommandées
    private $logoTypes = [
        'header' => [
            'name' => 'Logo Header',
            'description' => 'Logo principal affiché dans l\'en-tête du site',
            'width' => 200,
            'height' => 60,
            'recommended' => '200x60px (format PNG ou SVG)',
        ],
        'footer' => [
            'name' => 'Logo Footer',
            'description' => 'Logo affiché dans le pied de page',
            'width' => 150,
            'height' => 45,
            'recommended' => '150x45px (format PNG ou SVG)',
        ],
        'email' => [
            'name' => 'Logo Email',
            'description' => 'Logo utilisé dans les emails',
            'width' => 200,
            'height' => 60,
            'recommended' => '200x60px (format PNG)',
        ],
        'pdf' => [
            'name' => 'Logo PDF',
            'description' => 'Logo affiché sur les billets PDF',
            'width' => 150,
            'height' => 45,
            'recommended' => '150x45px (format PNG)',
        ],
        'favicon' => [
            'name' => 'Favicon',
            'description' => 'Icône du site (onglet navigateur)',
            'width' => 32,
            'height' => 32,
            'recommended' => '32x32px ou 64x64px (format ICO ou PNG)',
        ],
        'mobile' => [
            'name' => 'Logo Mobile',
            'description' => 'Logo optimisé pour mobile',
            'width' => 120,
            'height' => 36,
            'recommended' => '120x36px (format PNG)',
        ],
    ];

    public function index()
    {
        $logos = Logo::orderBy('type')->get();
        $types = $this->logoTypes;
        
        return view('dashboard.admin.logos.index', compact('logos', 'types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|in:' . implode(',', array_keys($this->logoTypes)),
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
        ]);

        $type = $request->type;
        $typeConfig = $this->logoTypes[$type];

        // Upload du fichier
        $file = $request->file('logo');
        $filename = 'logos/' . $type . '_' . time() . '.' . $file->getClientOriginalExtension();
        
        // Si c'est une image (pas SVG), redimensionner si nécessaire
        if ($file->getClientOriginalExtension() !== 'svg' && $file->getClientOriginalExtension() !== 'ico') {
            $image = Image::make($file);
            
            // Redimensionner en gardant les proportions
            if ($typeConfig['width'] && $typeConfig['height']) {
                $image->resize($typeConfig['width'], $typeConfig['height'], function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();
                });
            }
            
            Storage::disk('public')->put($filename, $image->encode());
        } else {
            // Pour SVG et ICO, copier directement
            Storage::disk('public')->put($filename, file_get_contents($file));
        }

        // Désactiver l'ancien logo du même type
        Logo::where('type', $type)->update(['is_active' => false]);

        // Créer le nouveau logo
        Logo::create([
            'type' => $type,
            'name' => $typeConfig['name'],
            'path' => $filename,
            'width' => $typeConfig['width'],
            'height' => $typeConfig['height'],
            'description' => $typeConfig['description'],
            'is_active' => true,
        ]);

        return back()->with('success', 'Logo uploadé avec succès.');
    }

    public function update(Request $request, Logo $logo)
    {
        $request->validate([
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,ico|max:2048',
            'is_active' => 'boolean',
        ]);

        // Si un nouveau fichier est uploadé
        if ($request->hasFile('logo')) {
            // Supprimer l'ancien fichier
            if ($logo->path && Storage::disk('public')->exists($logo->path)) {
                Storage::disk('public')->delete($logo->path);
            }

            $file = $request->file('logo');
            $typeConfig = $this->logoTypes[$logo->type];
            $filename = 'logos/' . $logo->type . '_' . time() . '.' . $file->getClientOriginalExtension();
            
            // Redimensionner si nécessaire
            if ($file->getClientOriginalExtension() !== 'svg' && $file->getClientOriginalExtension() !== 'ico') {
                $image = Image::make($file);
                
                if ($typeConfig['width'] && $typeConfig['height']) {
                    $image->resize($typeConfig['width'], $typeConfig['height'], function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    });
                }
                
                Storage::disk('public')->put($filename, $image->encode());
            } else {
                Storage::disk('public')->put($filename, file_get_contents($file));
            }

            $logo->update([
                'path' => $filename,
                'is_active' => $request->has('is_active') ? true : false,
            ]);
        } else {
            $logo->update([
                'is_active' => $request->has('is_active') ? true : false,
            ]);
        }

        return back()->with('success', 'Logo mis à jour avec succès.');
    }

    public function destroy(Logo $logo)
    {
        if ($logo->path && Storage::disk('public')->exists($logo->path)) {
            Storage::disk('public')->delete($logo->path);
        }

        $logo->delete();

        return back()->with('success', 'Logo supprimé avec succès.');
    }
}
