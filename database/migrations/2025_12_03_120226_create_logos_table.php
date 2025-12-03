<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('logos', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // header, footer, email, pdf, favicon, etc.
            $table->string('name'); // Nom descriptif
            $table->string('path'); // Chemin du fichier
            $table->integer('width')->nullable(); // Largeur recommandée
            $table->integer('height')->nullable(); // Hauteur recommandée
            $table->text('description')->nullable(); // Description de l'usage
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logos');
    }
};
