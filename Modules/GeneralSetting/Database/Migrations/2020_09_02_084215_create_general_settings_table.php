<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Modules\GeneralSetting\Entities\GeneralSetting;


class CreateGeneralSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_settings', function (Blueprint $table) {
            $table->id();
            $table->string('site_title')->nullable();
            $table->string('company_name')->nullable();
            $table->unsignedBigInteger('country_id')->default(18)->nullable();
            $table->unsignedBigInteger('state_id')->default(348)->nullable();
            $table->unsignedBigInteger('city_id')->default(7291)->nullable();
            $table->string('country_name')->nullable();
            $table->longText('company_info')->nullable();
            $table->Text('file_supported')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('vat_number')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('currency')->nullable()->default('USD');
            $table->string('currency_symbol')->nullable()->default('$');
            $table->integer('promotionSetting')->nullable()->default(0);
            $table->string('logo')->default('/uploads/settings/logo.png');
            $table->string('favicon')->default('/uploads/settings/favicon.png');
            $table->string('shop_link_banner')->default('frontend/default/img/breadcrumb_bg.png');
            $table->string('system_version')->nullable()->default('1.0');
            $table->integer('active_status')->nullable()->default(1);
            $table->string('currency_code')->nullable()->default('USD');
            $table->string('language_name')->nullable()->default('en');
            $table->string('system_purchase_code')->nullable();
            $table->date('system_activated_date')->nullable();
            $table->string('envato_user')->nullable();
            $table->string('envato_item_id')->nullable();
            $table->string('system_domain')->nullable();
            $table->string('copyright_text')->nullable();
            $table->integer('website_btn')->default(1);
            $table->integer('dashboard_btn')->default(1);
            $table->integer('report_btn')->default(1);
            $table->integer('style_btn')->default(1);
            $table->integer('ltl_rtl_btn')->default(1);
            $table->integer('lang_btn')->default(1);
            $table->string('website_url')->nullable();
            $table->integer('ttl_rtl')->default(2);
            $table->integer('phone_number_privacy')->default(1)->comment('1 = enable, 0 = disable');
            $table->string('time_zone', 100)->default('Asia/Dhaka')->nullable();
            $table->string('language_code', 100)->default('en')->nullable();
            $table->string('date_format_id', 100)->default('1')->nullable();
            $table->string('software_version', 100)->nullable();
            $table->string('mail_signature')->nullable();
            $table->string('mail_header')->nullable();
            $table->string('mail_footer')->nullable();
            $table->string('mail_protocol', 100)->default('sendmail')->nullable();
            $table->string('preloader', 100)->nullable()->default('infix');
            $table->longText('email_template')->nullable();
            $table->string('up_sale_product_display_title', 150)->nullable()->default('Up Sale Products');
            $table->string('cross_sale_product_display_title', 150)->nullable()->default('Cross Sale Products');
            $table->string('footer_about_title')->default('About');
            $table->text('footer_about_description')->nullable();
            $table->text('footer_copy_right')->nullable();
            $table->string('footer_section_one_title')->default('Company');
            $table->string('footer_section_two_title')->default('My Account');
            $table->string('footer_section_three_title')->default('Services');

            $table->string('maintenance_title')->nullable();
            $table->string('maintenance_subtitle')->nullable();
            $table->string('maintenance_banner')->nullable();
            $table->boolean('maintenance_status')->default(0);
            $table->boolean('auto_approve_wallet_status')->default(0);
            $table->boolean('auto_approve_seller')->default(1);
            $table->boolean('auto_approve_product_review')->default(0);
            $table->boolean('auto_approve_seller_review')->default(0);
            $table->boolean('track_order_by_secret_id')->default(0);
            $table->boolean('track_order_by_phone')->default(1);

            $table->string('facebook_client_id')->nullable();
            $table->string('facebook_client_secret')->nullable();
            $table->boolean('facebook_status')->default(1);

            $table->string('google_client_id')->nullable();
            $table->string('google_client_secret')->nullable();
            $table->boolean('google_status')->default(1);

            $table->string('twitter_client_id')->nullable();
            $table->string('twitter_client_secret')->nullable();
            $table->boolean('twitter_status')->default(0);

            $table->string('linkedin_client_id')->nullable();
            $table->string('linkedin_client_secret')->nullable();
            $table->boolean('linkedin_status')->default(0);

            $table->boolean('multi_category')->default(1);
            $table->unsignedTinyInteger('commission_by')->default(1);


            $table->timestamps();
        });


        $sql_path = base_path('static_sql/sql.sql');
        DB::unprepared(file_get_contents($sql_path));

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('general_settings');
    }
}
