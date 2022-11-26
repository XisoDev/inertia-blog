<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->uuid('id')->primary();

            $table->foreignUuid('blog_id');

            $table->foreignUuid('tenant_id');
            $table->string('slug');
            $table->unique(['tenant_id','slug'],'unique_slug_per_tenant');

            $table->string('type',40)->default('post');

            //회원으로 작성시
            $table->foreignUuid('user_id')->nullable()->comment('로그인사용자가 작성시에만 채워진다.');

            //비회원으로 작성시
            $table->string('author',200)->nullable()->comment('비회원 작성시에만 채워진다.');
            $table->string('email',255)->nullable()->comment('비회원 작성시에만 채워진다.');
            $table->string('certify_key',200)->nullable()->comment('비회원 작성시에만 채워진다.');

            $table->bigInteger('read_count');
            $table->bigInteger('comment_count');
            $table->bigInteger('assent_count')->comment('좋아요 또는 추천');
            $table->bigInteger('dissent_count')->comment('싫어요 또는 비추천');

            $table->json('title')->nullable();
            $table->json('description')->nullable();
            $table->json('content')->nullable();
            $table->json('data')->nullable();

            $table->enum('approved',['P','W','R','A'])->default('P')->comment('문서를 게시할 때 관리자 승인을 거쳐야하는경우 사용된다. public, waiting, rejected 로 활용하고 심사가 완료된 이후에 결제 등 다른 단계가 필요한경우 approved를 활용할 수 있다.');
            $table->enum('published',['P','B'])->default('P')->comment('비밀글 여부에 활용된다. public, blind 를 활용할 수 있다.');
            $table->enum('status',['P','T','D'])->default('P')->comment('문서 상태를 관리한다. public, temp, drop(trashed) 으로 관리된다. 어차피 soft delete 를 쓸거라서 D는 별 의미는없다.');

            $table->string('ipaddress',16);

            $table->bigInteger('order_id');
            $table->timestamp('published_at')->nullable()->comment('기본적으로 created_at과 같지만 예약문서 등을 관리할 때는 공개일자를 바꿀 수 있다. 문서 조회시에는 항상 현재시간보다 published_at이 작은것만 불러오면 된다.');
            $table->softDeletes();
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
        Schema::dropIfExists('posts');
    }
};
