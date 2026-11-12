<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBriefFormWorkflowTables extends Migration
{
    public function up()
    {
        Schema::create('brief_forms', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title');
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('brief_form_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('brief_form_id');
            $table->string('label');
            $table->string('field_type', 30);
            $table->text('help_text')->nullable();
            $table->longText('options')->nullable();
            $table->boolean('is_required')->default(false);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->index(['brief_form_id', 'is_active']);
        });

        Schema::create('brief_form_requests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('brief_form_id');
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('client_id');
            $table->unsignedBigInteger('support_person_id');
            $table->string('form_title');
            $table->longText('fields_snapshot');
            $table->char('access_token_hash', 64)->unique();
            $table->string('status', 20)->default('sent');
            $table->string('email_status', 20)->default('pending');
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('sent_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->timestamps();
            $table->index(['client_id', 'status']);
            $table->index(['support_person_id', 'status']);
            $table->index('order_id');
        });

        Schema::create('brief_form_submissions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('brief_form_request_id')->unique();
            $table->longText('answers');
            $table->string('pdf_path')->nullable();
            $table->timestamp('submitted_at');
            $table->timestamps();
        });

        $permissions = [
            ['name' => 'Manage Brief Forms', 'slug' => 'manage_brief_forms'],
            ['name' => 'Send Brief Forms', 'slug' => 'send_brief_forms'],
            ['name' => 'View Brief Submissions', 'slug' => 'view_brief_submissions'],
        ];

        foreach ($permissions as $permission) {
            $permissionId = DB::table('permissions')->where('slug', $permission['slug'])->value('id');
            if (!$permissionId) {
                $permissionId = DB::table('permissions')->insertGetId([
                    'name' => $permission['name'],
                    'slug' => $permission['slug'],
                    'is_active' => 1,
                    'is_deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $projectManagerRoleId = DB::table('roles')->where('role', 'Project Manager')->value('id');
            if ($projectManagerRoleId && !DB::table('role_permissions')
                ->where('role_id', $projectManagerRoleId)
                ->where('permissions_id', $permissionId)
                ->exists()) {
                DB::table('role_permissions')->insert([
                    'role_id' => $projectManagerRoleId,
                    'permissions_id' => $permissionId,
                    'is_active' => 1,
                    'is_deleted' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down()
    {
        $permissionIds = DB::table('permissions')
            ->whereIn('slug', ['manage_brief_forms', 'send_brief_forms', 'view_brief_submissions'])
            ->pluck('id')
            ->toArray();

        if (!empty($permissionIds)) {
            DB::table('role_permissions')->whereIn('permissions_id', $permissionIds)->delete();
            DB::table('permissions')->whereIn('id', $permissionIds)->delete();
        }

        Schema::dropIfExists('brief_form_submissions');
        Schema::dropIfExists('brief_form_requests');
        Schema::dropIfExists('brief_form_fields');
        Schema::dropIfExists('brief_forms');
    }
}
