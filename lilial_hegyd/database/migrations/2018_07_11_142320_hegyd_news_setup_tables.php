<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class HegydNewsSetupTables extends Migration
{

    /**
     * Run the migrations.
     *
     * @return    void
     */
    public function up()
    {

        Schema::table('news', function (Blueprint $table)
        {
            $table->boolean('enable_comment')->default(0);
        });

        Schema::create('news_role', function (Blueprint $table)
        {
            $table->integer('news_id')->unsigned();
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');

            $table->integer('role_id')->unsigned();
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });

        Schema::create('news_likes', function (Blueprint $table)
        {
            $table->increments('id');

            $table->integer('news_id')->unsigned();
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('status')->default(0);
        });

        Schema::create('news_comments', function (Blueprint $table)
        {
            $table->increments('id');

            $table->boolean('active')->default(0);

            $table->string('name')->nullable();
            $table->longText('content')->nullable();

            $table->integer('news_id')->unsigned();
            $table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');

            $table->integer('author_id')->unsigned();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');

            $table->integer('parent_id')->unsigned()->nullable();
            $table->foreign('parent_id')->references('id')->on('news_comments');

            $table->timestamps();

            $table->softDeletes();
        });

        Schema::create('news_comments_report', function (Blueprint $table)
        {
            $table->increments('id');

            $table->string('name')->nullable();
            $table->longText('content')->nullable();

            $table->boolean('active')->default(0);

            $table->integer('comment_id')->unsigned();
            $table->foreign('comment_id')->references('id')->on('news_comments')->onDelete('cascade');

            $table->integer('author_id')->unsigned();
            $table->foreign('author_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return    void
     */
    public function down()
    {

        Schema::table('news', function (Blueprint $table)
        {
            $table->dropColumn('enable_comment');
        });
        Schema::dropIfExists('news_role');
        Schema::dropIfExists('news_comments');
        Schema::dropIfExists('news_likes');
        Schema::dropIfExists('news_comments_report');
    }
}