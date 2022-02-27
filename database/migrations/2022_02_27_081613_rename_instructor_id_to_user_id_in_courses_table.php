<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Doctrine\DBAL\Driver\AbstractMySQLDriver;
class RenameInstructorIdToUserIdInCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('courses', function (Blueprint $table) {
            //
            //$table->renameColumn('instructor_id', 'user_id');
            $table->dropForeign('courses_instructor_id_foreign');
            $table->dropIndex('courses_instructor_id_foreign');
            $table->dropColumn('instructor_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('courses', function (Blueprint $table) {
            //
            //$table->renameColumn('user_id', 'instructor_id');
        });
    }
}
