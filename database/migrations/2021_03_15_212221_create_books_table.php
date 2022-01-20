<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('isbn', 17)->nullable();
            $table->string('code')->nullable();

            $table->string('author_first_name')->nullable();
            $table->string('author_middle_name')->nullable();
            $table->string('author_last_name');


            if(config('database.default') === "sqlite") {
                $table->string('author')->virtualAs("coalesce(author_first_name, '') || CASE WHEN coalesce(author_first_name, '') <> '' AND (coalesce(author_middle_name, '') <> '' OR coalesce(author_last_name, '') <> '') THEN ' ' ELSE '' END || coalesce(author_middle_name, '') || CASE WHEN coalesce(author_middle_name, '') <> '' AND coalesce(author_last_name, '') <> '' THEN ' ' ELSE '' END || coalesce(author_last_name, '')");
            }
            else {
                $table->string('author')->virtualAs("CONCAT_WS(' ',author_first_name,author_middle_name,author_last_name)");
            }

            $table->boolean('maturita')->default(false);
            $table->foreignId('book_section_id')->nullable();
            $table->foreignId('book_collection_id')->default(1);

            $table->foreignId('book_import_id')->nullable();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('books');
    }
}
