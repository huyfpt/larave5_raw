<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class HegydPlansSetupTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return  void
     */
    public function up()
    {
        Schema::create('{{ $plansCategoryTable }}', function (Blueprint $table)
        {
            $table->increments('id');

            $table->boolean('active')->default(0);
            $table->string('name')->nullable();
            $table->text('grip')->nullable();

            $table->timestamps();
        });

        Schema::create('{{ $plansTable }}', function (Blueprint $table)
        {
            $table->increments('id');

            $table->boolean('active')->default(0);

            $table->string('title')->nullable();
            $table->longText('content')->nullable();

            $table->boolean('avantage')->default(0);
            $table->boolean('visibility')->default(0);

            $table->string('url')->nullable();

            $table->timestamp('start_at')->nullable();
            $table->timestamp('end_at')->nullable();

            $table->integer('category_id')->unsigned()->nullable();
            $table->foreign('category_id')->references('id')->on('{{ $plansCategoryTable }}');

            $table->integer('author_id')->unsigned()->nullable();
            $table->foreign('author_id')->references('id')->on('users');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return  void
     */
    public function down()
    {
        Schema::dropIfExists('{{ $plansTable }}');
        Schema::dropIfExists('{{ $plansCategoryTable }}');
    }
}