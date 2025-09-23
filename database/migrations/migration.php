<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::connection('mongodb')->table('users', function ($collection) {
            $collection->index('username');
        });
    }

    public function down()
    {
        Schema::connection('mongodb')->table('users', function ($collection) {
            $collection->dropIndex(['username']);
        });
    }
};
