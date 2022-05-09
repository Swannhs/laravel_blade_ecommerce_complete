<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePermissionsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permissions', function (Blueprint $table) {
            $table->integer('id');
            $table->integer('module_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('name')->nullable();
            $table->string('route')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->integer('created_by')->default(1)->unsigned();
            $table->integer('updated_by')->default(1)->unsigned();
            $table->integer('type')->nullable()->comment('1 for main menu, 2 for sub menu , 3 action');
            $table->string('module')->nullable();
            $table->timestamps();
        });

    $sql = [
        // Dashboard
        ['id'  => 1, 'module_id' => 1, 'parent_id' => null, 'name' => 'Dashboard', 'route' => 'admin.dashboard', 'type' => 1 ],
        ['id'  => 2, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Widget', 'route' => 'widget_card', 'type' => 2 ],
        ['id'  => 577, 'module_id' => 1, 'parent_id' => 2, 'name' => 'Total Product', 'route' => 'widget_total_product', 'type' => 3 ],
        ['id'  => 579, 'module_id' => 1, 'parent_id' => 2, 'name' => 'Total Customer', 'route' => 'widget_total_customer', 'type' => 3 ],
        ['id'  => 580, 'module_id' => 1, 'parent_id' => 2, 'name' => 'Visitor', 'route' => 'widget_visitor', 'type' => 3 ],
        ['id'  => 581, 'module_id' => 1, 'parent_id' => 2, 'name' => 'Total Order', 'route' => 'widget_total_order', 'type' => 3 ],
        ['id'  => 582, 'module_id' => 1, 'parent_id' => 2, 'name' => 'Total Pending Order', 'route' => 'widget_total_pending_order', 'type' => 3 ],
        ['id'  => 583, 'module_id' => 1, 'parent_id' => 2, 'name' => 'Total Completed Order', 'route' => 'widget_total_completed_order', 'type' => 3 ],
        ['id'  => 584, 'module_id' => 1, 'parent_id' => 2, 'name' => 'Total Sale', 'route' => 'widget_total_sale', 'type' => 3 ],
        ['id'  => 585, 'module_id' => 1, 'parent_id' => 2, 'name' => 'Total Review', 'route' => 'widget_total_review', 'type' => 3 ],
        ['id'  => 586, 'module_id' => 1, 'parent_id' => 2, 'name' => 'Total Revenue', 'route' => 'widget_total_revenue', 'type' => 3 ],
        ['id'  => 587, 'module_id' => 1, 'parent_id' => 2, 'name' => 'Active Customer', 'route' => 'widget_active_customer', 'type' => 3 ],
        ['id'  => 588, 'module_id' => 1, 'parent_id' => 2, 'name' => 'Total Subcriber', 'route' => 'widget_total_subcriber', 'type' => 3 ],

        ['id'  => 589, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Graph', 'route' => 'dashboard_graph', 'type' => 2 ],
        ['id'  => 590, 'module_id' => 1, 'parent_id' => 589, 'name' => 'Products', 'route' => 'dashboard_graph_products', 'type' => 3 ],
        ['id'  => 591, 'module_id' => 1, 'parent_id' => 589, 'name' => 'Orders Summary', 'route' => 'dashboard_graph_orders_summary', 'type' => 3 ],
        ['id'  => 593, 'module_id' => 1, 'parent_id' => 589, 'name' => 'Guest/Authorized Order Today', 'route' => 'dashboard_graph_gueast_authorize_order_today', 'type' => 3 ],
        ['id'  => 594, 'module_id' => 1, 'parent_id' => 589, 'name' => 'Today Order summary', 'route' => 'dashboard_graph_today_order_summary', 'type' => 3 ],
        ['id'  => 595, 'module_id' => 1, 'parent_id' => 589, 'name' => 'Site Analytics', 'route' => 'dashboard_graph_site_analytics', 'type' => 3 ],

        ['id'  => 596, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Top Ten Product', 'route' => 'dashboard_top_ten_product', 'type' => 2 ],
        ['id'  => 598, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Category Wise Product Qty', 'route' => 'dashboard_category_wise_product_qty', 'type' => 2 ],
        ['id'  => 599, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Category Wise Product Sale', 'route' => 'dashboard_category_wise_product_sale', 'type' => 2 ],
        ['id'  => 600, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Coupon Wise Sale', 'route' => 'dashboard_coupon_wise_sale', 'type' => 2 ],
        ['id'  => 601, 'module_id' => 1, 'parent_id' => 1, 'name' => 'New Customers', 'route' => 'dashboard_new_customers', 'type' => 2 ],
        ['id'  => 602, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Recently Added Products', 'route' => 'dashboard_recently_added_products', 'type' => 2 ],
        ['id'  => 603, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Top Refferers', 'route' => 'dashboard_top_refferers', 'type' => 2 ],
        ['id'  => 604, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Latest Order', 'route' => 'dashboard_latest_order', 'type' => 2 ],
        ['id'  => 605, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Latest Search Keyword', 'route' => 'dashboard_latest_search_keyword', 'type' => 2 ],
        ['id'  => 606, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Appealed Disputed', 'route' => 'dashboard_appealed_disputed', 'type' => 2 ],
        ['id'  => 607, 'module_id' => 1, 'parent_id' => 1, 'name' => 'Recent Reviews', 'route' => 'dashboard_recent_reviews', 'type' => 2 ],

        ['id'  => 4, 'module_id' => 1, 'parent_id' => 68, 'name' => 'Dashboard Setup', 'route' => 'appearance.dashoboard.index', 'type' => 2 ],
        ['id'  => 5, 'module_id' => 1, 'parent_id' => 4, 'name' => 'Update', 'route' => 'appearance.dashoboard.status_update', 'type' => 3 ],


        

        // FrontendCMS
        ['id'  => 26, 'module_id' => 3, 'parent_id' => null, 'name' => 'Frontend CMS', 'route' => 'frontend_cms', 'type' => 1 ],
        ['id'  => 27, 'module_id' => 3, 'parent_id' => 26, 'name' => 'Homepage', 'route' => 'frontendcms.widget.index', 'type' => 2 ],
        ['id'  => 28, 'module_id' => 3, 'parent_id' => 27, 'name' => 'Update', 'route' => 'frontendcms.homepage.update', 'type' => 3 ],
        ['id'  => 29, 'module_id' => 3, 'parent_id' => 26, 'name' => 'Feature List', 'route' => 'frontendcms.features.index', 'type' => 2 ],
        ['id'  => 30, 'module_id' => 3, 'parent_id' => 29, 'name' => 'Create', 'route' => 'frontendcms.features.store', 'type' => 3 ],
        ['id'  => 31, 'module_id' => 3, 'parent_id' => 29, 'name' => 'Update', 'route' => 'frontendcms.features.update', 'type' => 3 ],
        ['id'  => 32, 'module_id' => 3, 'parent_id' => 29, 'name' => 'Destroy', 'route' => 'frontendcms.features.delete', 'type' => 3 ],
        ['id'  => 40, 'module_id' => 3, 'parent_id' => 26, 'name' => 'Return Exchange', 'route' => 'frontendcms.return-exchange.index', 'type' => 2 ],
        ['id'  => 41, 'module_id' => 3, 'parent_id' => 40, 'name' => 'Return Exchange Update', 'route' => 'frontendcms.return-exchange.update', 'type' => 3 ],
        ['id'  => 42, 'module_id' => 3, 'parent_id' => 26, 'name' => 'Contact-Content', 'route' => 'frontendcms.contact-content.index', 'type' => 2 ],
        ['id'  => 43, 'module_id' => 3, 'parent_id' => 42, 'name' => 'Contact-Content Update', 'route' => 'frontendcms.contact-content.update', 'type' => 3 ],
        ['id'  => 44, 'module_id' => 3, 'parent_id' => 42, 'name' => 'Query Create', 'route' => 'frontendcms.query.store', 'type' => 3 ],
        ['id'  => 45, 'module_id' => 3, 'parent_id' => 42, 'name' => 'Query Update', 'route' => 'frontendcms.query.update', 'type' => 3 ],
        ['id'  => 46, 'module_id' => 3, 'parent_id' => 42, 'name' => 'Query Destroy', 'route' => 'frontendcms.query.delete', 'type' => 3 ],
        ['id'  => 47, 'module_id' => 3, 'parent_id' => 42, 'name' => 'Query Status Change', 'route' => 'frontendcms.query.status', 'type' => 3 ],
        ['id'  => 48, 'module_id' => 3, 'parent_id' => 26, 'name' => 'Dynamic Page', 'route' => 'frontendcms.dynamic-page.index', 'type' => 2 ],
        ['id'  => 49, 'module_id' => 3, 'parent_id' => 48, 'name' => 'Create', 'route' => 'frontendcms.dynamic-page.store', 'type' => 3 ],
        ['id'  => 50, 'module_id' => 3, 'parent_id' => 48, 'name' => 'Update', 'route' => 'frontendcms.dynamic-page.update', 'type' => 3 ],
        ['id'  => 51, 'module_id' => 3, 'parent_id' => 48, 'name' => 'Destroy', 'route' => 'frontendcms.dynamic-page.delete', 'type' => 3 ],
        ['id'  => 52, 'module_id' => 3, 'parent_id' => 48, 'name' => 'Status Change', 'route' => 'frontendcms.dynamic-page.status', 'type' => 3 ],
        ['id'  => 53, 'module_id' => 3, 'parent_id' => 26, 'name' => 'Footer Settings', 'route' => 'footerSetting.footer.index', 'type' => 2 ],
        ['id'  => 54, 'module_id' => 3, 'parent_id' => 53, 'name' => 'Copyright Content Update', 'route' => 'copyright_content_update', 'type' => 3 ],
        ['id'  => 55, 'module_id' => 3, 'parent_id' => 53, 'name' => 'About Content Update', 'route' => 'about_content_update', 'type' => 3 ],
        ['id'  => 56, 'module_id' => 3, 'parent_id' => 53, 'name' => 'Company Content Update', 'route' => 'company_content_update', 'type' => 3 ],
        ['id'  => 57, 'module_id' => 3, 'parent_id' => 53, 'name' => 'Account Content Update', 'route' => 'account_content_update', 'type' => 3 ],
        ['id'  => 58, 'module_id' => 3, 'parent_id' => 53, 'name' => 'Service Content Update', 'route' => 'service_content_update', 'type' => 3 ],
        ['id'  => 59, 'module_id' => 3, 'parent_id' => 53, 'name' => 'Create Page', 'route' => 'footerSetting.footer.widget-store', 'type' => 3 ],
        ['id'  => 60, 'module_id' => 3, 'parent_id' => 53, 'name' => 'Update Page', 'route' => 'footerSetting.footer.widget-update', 'type' => 3 ],
        ['id'  => 61, 'module_id' => 3, 'parent_id' => 53, 'name' => 'Destroy Page', 'route' => 'footer.widget-delete', 'type' => 3 ],
        ['id'  => 62, 'module_id' => 3, 'parent_id' => 26, 'name' => 'Subscription', 'route' => 'frontendcms.subscribe-content.index', 'type' => 2 ],
        ['id'  => 63, 'module_id' => 3, 'parent_id' => 62, 'name' => 'Subscription Content Update', 'route' => 'frontendcms.subscribe-content.update', 'type' => 3 ],
        ['id'  => 630, 'module_id' => 3, 'parent_id' => 26, 'name' => 'POP-UP', 'route' => 'frontendcms.popup-content.index', 'type' => 2 ],
        ['id'  => 64, 'module_id' => 3, 'parent_id' => 26, 'name' => 'About-us Content', 'route' => 'frontendcms.about-us.index', 'type' => 2 ],
        ['id'  => 65, 'module_id' => 3, 'parent_id' => 64, 'name' => 'About-us Content Update', 'route' => 'frontendcms.about-us.update', 'type' => 3 ],
        ['id'  => 66, 'module_id' => 3, 'parent_id' => 26, 'name' => 'Title', 'route' => 'frontendcms.title_index', 'type' => 2 ],
        ['id'  => 67, 'module_id' => 3, 'parent_id' => 66, 'name' => 'Title Update', 'route' => 'frontendcms.title_settings.update', 'type' => 3 ],

        //Appearance
        ['id'  => 68, 'module_id' => 4, 'parent_id' => null, 'name' => 'Appearance', 'route' => 'appearance', 'type' => 1 ],
        ['id'  => 69, 'module_id' => 4, 'parent_id' => 68, 'name' => 'Theme', 'route' => 'appearance.themes.index', 'type' => 2 ],
        ['id'  => 70, 'module_id' => 4, 'parent_id' => 69, 'name' => 'Add New', 'route' => 'appearance.themes.store', 'type' => 3 ],
        ['id'  => 71, 'module_id' => 4, 'parent_id' => 69, 'name' => 'Make Active', 'route' => 'appearance.themes.active', 'type' => 3 ],
        ['id'  => 72, 'module_id' => 4, 'parent_id' => 69, 'name' => 'Show', 'route' => 'appearance.themes.show', 'type' => 3 ],
        ['id'  => 73, 'module_id' => 4, 'parent_id' => 68, 'name' => 'Menus', 'route' => 'menu.manage', 'type' => 2 ],
        ['id'  => 74, 'module_id' => 4, 'parent_id' => 73, 'name' => 'Create', 'route' => 'menu.store', 'type' => 3 ],
        ['id'  => 75, 'module_id' => 4, 'parent_id' => 73, 'name' => 'Update', 'route' => 'menu.edit', 'type' => 3 ],
        ['id'  => 76, 'module_id' => 4, 'parent_id' => 73, 'name' => 'Delete', 'route' => 'menu.delete', 'type' => 3 ],
        ['id'  => 77, 'module_id' => 4, 'parent_id' => 73, 'name' => 'Status Change', 'route' => 'menu.status', 'type' => 3 ],
        ['id'  => 78, 'module_id' => 4, 'parent_id' => 73, 'name' => 'Setup', 'route' => 'menu.setup', 'type' => 3 ],
        ['id'  => 79, 'module_id' => 4, 'parent_id' => 68, 'name' => 'Header', 'route' => 'appearance.header.index', 'type' => 2 ],
        ['id'  => 80, 'module_id' => 4, 'parent_id' => 79, 'name' => 'Status Change', 'route' => 'appearance.header.update_status', 'type' => 3 ],
        ['id'  => 81, 'module_id' => 4, 'parent_id' => 79, 'name' => 'Setup', 'route' => 'appearance.header.setup', 'type' => 3 ],

        ['id'  => 553, 'module_id' => 4, 'parent_id' => 68, 'name' => 'Dashboard Color', 'route' => 'appearance.color.index', 'type' => 2 ],
        ['id'  => 554, 'module_id' => 4, 'parent_id' => 553, 'name' => 'Create', 'route' => 'appearance.color.create', 'type' => 3 ],
        ['id'  => 555, 'module_id' => 4, 'parent_id' => 553, 'name' => 'Store', 'route' => 'appearance.color.store', 'type' => 3 ],
        ['id'  => 556, 'module_id' => 4, 'parent_id' => 553, 'name' => 'Delete', 'route' => 'appearance.color.delete', 'type' => 3 ],
        ['id'  => 557, 'module_id' => 4, 'parent_id' => 553, 'name' => 'Activate', 'route' => 'appearance.color.activate', 'type' => 3 ],
        ['id'  => 558, 'module_id' => 4, 'parent_id' => 553, 'name' => 'Clone', 'route' => 'appearance.color.clone', 'type' => 3 ],
        ['id'  => 559, 'module_id' => 4, 'parent_id' => 553, 'name' => 'Edit', 'route' => 'appearance.color.edit', 'type' => 3 ],
        ['id'  => 560, 'module_id' => 4, 'parent_id' => 553, 'name' => 'Update', 'route' => 'appearance.color.update', 'type' => 3 ],

        ['id'  => 561, 'module_id' => 4, 'parent_id' => 68, 'name' => 'Color Scheme', 'route' => 'themeColor.index', 'type' => 2 ],
        ['id'  => 562, 'module_id' => 4, 'parent_id' => 561, 'name' => 'Update', 'route' => 'themeColor.update', 'type' => 3 ],
        ['id'  => 563, 'module_id' => 4, 'parent_id' => 561, 'name' => 'Activate', 'route' => 'themeColor.activate', 'type' => 3 ],

        // Customer
        ['id'  => 82, 'module_id' => 5, 'parent_id' => null, 'name' => 'Customer', 'route' => 'cusotmer.list_active', 'type' => 1 ],
        ['id'  => 83, 'module_id' => 5, 'parent_id' => 82, 'name' => 'Active Status Change', 'route' => 'customer.update_active_status', 'type' => 2 ],
        ['id'  => 84, 'module_id' => 5, 'parent_id' => 82, 'name' => 'Details', 'route' => 'customer.show_details', 'type' => 2 ],
        ['id'  => 85, 'module_id' => 5, 'parent_id' => 82, 'name' => 'In-active List', 'route' => 'customer.list_inactive', 'type' => 2 ],

        // Blog
        ['id'  => 86, 'module_id' => 6, 'parent_id' => null, 'name' => 'Blog Module', 'route' => 'blog_module', 'type' => 1 ],
        ['id'  => 87, 'module_id' => 6, 'parent_id' => 86, 'name' => 'Blog', 'route' => 'blog.post.get-data', 'type' => 2 ],
        ['id'  => 88, 'module_id' => 6, 'parent_id' => 87, 'name' => 'Create', 'route' => 'blog.posts.create', 'type' => 3 ],
        ['id'  => 89, 'module_id' => 6, 'parent_id' => 87, 'name' => 'Update', 'route' => 'blog.posts.edit', 'type' => 3 ],
        ['id'  => 90, 'module_id' => 6, 'parent_id' => 87, 'name' => 'Destroy', 'route' => 'blog.posts.delete', 'type' => 3 ],
        ['id'  => 91, 'module_id' => 6, 'parent_id' => 87, 'name' => 'Status Change', 'route' => 'blog.post.status.update', 'type' => 3 ],
        ['id'  => 92, 'module_id' => 6, 'parent_id' => 87, 'name' => 'Approval Change', 'route' => 'blog.post.approval', 'type' => 3 ],
        ['id'  => 93, 'module_id' => 6, 'parent_id' => 86, 'name' => 'Blog Category', 'route' => 'blog.categories.index', 'type' => 2 ],
        ['id'  => 94, 'module_id' => 6, 'parent_id' => 93, 'name' => 'Create', 'route' => 'blog.categories.store', 'type' => 3 ],
        ['id'  => 95, 'module_id' => 6, 'parent_id' => 93, 'name' => 'Update', 'route' => 'blog.categories.edit', 'type' => 3 ],
        ['id'  => 96, 'module_id' => 6, 'parent_id' => 93, 'name' => 'Delete', 'route' => 'blog.categories.destroy', 'type' => 3 ],


        // Manage Wallet
        ['id'  => 112, 'module_id' => 8, 'parent_id' => null, 'name' => 'Wallet Manage', 'route' => 'wallet_manage', 'type' => 1 ],
        ['id'  => 113, 'module_id' => 8, 'parent_id' => 112, 'name' => 'Recharge Approval', 'route' => 'wallet_recharge.get-data', 'type' => 2 ],
        ['id'  => 114, 'module_id' => 8, 'parent_id' => 113, 'name' => 'Appeoval Status', 'route' => 'wallet_charge.update_status', 'type' => 3 ],
        ['id'  => 564, 'module_id' => 8, 'parent_id' => 112, 'name' => 'Bank Recharge', 'route' => 'bank_recharge.index', 'type' => 2 ],
        ['id'  => 115, 'module_id' => 8, 'parent_id' => 112, 'name' => 'Offline Recharge', 'route' => 'wallet_recharge.offline_index_get_data', 'type' => 2 ],
        ['id'  => 116, 'module_id' => 8, 'parent_id' => 115, 'name' => 'Recharge', 'route' => 'wallet_recharge.offline', 'type' => 3 ],
        
        ['id'  => 565, 'module_id' => 8, 'parent_id' => 112, 'name' => 'Configuration', 'route' => 'wallet.wallet_configuration', 'type' => 2 ],
        ['id'  => 566, 'module_id' => 8, 'parent_id' => 565, 'name' => 'Update', 'route' => 'wallet.wallet_configuration_update', 'type' => 3 ],

        // Contact Request
        ['id'  => 120, 'module_id' => 9, 'parent_id' => null, 'name' => 'Contact Request', 'route' => 'contact_request', 'type' => 1 ],
        ['id'  => 513, 'module_id' => 9, 'parent_id' => 120, 'name' => 'Contact Request List', 'route' => 'contactrequest.contact.index', 'type' => 2 ],
        ['id'  => 121, 'module_id' => 9, 'parent_id' => 120, 'name' => 'Delete', 'route' => 'contactrequest.contact.delete', 'type' => 2 ],

        // Marketing
        ['id'  => 122, 'module_id' => 10, 'parent_id' => null, 'name' => 'Marketing', 'route' => 'marketing_module', 'type' => 1 ],
        ['id'  => 123, 'module_id' => 10, 'parent_id' => 122, 'name' => 'Flash Deal', 'route' => 'marketing.flash-deals', 'type' => 2 ],
        ['id'  => 124, 'module_id' => 10, 'parent_id' => 123, 'name' => 'Create', 'route' => 'marketing.flash-deals.create', 'type' => 3 ],
        ['id'  => 125, 'module_id' => 10, 'parent_id' => 123, 'name' => 'Update', 'route' => 'marketing.flash-deals.edit', 'type' => 3 ],
        ['id'  => 126, 'module_id' => 10, 'parent_id' => 123, 'name' => 'Delete', 'route' => 'marketing.flash-deals.delete', 'type' => 3 ],
        ['id'  => 127, 'module_id' => 10, 'parent_id' => 123, 'name' => 'Status Change', 'route' => 'marketing.flash-deals.status', 'type' => 3 ],
        ['id'  => 128, 'module_id' => 10, 'parent_id' => 123, 'name' => 'Featured Enable', 'route' => 'marketing.flash-deals.featured', 'type' => 3 ],
        ['id'  => 129, 'module_id' => 10, 'parent_id' => 122, 'name' => 'Coupon', 'route' => 'marketing.coupon.get-data', 'type' => 2 ],
        ['id'  => 130, 'module_id' => 10, 'parent_id' => 129, 'name' => 'Create', 'route' => 'marketing.coupon.store', 'type' => 3 ],
        ['id'  => 131, 'module_id' => 10, 'parent_id' => 129, 'name' => 'Update', 'route' => 'marketing.coupon.update', 'type' => 3 ],
        ['id'  => 132, 'module_id' => 10, 'parent_id' => 129, 'name' => 'Delete', 'route' => 'marketing.coupon.delete', 'type' => 3 ],
        ['id'  => 133, 'module_id' => 10, 'parent_id' => 122, 'name' => 'New User Zone', 'route' => 'marketing.new-user-zone', 'type' => 2 ],
        ['id'  => 134, 'module_id' => 10, 'parent_id' => 133, 'name' => 'Create', 'route' => 'marketing.new-user-zone.create', 'type' => 3 ],
        ['id'  => 135, 'module_id' => 10, 'parent_id' => 133, 'name' => 'Update', 'route' => 'marketing.new-user-zone.edit', 'type' => 3 ],
        ['id'  => 136, 'module_id' => 10, 'parent_id' => 133, 'name' => 'Delete', 'route' => 'marketing.new-user-zone.delete', 'type' => 3 ],
        ['id'  => 137, 'module_id' => 10, 'parent_id' => 133, 'name' => 'Status Change', 'route' => 'marketing.new-user-zone.status', 'type' => 3 ],
        ['id'  => 138, 'module_id' => 10, 'parent_id' => 133, 'name' => 'Featured Enable', 'route' => 'marketing.new-user-zone.featured', 'type' => 3 ],
        ['id'  => 139, 'module_id' => 10, 'parent_id' => 122, 'name' => 'News-Letter', 'route' => 'marketing.news-letter.get-data', 'type' => 2 ],
        ['id'  => 140, 'module_id' => 10, 'parent_id' => 139, 'name' => 'Create', 'route' => 'marketing.news-letter.create', 'type' => 3 ],
        ['id'  => 141, 'module_id' => 10, 'parent_id' => 139, 'name' => 'Update', 'route' => 'marketing.news-letter.edit', 'type' => 3 ],
        ['id'  => 142, 'module_id' => 10, 'parent_id' => 139, 'name' => 'Delete', 'route' => 'marketing.news-letter.delete', 'type' => 3 ],
        ['id'  => 143, 'module_id' => 10, 'parent_id' => 122, 'name' => 'Bulk SMS', 'route' => 'marketing.bulk-sms.get-data', 'type' => 2 ],
        ['id'  => 144, 'module_id' => 10, 'parent_id' => 143, 'name' => 'Create', 'route' => 'marketing.bulk-sms.store', 'type' => 3 ],
        ['id'  => 145, 'module_id' => 10, 'parent_id' => 143, 'name' => 'Update', 'route' => 'marketing.bulk-sms.edit', 'type' => 3 ],
        ['id'  => 146, 'module_id' => 10, 'parent_id' => 143, 'name' => 'Delete', 'route' => 'marketing.bulk-sms.delete', 'type' => 3 ],
        ['id'  => 147, 'module_id' => 10, 'parent_id' => 122, 'name' => 'Subscriber', 'route' => 'marketing.subscriber.get-data', 'type' => 2 ],
        ['id'  => 148, 'module_id' => 10, 'parent_id' => 147, 'name' => 'Delete', 'route' => 'marketing.subscriber.delete', 'type' => 3 ],
        ['id'  => 149, 'module_id' => 10, 'parent_id' => 147, 'name' => 'Status Change', 'route' => 'marketing.subscriber.status', 'type' => 3 ],
        ['id'  => 150, 'module_id' => 10, 'parent_id' => 122, 'name' => 'Referal Code', 'route' => 'marketing.referral-code.get-data', 'type' => 2 ],
        ['id'  => 151, 'module_id' => 10, 'parent_id' => 150, 'name' => 'Update', 'route' => 'marketing.referral-code.update-setup', 'type' => 3 ],
        ['id'  => 152, 'module_id' => 10, 'parent_id' => 150, 'name' => 'Status Change', 'route' => 'marketing.referral-code.status', 'type' => 3 ],


        // Gift Card
        ['id'  => 168, 'module_id' => 13, 'parent_id' => null, 'name' => 'Gift Card', 'route' => 'gift_card_manage', 'type' => 1 ],
        ['id'  => 169, 'module_id' => 13, 'parent_id' => 168, 'name' => 'Gift Card', 'route' => 'admin.giftcard.index', 'type' => 2 ],
        ['id'  => 170, 'module_id' => 13, 'parent_id' => 169, 'name' => 'List', 'route' => 'admin.giftcard.get-data', 'type' => 3 ],
        ['id'  => 171, 'module_id' => 13, 'parent_id' => 169, 'name' => 'Create', 'route' => 'admin.giftcard.create', 'type' => 3 ],
        ['id'  => 172, 'module_id' => 13, 'parent_id' => 169, 'name' => 'Update', 'route' => 'admin.giftcard.edit', 'type' => 3 ],
        ['id'  => 173, 'module_id' => 13, 'parent_id' => 169, 'name' => 'Delete', 'route' => 'admin.giftcard.delete', 'type' => 3 ],
        ['id'  => 174, 'module_id' => 13, 'parent_id' => 169, 'name' => 'Status Change', 'route' => 'admin.giftcard.status', 'type' => 3 ],

        // Product Module
        ['id'  => 175, 'module_id' => 14, 'parent_id' => null, 'name' => 'Product Module', 'route' => 'product_module', 'type' => 1 ],
        ['id'  => 176, 'module_id' => 14, 'parent_id' => 175, 'name' => 'Category', 'route' => 'product.category.index', 'type' => 2 ],
        ['id'  => 177, 'module_id' => 14, 'parent_id' => 176, 'name' => 'List', 'route' => 'product.category.index', 'type' => 3 ],
        ['id'  => 178, 'module_id' => 14, 'parent_id' => 176, 'name' => 'Create', 'route' => 'product.category.store', 'type' => 3 ],
        ['id'  => 179, 'module_id' => 14, 'parent_id' => 176, 'name' => 'Update', 'route' => 'product.category.edit', 'type' => 3 ],
        ['id'  => 180, 'module_id' => 14, 'parent_id' => 176, 'name' => 'Delete', 'route' => 'product.category.delete', 'type' => 3 ],
        ['id'  => 181, 'module_id' => 14, 'parent_id' => 175, 'name' => 'Brand', 'route' => 'product.brands.index', 'type' => 2 ],
        ['id'  => 182, 'module_id' => 14, 'parent_id' => 181, 'name' => 'List', 'route' => 'product.load_more_brands', 'type' => 3 ],
        ['id'  => 183, 'module_id' => 14, 'parent_id' => 181, 'name' => 'Create', 'route' => 'product.brand.create', 'type' => 3 ],
        ['id'  => 184, 'module_id' => 14, 'parent_id' => 181, 'name' => 'Update', 'route' => 'product.brand.edit', 'type' => 3 ],
        ['id'  => 185, 'module_id' => 14, 'parent_id' => 181, 'name' => 'Delete', 'route' => 'product.brand.destroy', 'type' => 3 ],
        ['id'  => 186, 'module_id' => 14, 'parent_id' => 181, 'name' => 'Status', 'route' => 'product.brand.update_active_status', 'type' => 3 ],
        ['id'  => 187, 'module_id' => 14, 'parent_id' => 181, 'name' => 'Featured', 'route' => 'product.brand.update_active_feature', 'type' => 3 ],
        ['id'  => 188, 'module_id' => 14, 'parent_id' => 175, 'name' => 'Attribute', 'route' => 'product.attribute.index', 'type' => 2 ],
        ['id'  => 189, 'module_id' => 14, 'parent_id' => 188, 'name' => 'List', 'route' => 'product.attribute.get_list', 'type' => 3 ],
        ['id'  => 190, 'module_id' => 14, 'parent_id' => 188, 'name' => 'Create', 'route' => 'product.attribute.store', 'type' => 3 ],
        ['id'  => 191, 'module_id' => 14, 'parent_id' => 188, 'name' => 'Update', 'route' => 'product.attribute.edit', 'type' => 3 ],
        ['id'  => 192, 'module_id' => 14, 'parent_id' => 188, 'name' => 'Delete', 'route' => 'product.attribute.destroy', 'type' => 3 ],
        ['id'  => 193, 'module_id' => 14, 'parent_id' => 175, 'name' => 'Units', 'route' => 'product.units.index', 'type' => 2 ],
        ['id'  => 194, 'module_id' => 14, 'parent_id' => 193, 'name' => 'List', 'route' => 'product.units.get_list', 'type' => 3 ],
        ['id'  => 195, 'module_id' => 14, 'parent_id' => 193, 'name' => 'Create', 'route' => 'product.units.store', 'type' => 3 ],
        ['id'  => 196, 'module_id' => 14, 'parent_id' => 193, 'name' => 'Update', 'route' => 'product.units.update', 'type' => 3 ],
        ['id'  => 197, 'module_id' => 14, 'parent_id' => 193, 'name' => 'Delete', 'route' => 'product.units.destroy', 'type' => 3 ],
        ['id'  => 198, 'module_id' => 14, 'parent_id' => 175, 'name' => 'Products', 'route' => 'product.index', 'type' => 2 ],
        ['id'  => 199, 'module_id' => 14, 'parent_id' => 198, 'name' => 'List', 'route' => 'product.get-data', 'type' => 3 ],
        ['id'  => 200, 'module_id' => 14, 'parent_id' => 198, 'name' => 'Create', 'route' => 'product.create', 'type' => 3 ],
        ['id'  => 201, 'module_id' => 14, 'parent_id' => 198, 'name' => 'Update', 'route' => 'product.edit', 'type' => 3 ],
        ['id'  => 202, 'module_id' => 14, 'parent_id' => 198, 'name' => 'Clone', 'route' => 'product.clone', 'type' => 3 ],
        ['id'  => 203, 'module_id' => 14, 'parent_id' => 198, 'name' => 'Delete', 'route' => 'product.destroy', 'type' => 3 ],
        ['id'  => 205, 'module_id' => 14, 'parent_id' => 198, 'name' => 'Product By SKU', 'route' => 'product.get-data-sku', 'type' => 3 ],
        ['id'  => 206, 'module_id' => 14, 'parent_id' => 198, 'name' => 'Product Status', 'route' => 'product.update_active_status', 'type' => 3 ],
        ['id'  => 207, 'module_id' => 14, 'parent_id' => 198, 'name' => 'Product Status By SKU', 'route' => 'product.sku.status', 'type' => 3 ],
        ['id'  => 209, 'module_id' => 14, 'parent_id' => 198, 'name' => 'ProductSKu Update', 'route' => 'product.sku.update', 'type' => 3 ],
        ['id'  => 210, 'module_id' => 14, 'parent_id' => 198, 'name' => 'ProductSKu Delete', 'route' => 'product.sku.delete', 'type' => 3 ],
        ['id'  => 211, 'module_id' => 14, 'parent_id' => 175, 'name' => 'Recent Viewed', 'route' => 'product.recent_view_product_config', 'type' => 2 ],
        ['id'  => 212, 'module_id' => 14, 'parent_id' => 211, 'name' => 'Update', 'route' => 'product.recent_view_product_config_update', 'type' => 3 ],
        

        // Product Review
        ['id'  => 281, 'module_id' => 15, 'parent_id' => null, 'name' => 'Review', 'route' => 'review_module', 'type' => 1 ],
        ['id'  => 282, 'module_id' => 15, 'parent_id' => 281, 'name' => 'Product Review', 'route' => 'review.product.index', 'type' => 2 ],
        ['id'  => 283, 'module_id' => 15, 'parent_id' => 282, 'name' => 'Approve All', 'route' => 'review.product.approve-all', 'type' => 3 ],
        ['id'  => 284, 'module_id' => 15, 'parent_id' => 282, 'name' => 'Review Delete', 'route' => 'review.product.delete', 'type' => 3 ],
        ['id'  => 285, 'module_id' => 15, 'parent_id' => 282, 'name' => 'Approve Single', 'route' => 'review.product.approve', 'type' => 3 ],
        ['id'  => 286, 'module_id' => 15, 'parent_id' => 282, 'name' => 'All List', 'route' => 'review.product.get-all-data', 'type' => 3 ],
        ['id'  => 287, 'module_id' => 15, 'parent_id' => 282, 'name' => 'Pending List', 'route' => 'review.product.get-pending-data', 'type' => 3 ],
        ['id'  => 288, 'module_id' => 15, 'parent_id' => 282, 'name' => 'Declined List', 'route' => 'review.product.get-declined-data', 'type' => 3 ],
        ['id'  => 482, 'module_id' => 15, 'parent_id' => 281, 'name' => 'Company Reviews', 'route' => 'review.seller.index', 'type' => 2 ],
        ['id'  => 483, 'module_id' => 15, 'parent_id' => 482, 'name' => 'Approve All', 'route' => 'review.seller.approve-all', 'type' => 3 ],
        ['id'  => 484, 'module_id' => 15, 'parent_id' => 482, 'name' => 'Review Delete', 'route' => 'review.seller.delete', 'type' => 3 ],
        ['id'  => 485, 'module_id' => 15, 'parent_id' => 482, 'name' => 'Approve Single', 'route' => 'review.seller.approve', 'type' => 3 ],
        ['id'  => 486, 'module_id' => 15, 'parent_id' => 482, 'name' => 'All List', 'route' => 'review.seller.get-all-data', 'type' => 3 ],
        ['id'  => 487, 'module_id' => 15, 'parent_id' => 482, 'name' => 'Pending List', 'route' => 'review.seller.get-pending-data', 'type' => 3 ],
        ['id'  => 488, 'module_id' => 15, 'parent_id' => 482, 'name' => 'declined List', 'route' => 'review.seller.get-declined-data', 'type' => 3 ],
        ['id'  => 489, 'module_id' => 15, 'parent_id' => 281, 'name' => 'My Product Review', 'route' => 'seller.product-reviews.index', 'type' => 2 ],
        ['id'  => 490, 'module_id' => 15, 'parent_id' => 489, 'name' => 'Reply', 'route' => 'seller.product-reviews.reply', 'type' => 3 ],
        ['id'  => 491, 'module_id' => 15, 'parent_id' => 489, 'name' => 'List', 'route' => 'seller.product-reviews.get-data', 'type' => 3 ],

        ['id'  => 567, 'module_id' => 15, 'parent_id' => 281, 'name' => 'Configuration', 'route' => 'review.review_configuration', 'type' => 2 ],
        ['id'  => 568, 'module_id' => 15, 'parent_id' => 567, 'name' => 'Update', 'route' => 'review.review_configuration.update', 'type' => 3 ],

        // Order Manage
        ['id'  => 290, 'module_id' => 16, 'parent_id' => null, 'name' => 'Admin Order Manage', 'route' => 'order_manage', 'type' => 1 ],
        ['id'  => 291, 'module_id' => 16, 'parent_id' => 290, 'name' => 'Order Manage', 'route' => 'order_manage.total_sales_get_data', 'type' => 2 ],
        ['id'  => 292, 'module_id' => 16, 'parent_id' => 291, 'name' => 'Pending', 'route' => 'pending_orders', 'type' => 3 ],
        ['id'  => 293, 'module_id' => 16, 'parent_id' => 291, 'name' => 'Confirmed', 'route' => 'confirmed_orders', 'type' => 3 ],
        ['id'  => 294, 'module_id' => 16, 'parent_id' => 291, 'name' => 'Completed', 'route' => 'completed_orders', 'type' => 3 ],
        ['id'  => 295, 'module_id' => 16, 'parent_id' => 291, 'name' => 'Pending Payment', 'route' => 'pending_payment_orders', 'type' => 3 ],
        ['id'  => 296, 'module_id' => 16, 'parent_id' => 291, 'name' => 'Cancelled', 'route' => 'cancelled_orders', 'type' => 3 ],
        ['id'  => 298, 'module_id' => 16, 'parent_id' => 291, 'name' => 'Order Status', 'route' => 'order_manage.order_update_info', 'type' => 3 ],
        ['id'  => 299, 'module_id' => 16, 'parent_id' => 291, 'name' => 'Order Details', 'route' => 'order_manage.show_details', 'type' => 3 ],
        ['id'  => 300, 'module_id' => 16, 'parent_id' => 290, 'name' => 'Delivery Process', 'route' => 'order_manage.process_index', 'type' => 2 ],
        ['id'  => 301, 'module_id' => 16, 'parent_id' => 300, 'name' => 'List', 'route' => 'order_manage.process_list', 'type' => 3 ],
        ['id'  => 302, 'module_id' => 16, 'parent_id' => 300, 'name' => 'Create', 'route' => 'order_manage.process_store', 'type' => 3 ],
        ['id'  => 303, 'module_id' => 16, 'parent_id' => 300, 'name' => 'Edit', 'route' => 'order_manage.process_update', 'type' => 3 ],
        ['id'  => 304, 'module_id' => 16, 'parent_id' => 300, 'name' => 'Delete', 'route' => 'order_manage.process_destroy', 'type' => 3 ],
        ['id'  => 464, 'module_id' => 16, 'parent_id' => 290, 'name' => 'Cancel Reason', 'route' => 'order_manage.cancel_reason_index', 'type' => 2 ],
        ['id'  => 465, 'module_id' => 16, 'parent_id' => 464, 'name' => 'List', 'route' => 'order_manage.cancel_reason_list', 'type' => 3 ],
        ['id'  => 466, 'module_id' => 16, 'parent_id' => 465, 'name' => 'Create', 'route' => 'order_manage.cancel_reason_store', 'type' => 3 ],
        ['id'  => 467, 'module_id' => 16, 'parent_id' => 465, 'name' => 'Edit', 'route' => 'order_manage.cancel_reason_update', 'type' => 3 ],
        ['id'  => 468, 'module_id' => 16, 'parent_id' => 465, 'name' => 'Delete', 'route' => 'order_manage.cancel_reason_destroy', 'type' => 3 ],

        // Refund Manage
        ['id'  => 312, 'module_id' => 17, 'parent_id' => null, 'name' => 'Refund Manage', 'route' => 'refund_manage', 'type' => 1 ],
        ['id'  => 313, 'module_id' => 17, 'parent_id' => 312, 'name' => 'Pending List', 'route' => 'refund.total_refund_list', 'type' => 2 ],
        ['id'  => 314, 'module_id' => 17, 'parent_id' => 312, 'name' => 'Details', 'route' => 'refund.refund_show_details', 'type' => 2 ],
        ['id'  => 315, 'module_id' => 17, 'parent_id' => 312, 'name' => 'Update Status', 'route' => 'refund.update_refund_request_by_admin', 'type' => 2 ],
        ['id'  => 316, 'module_id' => 17, 'parent_id' => 312, 'name' => 'Confirmed List', 'route' => 'refund.confirmed_refund_requests', 'type' => 2 ],
        ['id'  => 318, 'module_id' => 17, 'parent_id' => 312, 'name' => 'Update Refund Process', 'route' => 'refund.update_refund_detail_state_by_seller', 'type' => 2 ],
        ['id'  => 319, 'module_id' => 17, 'parent_id' => 312, 'name' => 'Refund Reasons', 'route' => 'refund.reasons_list', 'type' => 2 ],
        ['id'  => 320, 'module_id' => 17, 'parent_id' => 319, 'name' => 'Create', 'route' => 'refund.reasons_store', 'type' => 3 ],
        ['id'  => 321, 'module_id' => 17, 'parent_id' => 319, 'name' => 'Update', 'route' => 'refund.reasons_update', 'type' => 3 ],
        ['id'  => 322, 'module_id' => 17, 'parent_id' => 319, 'name' => 'Delete', 'route' => 'refund.destroy', 'type' => 3 ],
        ['id'  => 323, 'module_id' => 17, 'parent_id' => 312, 'name' => 'Refund Process', 'route' => 'refund.process_index', 'type' => 2 ],
        ['id'  => 324, 'module_id' => 17, 'parent_id' => 323, 'name' => 'Create', 'route' => 'refund.process_store', 'type' => 3 ],
        ['id'  => 325, 'module_id' => 17, 'parent_id' => 323, 'name' => 'Update', 'route' => 'refund.process_update', 'type' => 3 ],
        ['id'  => 326, 'module_id' => 17, 'parent_id' => 323, 'name' => 'Delete', 'route' => 'refund.process_destroy', 'type' => 3 ],
        ['id'  => 327, 'module_id' => 17, 'parent_id' => 312, 'name' => 'Configuration', 'route' => 'refund.config', 'type' => 2 ],
        ['id'  => 328, 'module_id' => 17, 'parent_id' => 327, 'name' => 'Update', 'route' => 'refund.refund_config_store', 'type' => 3 ],

        // System Settings
        ['id'  => 329, 'module_id' => 18, 'parent_id' => null, 'name' => 'System Settings', 'route' => 'system_settings', 'type' => 1 ],
        ['id'  => 330, 'module_id' => 18, 'parent_id' => 329, 'name' => 'General Settings', 'route' => 'generalsetting.index', 'type' => 2 ],
        ['id'  => 331, 'module_id' => 18, 'parent_id' => 330, 'name' => 'Activations', 'route' => 'generalsetting.activation_index', 'type' => 3 ],
        ['id'  => 332, 'module_id' => 18, 'parent_id' => 330, 'name' => 'General', 'route' => 'general_info', 'type' => 3 ],
        ['id'  => 333, 'module_id' => 18, 'parent_id' => 330, 'name' => 'Company Info', 'route' => 'company_info', 'type' => 3 ],
        ['id'  => 334, 'module_id' => 18, 'parent_id' => 330, 'name' => 'SMTP', 'route' => 'smtp_info', 'type' => 3 ],
        ['id'  => 335, 'module_id' => 18, 'parent_id' => 330, 'name' => 'SMS', 'route' => 'sms_info', 'type' => 3 ],
        ['id'  => 336, 'module_id' => 18, 'parent_id' => 330, 'name' => 'Activation Update', 'route' => 'update_activation_status', 'type' => 3 ],
        ['id'  => 337, 'module_id' => 18, 'parent_id' => 330, 'name' => 'Company Info Save', 'route' => 'company_information_update', 'type' => 3 ],
        ['id'  => 338, 'module_id' => 18, 'parent_id' => 330, 'name' => 'SMTP Update', 'route' => 'smtp_gateway_credentials_update', 'type' => 3 ],
        ['id'  => 339, 'module_id' => 18, 'parent_id' => 330, 'name' => 'SMS Update', 'route' => 'sms_gateway_credentials_update', 'type' => 3 ],
        ['id'  => 340, 'module_id' => 18, 'parent_id' => 330, 'name' => 'General Update', 'route' => 'company_information_update', 'type' => 3 ],
        ['id'  => 341, 'module_id' => 18, 'parent_id' => 329, 'name' => 'Email Template Settings', 'route' => 'email_templates.index', 'type' => 2 ],
        ['id'  => 342, 'module_id' => 18, 'parent_id' => 341, 'name' => 'Create', 'route' => 'email_templates.create', 'type' => 3 ],
        ['id'  => 343, 'module_id' => 18, 'parent_id' => 341, 'name' => 'Manage', 'route' => 'email_templates.manage', 'type' => 3 ],
        ['id'  => 344, 'module_id' => 18, 'parent_id' => 341, 'name' => 'Status Update', 'route' => 'email_templates.update_status', 'type' => 3 ],
        ['id'  => 626, 'module_id' => 18, 'parent_id' => 329, 'name' => 'SMS Template Settings', 'route' => 'sms_templates.index', 'type' => 2 ],
        ['id'  => 627, 'module_id' => 18, 'parent_id' => 626, 'name' => 'Create', 'route' => 'sms_templates.create', 'type' => 3 ],
        ['id'  => 628, 'module_id' => 18, 'parent_id' => 626, 'name' => 'Manage', 'route' => 'sms_templates.manage', 'type' => 3 ],
        ['id'  => 629, 'module_id' => 18, 'parent_id' => 626, 'name' => 'Status Update', 'route' => 'sms_templates.update_status', 'type' => 3 ],

        ['id'  => 537, 'module_id' => 18, 'parent_id' => 329, 'name' => 'Maintenance mode', 'route' => 'maintenance.index', 'type' => 2 ],
        ['id'  => 538, 'module_id' => 18, 'parent_id' => 537, 'name' => 'Maintenance mode update', 'route' => 'maintenance.update', 'type' => 3 ],

        ['id'  => 539, 'module_id' => 18, 'parent_id' => 329, 'name' => 'Update System', 'route' => 'generalsetting.updatesystem', 'type' => 2 ],
        ['id'  => 540, 'module_id' => 18, 'parent_id' => 539, 'name' => 'Update System Submit', 'route' => 'generalsetting.updatesystem.submit', 'type' => 3 ],

        ['id'  => 541, 'module_id' => 18, 'parent_id' => 329, 'name' => 'Module Manager', 'route' => 'modulemanager.index', 'type' => 2 ],
        ['id'  => 542, 'module_id' => 18, 'parent_id' => 541, 'name' => 'Module Upload', 'route' => 'modulemanager.uploadModule', 'type' => 3 ],
        ['id'  => 543, 'module_id' => 18, 'parent_id' => 541, 'name' => 'Module Delete', 'route' => 'deleteModule', 'type' => 3 ],
        ['id'  => 544, 'module_id' => 18, 'parent_id' => 541, 'name' => 'Module Enable', 'route' => 'moduleAddOnsEnable', 'type' => 3 ],
        ['id'  => 545, 'module_id' => 18, 'parent_id' => 541, 'name' => 'Module Disable', 'route' => 'moduleAddOnsDisable', 'type' => 3 ],

        ['id'  => 550, 'module_id' => 18, 'parent_id' => 329, 'name' => 'Notification Setting', 'route' => 'notificationsetting.index', 'type' => 2 ],
        ['id'  => 551, 'module_id' => 18, 'parent_id' => 550, 'name' => 'Notification Edit', 'route' => 'notificationsetting.edit', 'type' => 3 ],
        ['id'  => 552, 'module_id' => 18, 'parent_id' => 550, 'name' => 'Notification Update', 'route' => 'notificationsetting.update', 'type' => 3 ],
        


        // Payment Gateways
        ['id'  => 345, 'module_id' => 19, 'parent_id' => null, 'name' => 'Payment Gateways', 'route' => 'payment_gateway.index', 'type' => 1 ],
        ['id'  => 346, 'module_id' => 19, 'parent_id' => 345, 'name' => 'Enabling', 'route' => 'update_payment_activation_status', 'type' => 2 ],

        // Setup
        ['id'  => 347, 'module_id' => 20, 'parent_id' => null, 'name' => 'Setup Module', 'route' => 'setup_module', 'type' => 1 ],
        ['id'  => 348, 'module_id' => 20, 'parent_id' => 347, 'name' => 'Language', 'route' => 'languages.index', 'type' => 2 ],
        ['id'  => 349, 'module_id' => 20, 'parent_id' => 348, 'name' => 'Create', 'route' => 'languages.store', 'type' => 3 ],
        ['id'  => 350, 'module_id' => 20, 'parent_id' => 348, 'name' => 'Update', 'route' => 'languages.update', 'type' => 3 ],
        ['id'  => 351, 'module_id' => 20, 'parent_id' => 348, 'name' => 'Delete', 'route' => 'languages.destroy', 'type' => 3 ],
        ['id'  => 352, 'module_id' => 20, 'parent_id' => 348, 'name' => 'Translation', 'route' => 'language.translate_view', 'type' => 3 ],
        ['id'  => 353, 'module_id' => 20, 'parent_id' => 348, 'name' => 'RTL', 'route' => 'languages.update_rtl_status', 'type' => 3 ],
        ['id'  => 354, 'module_id' => 20, 'parent_id' => 348, 'name' => 'Activate', 'route' => 'languages.update_active_status', 'type' => 3 ],
        ['id'  => 355, 'module_id' => 20, 'parent_id' => 347, 'name' => 'currency', 'route' => 'currencies.index', 'type' => 2 ],
        ['id'  => 356, 'module_id' => 20, 'parent_id' => 355, 'name' => 'Create', 'route' => 'currencies.store', 'type' => 3 ],
        ['id'  => 357, 'module_id' => 20, 'parent_id' => 355, 'name' => 'Update', 'route' => 'currencies.update', 'type' => 3 ],
        ['id'  => 358, 'module_id' => 20, 'parent_id' => 355, 'name' => 'Delete', 'route' => 'currencies.destroy', 'type' => 3 ],
        ['id'  => 359, 'module_id' => 20, 'parent_id' => 355, 'name' => 'Activate', 'route' => 'currencies.update_active_status', 'type' => 3 ],
        ['id'  => 360, 'module_id' => 20, 'parent_id' => 347, 'name' => 'Analytics', 'route' => 'setup.analytics.index', 'type' => 2 ],
        ['id'  => 361, 'module_id' => 20, 'parent_id' => 360, 'name' => 'Google Analytics Update', 'route' => 'setup.google-analytics-update', 'type' => 3 ],
        ['id'  => 362, 'module_id' => 20, 'parent_id' => 360, 'name' => 'Facebook pixel Update', 'route' => 'setup.facebook-pixel-update', 'type' => 3 ],
        ['id'  => 363, 'module_id' => 20, 'parent_id' => 347, 'name' => 'Shipping Method', 'route' => 'shipping_methods.index', 'type' => 2 ],
        ['id'  => 364, 'module_id' => 20, 'parent_id' => 363, 'name' => 'Create', 'route' => 'shipping_methods.store', 'type' => 3 ],
        ['id'  => 365, 'module_id' => 20, 'parent_id' => 363, 'name' => 'Update', 'route' => 'shipping_methods.update', 'type' => 3 ],
        ['id'  => 366, 'module_id' => 20, 'parent_id' => 363, 'name' => 'Delete', 'route' => 'shipping_methods.destroy', 'type' => 3 ],
        ['id'  => 367, 'module_id' => 20, 'parent_id' => 363, 'name' => 'Enabling', 'route' => 'shipping_methods.update_status', 'type' => 3 ],
        ['id'  => 368, 'module_id' => 20, 'parent_id' => 363, 'name' => 'Approve', 'route' => 'shipping_methods.update_approve_status', 'type' => 3 ],
        ['id'  => 97, 'module_id' => 20, 'parent_id' => 347, 'name' => 'Tag', 'route' => 'tags.index', 'type' => 2 ],
        ['id'  => 98, 'module_id' => 20, 'parent_id' => 97, 'name' => 'Create', 'route' => 'tags.create', 'type' => 3 ],
        ['id'  => 99, 'module_id' => 20, 'parent_id' => 97, 'name' => 'Update', 'route' => 'tags.edit', 'type' => 3 ],
        ['id'  => 100, 'module_id' => 20, 'parent_id' => 97, 'name' => 'Delete', 'route' => 'tags.destroy', 'type' => 3 ],

        // Location
        ['id'  => 369, 'module_id' => 21, 'parent_id' => null, 'name' => 'Location', 'route' => 'location_manage', 'type' => 1 ],
        ['id'  => 370, 'module_id' => 21, 'parent_id' => 369, 'name' => 'Country', 'route' => 'setup.country.index', 'type' => 2 ],
        ['id'  => 371, 'module_id' => 21, 'parent_id' => 370, 'name' => 'Create', 'route' => 'setup.country.store', 'type' => 3 ],
        ['id'  => 372, 'module_id' => 21, 'parent_id' => 370, 'name' => 'Update', 'route' => 'setup.country.update', 'type' => 3 ],
        ['id'  => 373, 'module_id' => 21, 'parent_id' => 370, 'name' => 'Enable', 'route' => 'setup.country.status', 'type' => 3 ],
        ['id'  => 374, 'module_id' => 21, 'parent_id' => 369, 'name' => 'State', 'route' => 'setup.state.index', 'type' => 2 ],
        ['id'  => 375, 'module_id' => 21, 'parent_id' => 374, 'name' => 'Create', 'route' => 'setup.state.store', 'type' => 3 ],
        ['id'  => 376, 'module_id' => 21, 'parent_id' => 374, 'name' => 'Update', 'route' => 'setup.state.update', 'type' => 3 ],
        ['id'  => 377, 'module_id' => 21, 'parent_id' => 374, 'name' => 'Enable', 'route' => 'setup.state.status', 'type' => 3 ],
        ['id'  => 378, 'module_id' => 21, 'parent_id' => 369, 'name' => 'City', 'route' => 'setup.city.index', 'type' => 2 ],
        ['id'  => 379, 'module_id' => 21, 'parent_id' => 378, 'name' => 'Create', 'route' => 'setup.city.store', 'type' => 3 ],
        ['id'  => 380, 'module_id' => 21, 'parent_id' => 378, 'name' => 'Update', 'route' => 'setup.city.update', 'type' => 3 ],
        ['id'  => 381, 'module_id' => 21, 'parent_id' => 378, 'name' => 'Enable', 'route' => 'setup.city.status', 'type' => 3 ],

        // GST Setup
        ['id'  => 382, 'module_id' => 22, 'parent_id' => null, 'name' => 'GST Setup', 'route' => 'gst_setup', 'type' => 1 ],
        ['id'  => 383, 'module_id' => 22, 'parent_id' => 382, 'name' => 'List', 'route' => 'gst_tax.index', 'type' => 2 ],
        ['id'  => 384, 'module_id' => 22, 'parent_id' => 383, 'name' => 'Create', 'route' => 'gst_tax.store', 'type' => 3 ],
        ['id'  => 385, 'module_id' => 22, 'parent_id' => 383, 'name' => 'Update', 'route' => 'gst_tax.update', 'type' => 3 ],
        ['id'  => 386, 'module_id' => 22, 'parent_id' => 383, 'name' => 'Delete', 'route' => 'gst_tax.destroy', 'type' => 3 ],
        ['id'  => 387, 'module_id' => 22, 'parent_id' => 382, 'name' => 'Configuration', 'route' => 'gst_tax.configuration_index', 'type' => 2 ],
        ['id'  => 388, 'module_id' => 22, 'parent_id' => 387, 'name' => 'Update', 'route' => 'gst_tax.configuration_update', 'type' => 3 ],

        // Account
        ['id'  => 389, 'module_id' => 23, 'parent_id' => null, 'name' => 'Accounting', 'route' => 'account_module', 'type' => 1 ],
        ['id'  => 390, 'module_id' => 23, 'parent_id' => 389, 'name' => 'Chart of Account', 'route' => 'account.chart-of-accounts.index', 'type' => 2 ],
        ['id'  => 391, 'module_id' => 23, 'parent_id' => 390, 'name' => 'Create', 'route' => 'account.chart-of-accounts.store', 'type' => 3 ],
        ['id'  => 392, 'module_id' => 23, 'parent_id' => 390, 'name' => 'Update', 'route' => 'account.chart-of-accounts.edit', 'type' => 3 ],
        ['id'  => 393, 'module_id' => 23, 'parent_id' => 390, 'name' => 'Delete', 'route' => 'account.chart-of-accounts.destroy', 'type' => 3 ],
        ['id'  => 394, 'module_id' => 23, 'parent_id' => 389, 'name' => 'Bank Account', 'route' => 'account.bank-accounts.index', 'type' => 2 ],
        ['id'  => 395, 'module_id' => 23, 'parent_id' => 394, 'name' => 'Create', 'route' => 'account.bank-accounts.store', 'type' => 3 ],
        ['id'  => 396, 'module_id' => 23, 'parent_id' => 394, 'name' => 'Update', 'route' => 'account.bank-accounts.edit', 'type' => 3 ],
        ['id'  => 397, 'module_id' => 23, 'parent_id' => 394, 'name' => 'Delete', 'route' => 'account.bank-accounts.destroy', 'type' => 3 ],
        ['id'  => 398, 'module_id' => 23, 'parent_id' => 394, 'name' => 'Show', 'route' => 'account.bank.statement', 'type' => 3 ],
        ['id'  => 457, 'module_id' => 23, 'parent_id' => 389, 'name' => 'Income', 'route' => 'account.incomes.index', 'type' => 2 ],
        ['id'  => 458, 'module_id' => 23, 'parent_id' => 457, 'name' => 'Create', 'route' => 'account.incomes.store', 'type' => 3 ],
        ['id'  => 459, 'module_id' => 23, 'parent_id' => 457, 'name' => 'Update', 'route' => 'account.incomes.edit', 'type' => 3 ],
        ['id'  => 460, 'module_id' => 23, 'parent_id' => 457, 'name' => 'Delete', 'route' => 'account.incomes.destroy', 'type' => 3 ],
        ['id'  => 461, 'module_id' => 23, 'parent_id' => 389, 'name' => 'Expense', 'route' => 'account.expenses.index', 'type' => 2 ],
        ['id'  => 462, 'module_id' => 23, 'parent_id' => 461, 'name' => 'Create', 'route' => 'account.expenses.store', 'type' => 3 ],
        ['id'  => 400, 'module_id' => 23, 'parent_id' => 461, 'name' => 'Update', 'route' => 'account.expenses.edit', 'type' => 3 ],
        ['id'  => 401, 'module_id' => 23, 'parent_id' => 461, 'name' => 'Delete', 'route' => 'account.expenses.destroy', 'type' => 3 ],
        ['id'  => 402, 'module_id' => 23, 'parent_id' => 389, 'name' => 'Profit', 'route' => 'account.profit', 'type' => 2 ],
        ['id'  => 403, 'module_id' => 23, 'parent_id' => 389, 'name' => 'Transaction', 'route' => 'account.transaction', 'type' => 2 ],
        ['id'  => 404, 'module_id' => 23, 'parent_id' => 403, 'name' => 'List', 'route' => 'account.transaction_dtbl', 'type' => 3 ],
        ['id'  => 405, 'module_id' => 23, 'parent_id' => 389, 'name' => 'Statement', 'route' => 'account.statement', 'type' => 2 ],
        ['id'  => 406, 'module_id' => 23, 'parent_id' => 405, 'name' => 'List', 'route' => 'account.statement_dtbl', 'type' => 3 ],

        // Support Ticket
        ['id'  => 407, 'module_id' => 31, 'parent_id' => null, 'name' => 'Support Ticket', 'route' => 'support_tickets', 'type' => 1 ],
        ['id'  => 408, 'module_id' => 31, 'parent_id' => 407, 'name' => 'Ticket', 'route' => 'ticket.tickets.index', 'type' => 2 ],
        ['id'  => 409, 'module_id' => 31, 'parent_id' => 408, 'name' => 'List', 'route' => 'ticket.tickets.get-data', 'type' => 3 ],
        ['id'  => 410, 'module_id' => 31, 'parent_id' => 408, 'name' => 'Create', 'route' => 'ticket.tickets.create', 'type' => 3 ],
        ['id'  => 411, 'module_id' => 31, 'parent_id' => 408, 'name' => 'Update', 'route' => 'ticket.tickets.edit', 'type' => 3 ],
        ['id'  => 412, 'module_id' => 31, 'parent_id' => 408, 'name' => 'Assign Ticket', 'route' => 'ticket.my_ticket', 'type' => 3 ],
        ['id'  => 413, 'module_id' => 31, 'parent_id' => 408, 'name' => 'Show', 'route' => 'ticket.tickets.show', 'type' => 3 ],
        ['id'  => 414, 'module_id' => 31, 'parent_id' => 408, 'name' => 'Delete', 'route' => 'ticket.tickets.destroy', 'type' => 3 ],
        ['id'  => 415, 'module_id' => 31, 'parent_id' => 407, 'name' => 'Category', 'route' => 'ticket.category.index', 'type' => 2 ],
        ['id'  => 416, 'module_id' => 31, 'parent_id' => 415, 'name' => 'List', 'route' => 'ticket.category.index', 'type' => 3 ],
        ['id'  => 417, 'module_id' => 31, 'parent_id' => 415, 'name' => 'Create', 'route' => 'ticket.category.store', 'type' => 3 ],
        ['id'  => 418, 'module_id' => 31, 'parent_id' => 415, 'name' => 'Update', 'route' => 'ticket.category.update', 'type' => 3 ],
        ['id'  => 419, 'module_id' => 31, 'parent_id' => 415, 'name' => 'Delete', 'route' => 'ticket.category.delete', 'type' => 3 ],
        ['id'  => 420, 'module_id' => 31, 'parent_id' => 415, 'name' => 'Status', 'route' => 'ticket.category.status', 'type' => 3 ],
        ['id'  => 421, 'module_id' => 31, 'parent_id' => 407, 'name' => 'Priority', 'route' => 'ticket.priority.index', 'type' => 2 ],
        ['id'  => 422, 'module_id' => 31, 'parent_id' => 421, 'name' => 'List', 'route' => 'ticket.priority.index', 'type' => 3 ],
        ['id'  => 423, 'module_id' => 31, 'parent_id' => 421, 'name' => 'Create', 'route' => 'ticket.priority.store', 'type' => 3 ],
        ['id'  => 424, 'module_id' => 31, 'parent_id' => 421, 'name' => 'Update', 'route' => 'ticket.priority.update', 'type' => 3 ],
        ['id'  => 425, 'module_id' => 31, 'parent_id' => 421, 'name' => 'Delete', 'route' => 'ticket.priority.delete', 'type' => 3 ],
        ['id'  => 426, 'module_id' => 31, 'parent_id' => 421, 'name' => 'Status', 'route' => 'ticket.priority.status', 'type' => 3 ],
        ['id'  => 427, 'module_id' => 31, 'parent_id' => 407, 'name' => 'Status', 'route' => 'ticket.status.index', 'type' => 2 ],
        ['id'  => 428, 'module_id' => 31, 'parent_id' => 427, 'name' => 'List', 'route' => 'ticket.status.index', 'type' => 3 ],
        ['id'  => 429, 'module_id' => 31, 'parent_id' => 427, 'name' => 'Create', 'route' => 'ticket.status.store', 'type' => 3 ],
        ['id'  => 430, 'module_id' => 31, 'parent_id' => 427, 'name' => 'Update', 'route' => 'ticket.status.update', 'type' => 3 ],
        ['id'  => 431, 'module_id' => 31, 'parent_id' => 427, 'name' => 'Delete', 'route' => 'ticket.status.delete', 'type' => 3 ],
        ['id'  => 432, 'module_id' => 31, 'parent_id' => 427, 'name' => 'Status', 'route' => 'ticket.status.status', 'type' => 3 ],


        // HR
        ['id'  => 433, 'module_id' => 30, 'parent_id' => null, 'name' => 'HR Module', 'route' => 'human_resource', 'type' => 1 ],
        ['id'  => 434, 'module_id' => 30, 'parent_id' => 433, 'name' => 'Staff', 'route' => 'staffs.index', 'type' => 2 ],
        ['id'  => 435, 'module_id' => 30, 'parent_id' => 434, 'name' => 'List', 'route' => 'staffs.index', 'type' => 3 ],
        ['id'  => 436, 'module_id' => 30, 'parent_id' => 434, 'name' => 'Create', 'route' => 'staffs.store', 'type' => 3 ],
        ['id'  => 437, 'module_id' => 30, 'parent_id' => 434, 'name' => 'Update', 'route' => 'staffs.edit', 'type' => 3 ],
        ['id'  => 438, 'module_id' => 30, 'parent_id' => 434, 'name' => 'Details', 'route' => 'staffs.view', 'type' => 3 ],
        ['id'  => 439, 'module_id' => 30, 'parent_id' => 434, 'name' => 'Enable', 'route' => 'staffs.update_active_status', 'type' => 3 ],
        ['id'  => 440, 'module_id' => 30, 'parent_id' => 434, 'name' => 'Delete', 'route' => 'staffs.destroy', 'type' => 3 ],
        ['id'  => 441, 'module_id' => 30, 'parent_id' => 433, 'name' => 'Role', 'route' => 'permission.roles.index', 'type' => 2 ],
        ['id'  => 442, 'module_id' => 30, 'parent_id' => 441, 'name' => 'List', 'route' => 'permission.roles.index', 'type' => 3 ],
        ['id'  => 443, 'module_id' => 30, 'parent_id' => 441, 'name' => 'Create', 'route' => 'permission.roles.store', 'type' => 3 ],
        ['id'  => 444, 'module_id' => 30, 'parent_id' => 441, 'name' => 'Update', 'route' => 'permission.roles.edit', 'type' => 3 ],
        ['id'  => 445, 'module_id' => 30, 'parent_id' => 441, 'name' => 'Delete', 'route' => 'permission.roles.destroy', 'type' => 3 ],
        ['id'  => 446, 'module_id' => 30, 'parent_id' => 441, 'name' => 'Assign permission', 'route' => 'permission.permissions.index', 'type' => 3 ],
        ['id'  => 447, 'module_id' => 30, 'parent_id' => 441, 'name' => 'Permission Store', 'route' => 'permission.permissions.store', 'type' => 3 ],
        ['id'  => 448, 'module_id' => 30, 'parent_id' => 433, 'name' => 'Department', 'route' => 'departments.index', 'type' => 2 ],
        ['id'  => 449, 'module_id' => 30, 'parent_id' => 448, 'name' => 'List', 'route' => 'departments.index', 'type' => 3 ],
        ['id'  => 450, 'module_id' => 30, 'parent_id' => 448, 'name' => 'Create', 'route' => 'departments.store', 'type' => 3 ],
        ['id'  => 451, 'module_id' => 30, 'parent_id' => 448, 'name' => 'Update', 'route' => 'departments.edit', 'type' => 3 ],
        ['id'  => 452, 'module_id' => 30, 'parent_id' => 448, 'name' => 'Delete', 'route' => 'departments.delete', 'type' => 3 ],
        ['id'  => 448, 'module_id' => 30, 'parent_id' => 433, 'name' => 'Attendance Report', 'route' => 'attendance_report.index', 'type' => 2 ],
        ['id'  => 449, 'module_id' => 30, 'parent_id' => 433, 'name' => 'Attendance', 'route' => 'attendances.index', 'type' => 2 ],
        ['id'  => 450, 'module_id' => 30, 'parent_id' => 449, 'name' => 'Store', 'route' => 'attendances.store', 'type' => 3 ],
        ['id'  => 453, 'module_id' => 30, 'parent_id' => 433, 'name' => 'Event', 'route' => 'events.index', 'type' => 2 ],
        ['id'  => 454, 'module_id' => 30, 'parent_id' => 453, 'name' => 'List', 'route' => 'events.index', 'type' => 3 ],
        ['id'  => 455, 'module_id' => 30, 'parent_id' => 453, 'name' => 'Create', 'route' => 'events.store', 'type' => 3 ],
        ['id'  => 456, 'module_id' => 30, 'parent_id' => 453, 'name' => 'Update', 'route' => 'events.update', 'type' => 3 ],
        ['id'  => 457, 'module_id' => 30, 'parent_id' => 453, 'name' => 'Delete', 'route' => 'events.delete', 'type' => 3 ],
        ['id'  => 453, 'module_id' => 30, 'parent_id' => 433, 'name' => 'Holiday Setup', 'route' => 'holidays.index', 'type' => 2 ],
        ['id'  => 454, 'module_id' => 30, 'parent_id' => 453, 'name' => 'List', 'route' => 'holidays.index', 'type' => 3 ],
        ['id'  => 455, 'module_id' => 30, 'parent_id' => 453, 'name' => 'Store', 'route' => 'holidays.store', 'type' => 3 ],
        ['id'  => 456, 'module_id' => 30, 'parent_id' => 453, 'name' => 'Copy', 'route' => 'last.year.data', 'type' => 3 ],

        // Bulk Upload
        ['id'  => 469, 'module_id' => 32, 'parent_id' => null, 'name' => 'Bulk Upload', 'route' => 'bulk_upload', 'type' => 1 ],
        ['id'  => 470, 'module_id' => 32, 'parent_id' => 469, 'name' => 'Gift Card', 'route' => 'admin.giftcard.bulk_gift_card_upload_page', 'type' => 2 ],
        ['id'  => 471, 'module_id' => 32, 'parent_id' => 470, 'name' => 'Upload', 'route' => 'admin.giftcard.bulk_gift_card_store', 'type' => 3 ],
        ['id'  => 472, 'module_id' => 32, 'parent_id' => 469, 'name' => 'Product', 'route' => 'product.bulk_product_upload_page', 'type' => 2 ],
        ['id'  => 473, 'module_id' => 32, 'parent_id' => 472, 'name' => 'Upload', 'route' => 'product.bulk_product_store', 'type' => 3 ],
        ['id'  => 474, 'module_id' => 32, 'parent_id' => 469, 'name' => 'Brand', 'route' => 'product.bulk_brand_upload_page', 'type' => 2 ],
        ['id'  => 475, 'module_id' => 32, 'parent_id' => 474, 'name' => 'Upload', 'route' => 'product.bulk_brand_store', 'type' => 3 ],
        ['id'  => 476, 'module_id' => 32, 'parent_id' => 469, 'name' => 'Category', 'route' => 'product.bulk_category_upload_page', 'type' => 2 ],
        ['id'  => 477, 'module_id' => 32, 'parent_id' => 476, 'name' => 'Upload', 'route' => 'product.bulk_category_upload', 'type' => 3 ],

        // CSV Download
        ['id'  => 478, 'module_id' => 33, 'parent_id' => null, 'name' => 'Export CSV', 'route' => 'export_csv', 'type' => 1 ],
        ['id'  => 479, 'module_id' => 33, 'parent_id' => 478, 'name' => 'Brand', 'route' => 'product.csv_brand_download', 'type' => 2 ],
        ['id'  => 480, 'module_id' => 33, 'parent_id' => 478, 'name' => 'Category', 'route' => 'product.csv_category_download', 'type' => 2 ],
        ['id'  => 481, 'module_id' => 33, 'parent_id' => 478, 'name' => 'Unit type', 'route' => 'product.csv_unit_download', 'type' => 2 ],

        // Sidebar manager
        ['id'  => 496, 'module_id' => 24, 'parent_id' => null, 'name' => 'Sidebar Manager', 'route' => 'sidebar-manager.index', 'type' => 1 ],

        // log activity
        ['id'  => 499, 'module_id' => 26, 'parent_id' => null, 'name' => 'Log Activity', 'route' => 'activity_logs', 'type' => 1 ],
        ['id'  => 500, 'module_id' => 26, 'parent_id' => 499, 'name' => 'All activity Log', 'route' => 'activity_log', 'type' => 2 ],
        ['id'  => 575, 'module_id' => 26, 'parent_id' => 500, 'name' => 'Clear activity Log', 'route' => 'activity_log.destroy_all', 'type' => 3 ],
        ['id'  => 501, 'module_id' => 26, 'parent_id' => 499, 'name' => 'Login Activity', 'route' => 'activity_log.login', 'type' => 2 ],
        ['id'  => 576, 'module_id' => 26, 'parent_id' => 501, 'name' => 'Clear Login Activity', 'route' => 'activity_log.login.destroy_all', 'type' => 3 ],

        // visitors setup
        ['id'  => 502, 'module_id' => 27, 'parent_id' => null, 'name' => 'Visitors Setup', 'route' => 'visitors_setup', 'type' => 1 ],
        ['id'  => 503, 'module_id' => 27, 'parent_id' => 502, 'name' => 'Ignore IP List', 'route' => 'ignore_ip_list', 'type' => 2 ],

        // customer panel
        ['id'  => 504, 'module_id' => 28, 'parent_id' => null, 'name' => 'Customer Panel', 'route' => 'customer_panel', 'type' => 1 ],
        ['id'  => 505, 'module_id' => 28, 'parent_id' => 504, 'name' => 'My Purchased Orders', 'route' => 'frontend.my_purchase_order_list', 'type' => 2 ],
        ['id'  => 506, 'module_id' => 28, 'parent_id' => 504, 'name' => 'My Purchased Giftcards', 'route' => 'frontend.purchased-gift-card', 'type' => 2 ],
        ['id'  => 507, 'module_id' => 28, 'parent_id' => 504, 'name' => 'My Purchased Digital Products', 'route' => 'frontend.digital_product', 'type' => 2 ],
        ['id'  => 508, 'module_id' => 28, 'parent_id' => 504, 'name' => 'My Wishlists', 'route' => 'frontend.my-wishlist', 'type' => 2 ],
        ['id'  => 509, 'module_id' => 28, 'parent_id' => 504, 'name' => 'My Refund & Desputes', 'route' => 'refund.frontend.index', 'type' => 2 ],
        ['id'  => 510, 'module_id' => 28, 'parent_id' => 504, 'name' => 'My Coupon Lists', 'route' => 'customer_panel.coupon', 'type' => 2 ],
        ['id'  => 511, 'module_id' => 28, 'parent_id' => 504, 'name' => 'My Accounts', 'route' => 'frontend.customer_profile', 'type' => 2 ],
        ['id'  => 574, 'module_id' => 28, 'parent_id' => 504, 'name' => 'My Referral', 'route' => 'customer_panel.referral', 'type' => 2 ],

        

        // admin reports
        ['id' => 516, 'module_id' => 34, 'parent_id' => null, 'name' => 'Admin Report', 'route' => 'admin_report', 'type' => 1],
        ['id' => 518, 'module_id' => 34, 'parent_id' => 516, 'name' => 'User Searches', 'route' => 'report.user_searches', 'type' => 2],
        ['id' => 519, 'module_id' => 34, 'parent_id' => 516, 'name' => 'Visitor Report', 'route' => 'report.visitor_report', 'type' => 2],
        ['id' => 520, 'module_id' => 34, 'parent_id' => 516, 'name' => 'Inhouse Product Sale', 'route' => 'report.inhouse_product_sale', 'type' => 2],
        ['id' => 521, 'module_id' => 34, 'parent_id' => 516, 'name' => 'Product Stock', 'route' => 'report.product_stock', 'type' => 2],
        ['id' => 522, 'module_id' => 34, 'parent_id' => 516, 'name' => 'Wishlist Report', 'route' => 'report.wishlist', 'type' => 2],
        ['id' => 523, 'module_id' => 34, 'parent_id' => 516, 'name' => 'Wallet Recharge History', 'route' => 'report.wallet_recharge_history', 'type' => 2],
        ['id' => 525, 'module_id' => 34, 'parent_id' => 516, 'name' => 'Top Customers', 'route' => 'report.top_customer', 'type' => 2],
        ['id' => 526, 'module_id' => 34, 'parent_id' => 516, 'name' => 'Top Selling Items', 'route' => 'report.top_selling_item', 'type' => 2],
        ['id' => 527, 'module_id' => 34, 'parent_id' => 516, 'name' => 'Orders', 'route' => 'report.order', 'type' => 2],
        ['id' => 528, 'module_id' => 34, 'parent_id' => 516, 'name' => 'Payments', 'route' => 'report.payment', 'type' => 2],
        ['id' => 529, 'module_id' => 34, 'parent_id' => 516, 'name' => 'Product Reviews', 'route' => 'report.product_review', 'type' => 2],
        ['id' => 530, 'module_id' => 34, 'parent_id' => 516, 'name' => 'Company Reviews', 'route' => 'report.seller_review', 'type' => 2],
        

        // backup
        ['id' => 546, 'module_id' => 36, 'parent_id' => null, 'name' => 'Backup', 'route' => 'backup.index', 'type' => 1],
        ['id' => 547, 'module_id' => 36, 'parent_id' => 546, 'name' => 'Create', 'route' => 'backup.create', 'type' => 2],
        ['id' => 548, 'module_id' => 36, 'parent_id' => 546, 'name' => 'Delete', 'route' => 'backup.delete', 'type' => 2],
        ['id' => 549, 'module_id' => 36, 'parent_id' => 546, 'name' => 'Import', 'route' => 'backup.import', 'type' => 2],
        
        // Utilities
        ['id' => 631, 'module_id' => 38, 'parent_id' => null, 'name' => 'Utilities', 'route' => 'utilities.index', 'type' => 1],
        ['id' => 632, 'module_id' => 38, 'parent_id' => 631, 'name' => 'Clear Cache', 'route' => 'utilities_clear_cache', 'type' => 2],
        ['id' => 633, 'module_id' => 38, 'parent_id' => 631, 'name' => 'Clear Log', 'route' => 'utilities_clear_log', 'type' => 2],
        ['id' => 634, 'module_id' => 38, 'parent_id' => 631, 'name' => 'Change Debug mode', 'route' => 'utilities_change_debug_mode', 'type' => 2],
        ['id' => 635, 'module_id' => 38, 'parent_id' => 631, 'name' => 'Change Force HTTPS', 'route' => 'utilities_change_force_https', 'type' => 2],
        ['id' => 637, 'module_id' => 38, 'parent_id' => 631, 'name' => 'XML Sitemap', 'route' => 'utilities_xml_sitemap', 'type' => 2]

        //  last id 647

        //last module id 38

    ];

        DB::table('permissions')->insert($sql);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('permissions');
    }
}
