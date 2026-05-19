<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                ->constrained('categories')
                ->onDelete('restrict');
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('author', 200);
            $table->string('publisher', 200)->nullable();
            $table->string('isbn', 20)->unique()->nullable();
            $table->year('published_year')->nullable();
            $table->text('synopsis')->nullable();
            $table->string('cover_image')->nullable()->comment('Path relatif dari storage/app/public');
            $table->unsignedSmallInteger('total_stock')->default(1);
            $table->unsignedSmallInteger('available_stock')->default(1);
            $table->unsignedInteger('borrow_count')->default(0)->comment('Akumulasi jumlah peminjaman');
            $table->timestamps();
            $table->softDeletes();

            $table->index(['title', 'author']);
            $table->index('available_stock');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
