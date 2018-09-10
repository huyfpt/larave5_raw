<?php echo '<?php' ?>

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateHegydPagesTable extends Migration
{
    /**
    * Run the migrations.
    *
    * @return void
    */
    public function up()
    {
        Schema::create('{{ $pagesTable }}', function(Blueprint $table)
        {
            $table->increments('id');
            $table->text('description');
            $table->text('content');
            $table->integer('user_id')->unsigned()->nullable();
            $table->boolean('status');
            $table->timestamps();
        });
    }

    /**
    * Reverse the migrations.
    *
    * @return void
    */
    public function down()
    {
        Schema::dropIfExists('{{ $pagesTable }}');
    }
}