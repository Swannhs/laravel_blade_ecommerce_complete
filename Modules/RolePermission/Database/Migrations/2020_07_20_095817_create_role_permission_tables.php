<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateRolePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('role_permission', function (Blueprint $table) {
            $table->id();
            $table->integer('permission_id')->nullable();
            $table->integer('role_id')->nullable()->unsigned();
            $table->boolean('status')->default(1);
            $table->integer('created_by')->default(1)->unsigned();
            $table->integer('updated_by')->default(1)->unsigned();
            $table->timestamps();

        });

        DB::statement("INSERT INTO `role_permission` (`id`, `permission_id`, `role_id`, `status`, `created_by`, `updated_by`, `created_at`, `updated_at`) VALUES
        (26, 1, 3, 1, 1, 1, NULL, NULL),
        (27, 2, 3, 1, 1, 1, NULL, NULL),
        (28, 16, 3, 1, 1, 1, NULL, NULL),
        (29, 17, 3, 1, 1, 1, NULL, NULL),
        (30, 18, 3, 1, 1, 1, NULL, NULL),
        (31, 19, 3, 1, 1, 1, NULL, NULL),
        (32, 20, 3, 1, 1, 1, NULL, NULL),
        (33, 21, 3, 1, 1, 1, NULL, NULL),
        (34, 22, 3, 1, 1, 1, NULL, NULL),
        (35, 23, 3, 1, 1, 1, NULL, NULL),
        (36, 24, 3, 1, 1, 1, NULL, NULL),
        (37, 25, 3, 1, 1, 1, NULL, NULL),
        (38, 153, 3, 1, 1, 1, NULL, NULL),
        (39, 154, 3, 1, 1, 1, NULL, NULL),
        (40, 155, 3, 1, 1, 1, NULL, NULL),
        (41, 156, 3, 1, 1, 1, NULL, NULL),
        (42, 157, 3, 1, 1, 1, NULL, NULL),
        (43, 158, 3, 1, 1, 1, NULL, NULL),
        (44, 159, 3, 1, 1, 1, NULL, NULL),
        (45, 160, 3, 1, 1, 1, NULL, NULL),
        (46, 161, 3, 1, 1, 1, NULL, NULL),
        (47, 175, 3, 1, 1, 1, NULL, NULL),
        (48, 198, 3, 1, 1, 1, NULL, NULL),
        (49, 199, 3, 1, 1, 1, NULL, NULL),
        (50, 200, 3, 1, 1, 1, NULL, NULL),
        (51, 201, 3, 1, 1, 1, NULL, NULL),
        (52, 202, 3, 1, 1, 1, NULL, NULL),
        (53, 203, 3, 1, 1, 1, NULL, NULL),
        (54, 204, 3, 1, 1, 1, NULL, NULL),
        (55, 205, 3, 1, 1, 1, NULL, NULL),
        (56, 206, 3, 1, 1, 1, NULL, NULL),
        (57, 207, 3, 1, 1, 1, NULL, NULL),
        (58, 208, 3, 1, 1, 1, NULL, NULL),
        (59, 209, 3, 1, 1, 1, NULL, NULL),
        (60, 210, 3, 1, 1, 1, NULL, NULL),
        (61, 213, 3, 1, 1, 1, NULL, NULL),
        (62, 214, 3, 1, 1, 1, NULL, NULL),
        (63, 215, 3, 1, 1, 1, NULL, NULL),
        (64, 216, 3, 1, 1, 1, NULL, NULL),
        (65, 217, 3, 1, 1, 1, NULL, NULL),
        (66, 218, 3, 1, 1, 1, NULL, NULL),
        (67, 279, 3, 1, 1, 1, NULL, NULL),
        (68, 290, 3, 1, 1, 1, NULL, NULL),
        (69, 291, 3, 1, 1, 1, NULL, NULL),
        (70, 292, 3, 1, 1, 1, NULL, NULL),
        (71, 293, 3, 1, 1, 1, NULL, NULL),
        (72, 294, 3, 1, 1, 1, NULL, NULL),
        (73, 295, 3, 1, 1, 1, NULL, NULL),
        (74, 296, 3, 1, 1, 1, NULL, NULL),
        (75, 297, 3, 1, 1, 1, NULL, NULL),
        (76, 298, 3, 1, 1, 1, NULL, NULL),
        (77, 299, 3, 1, 1, 1, NULL, NULL),
        (78, 300, 3, 1, 1, 1, NULL, NULL),
        (79, 301, 3, 1, 1, 1, NULL, NULL),
        (80, 302, 3, 1, 1, 1, NULL, NULL),
        (81, 303, 3, 1, 1, 1, NULL, NULL),
        (82, 304, 3, 1, 1, 1, NULL, NULL),
        (83, 305, 3, 1, 1, 1, NULL, NULL),
        (84, 306, 3, 1, 1, 1, NULL, NULL),
        (85, 307, 3, 1, 1, 1, NULL, NULL),
        (86, 308, 3, 1, 1, 1, NULL, NULL),
        (87, 309, 3, 1, 1, 1, NULL, NULL),
        (88, 310, 3, 1, 1, 1, NULL, NULL),
        (89, 311, 3, 1, 1, 1, NULL, NULL),
        (90, 464, 3, 1, 1, 1, NULL, NULL),
        (91, 465, 3, 1, 1, 1, NULL, NULL),
        (92, 407, 3, 1, 1, 1, NULL, NULL),
        (93, 408, 3, 1, 1, 1, NULL, NULL),
        (94, 409, 3, 1, 1, 1, NULL, NULL),
        (95, 410, 3, 1, 1, 1, NULL, NULL),
        (96, 411, 3, 1, 1, 1, NULL, NULL),
        (97, 412, 3, 1, 1, 1, NULL, NULL),
        (98, 413, 3, 1, 1, 1, NULL, NULL),
        (99, 414, 3, 1, 1, 1, NULL, NULL),
        (100, 415, 3, 1, 1, 1, NULL, NULL),
        (101, 416, 3, 1, 1, 1, NULL, NULL),
        (102, 417, 3, 1, 1, 1, NULL, NULL),
        (103, 418, 3, 1, 1, 1, NULL, NULL),
        (104, 419, 3, 1, 1, 1, NULL, NULL),
        (105, 420, 3, 1, 1, 1, NULL, NULL),
        (106, 421, 3, 1, 1, 1, NULL, NULL),
        (107, 422, 3, 1, 1, 1, NULL, NULL),
        (108, 423, 3, 1, 1, 1, NULL, NULL),
        (109, 424, 3, 1, 1, 1, NULL, NULL),
        (110, 425, 3, 1, 1, 1, NULL, NULL),
        (111, 426, 3, 1, 1, 1, NULL, NULL),
        (112, 427, 3, 1, 1, 1, NULL, NULL),
        (113, 428, 3, 1, 1, 1, NULL, NULL),
        (114, 429, 3, 1, 1, 1, NULL, NULL),
        (115, 430, 3, 1, 1, 1, NULL, NULL),
        (116, 431, 3, 1, 1, 1, NULL, NULL),
        (117, 432, 3, 1, 1, 1, NULL, NULL),

        (122, 496, 3, 1, 1, 1, NULL, NULL),
        (124, 497, 3, 1, 1, 1, NULL, NULL),

        
        (130, 516, 3, 1, 1, 1, NULL, NULL)
        
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('role_permission');
    }
}