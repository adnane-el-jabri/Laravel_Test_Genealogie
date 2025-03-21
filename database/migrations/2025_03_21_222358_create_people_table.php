<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
{
    Schema::create('people', function (Blueprint $table) {
        $table->id(); // équivalent à bigint unsigned auto_increment + primary
        $table->unsignedBigInteger('created_by');
        $table->string('first_name', 255)->collation('utf8mb4_unicode_ci');
        $table->string('last_name', 255)->collation('utf8mb4_unicode_ci');
        $table->string('birth_name', 255)->collation('utf8mb4_unicode_ci')->nullable();
        $table->string('middle_names', 255)->collation('utf8mb4_unicode_ci')->nullable();
        $table->date('date_of_birth')->nullable();
        $table->timestamps();

        $table->index('created_by'); 
    });
}


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('people');
    }
}
