<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up():void
    {
        Schema::table('ticket_messages', function (Blueprint $table) {
            $table->unsignedBigInteger('parent_id')->nullable()->after('ticket_id');
            $table->foreign('parent_id')->references('id')->on('ticket_messages')->onDelete('cascade');
        });
    }

    public function down():void
    {
        Schema::table('ticket_messages', function (Blueprint $table) {
            $table->dropForeign(['parent_id']);
            $table->dropColumn('parent_id');
        });
    }

};
