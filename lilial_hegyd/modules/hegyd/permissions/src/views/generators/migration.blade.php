<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class HegydPermissionsSetupTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        if ( ! Schema::hasTable('roles'))
        {
            // Create table for storing roles
            Schema::create('roles', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name')->unique();
                $table->string('display_name')->nullable();
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        if ( ! Schema::hasTable('role_user'))
        {
            // Create table for associating roles to users (Many-to-Many)
            Schema::create('role_user', function (Blueprint $table)
            {
                $table->integer('user_id')->unsigned();
                $table->integer('role_id')->unsigned();

                $table->foreign('user_id')->references('id')->on('users')
                        ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('role_id')->references('id')->on('roles')
                        ->onUpdate('cascade')->onDelete('cascade');

                $table->primary(['user_id', 'role_id']);
            });
        }

        if ( ! Schema::hasTable('permissions'))
        {
            // Create table for storing permissions
            Schema::create('permissions', function (Blueprint $table)
            {
                $table->increments('id');
                $table->string('name')->unique();
                $table->string('display_name')->nullable();
                $table->string('description')->nullable();
                $table->timestamps();
            });
        }

        if ( ! Schema::hasTable('permission_role'))
        {
            // Create table for associating permissions to roles (Many-to-Many)
            Schema::create('permission_role', function (Blueprint $table)
            {
                $table->integer('permission_id')->unsigned();
                $table->integer('role_id')->unsigned();

                $table->foreign('permission_id')->references('id')->on('permissions')
                        ->onUpdate('cascade')->onDelete('cascade');
                $table->foreign('role_id')->references('id')->on('roles')
                        ->onUpdate('cascade')->onDelete('cascade');

                $table->primary(['permission_id', 'role_id']);
            });
        }

        if ( ! Schema::hasTable('category_permission'))
        {
            // Create table for storing permissions categories
            Schema::create('category_permission', function (Blueprint $table)
            {
                $table->increments('id');

                $table->string('key');
                $table->string('name');

                $table->integer('parent_id')->unsigned()->nullable();
                $table->foreign('parent_id')->references('id')->on('category_permission');
                $table->timestamps();
            });
        }
        if ( ! Schema::hasColumn('permissions', 'category_id'))
        {
            Schema::table('permissions', function (Blueprint $table)
            {
                $table->integer('category_id')->unsigned();
                $table->foreign('category_id')->references('id')->on('category_permission');
            });
        }

    }

    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        if (Schema::hasColumn('permissions', 'category_id'))
        {
            Schema::table('permissions', function (Blueprint $table)
            {
                $table->dropForeign('permission_category_id_foreign');
                $table->dropColumn('category_id');
            });
        }

        Schema::dropIfExists('category_permission');
        Schema::dropIfExists('permission_role');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_user');
        Schema::dropIfExists('roles');
    }
}