<?php

use App\Models\User;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Modules\SidebarManager\Entities\Sidebar;

class CreateSidebarsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sidebars', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sidebar_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('position')->default(0);
            $table->integer('module_id')->nullable();
            $table->integer('parent_id')->nullable();
            $table->string('name')->nullable();
            $table->string('route')->nullable();
            $table->boolean('type')->nullable()->comment('1 for main menu, 2 for sub menu , 3 action');
            $table->boolean('status')->default(1);
            $table->string('module')->nullable();
            $table->unsignedBigInteger('created_by')->default(1)->unsigned();
            $table->unsignedBigInteger('updated_by')->default(1)->unsigned();
            $table->timestamps();
        });

        $sql = [

            // Dashboard
            ['sidebar_id' => 1, 'module_id' => 1, 'parent_id' => null, 'name' => 'Dashboard', 'route' => 'admin.dashboard', 'type' => 1,'position' => 1], //Main menu


            //frontend cms
            ['sidebar_id' => 2, 'module_id' => 2, 'parent_id' => null, 'name' => 'Frontend CMS', 'route' => 'frontend_cms', 'type' => 1,'position' => 2],
            ['sidebar_id' => 3, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Home Page', 'route' => 'frontendcms.widget.index', 'type' => 2],
            ['sidebar_id' => 4, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Features', 'route' => 'frontendcms.features.index', 'type' => 2],
            ['sidebar_id' => 7, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Return Exchange', 'route' => 'frontendcms.return-exchange.index', 'type' => 2],
            ['sidebar_id' => 8, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Contact-Content', 'route' => 'frontendcms.contact-content.index', 'type' => 2],
            ['sidebar_id' => 9, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Dynamic Page', 'route' => 'frontendcms.dynamic-page.index', 'type' => 2],
            ['sidebar_id' => 10, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Footer Settings', 'route' => 'footerSetting.footer.index', 'type' => 2],
            ['sidebar_id' => 11, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Subscription', 'route' => 'frontendcms.subscribe-content.index', 'type' => 2],
            ['sidebar_id' => 170, 'module_id' => 2, 'parent_id' => 2, 'name' => 'POPUP', 'route' => 'frontendcms.popup-content.index', 'type' => 2],
            ['sidebar_id' => 12, 'module_id' => 2, 'parent_id' => 2, 'name' => 'About-us Content', 'route' => 'frontendcms.about-us.index', 'type' => 2],
            ['sidebar_id' => 13, 'module_id' => 2, 'parent_id' => 2, 'name' => 'Title', 'route' => 'frontendcms.title_index', 'type' => 2],

            //appearance
            ['sidebar_id' => 14, 'module_id' => 3, 'parent_id' => null, 'name' => 'Appearance', 'route' => 'appearance', 'type' => 1,'position' => 3],
            ['sidebar_id' => 15, 'module_id' => 3, 'parent_id' => 14, 'name' => 'Theme', 'route' => 'appearance.themes.index', 'type' => 2],
            ['sidebar_id' => 16, 'module_id' => 3, 'parent_id' => 14, 'name' => 'Menus', 'route' => 'menu.manage', 'type' => 2],
            ['sidebar_id' => 17, 'module_id' => 3, 'parent_id' => 14, 'name' => 'Header', 'route' => 'appearance.header.index', 'type' => 2],
            ['sidebar_id' => 18, 'module_id' => 3, 'parent_id' => 14, 'name' => 'Dashboard-setup', 'route' => 'appearance.dashoboard.index', 'type' => 2],
            ['sidebar_id' => 157, 'module_id' => 3, 'parent_id' => 14, 'name' => 'Dashboard Color', 'route' => 'appearance.color.index', 'type' => 2],
            ['sidebar_id' => 158, 'module_id' => 3, 'parent_id' => 14, 'name' => 'Color Scheme', 'route' => 'themeColor.index', 'type' => 2],


            //blog
            ['sidebar_id' => 19, 'module_id' => 4, 'parent_id' => null, 'name' => 'Blog Module', 'route' => 'blog_module', 'type' => 1,'position' => 4],
            ['sidebar_id' => 20, 'module_id' => 4, 'parent_id' => 19, 'name' => 'Blog Posts', 'route' => 'blog.post.get-data', 'type' => 2],
            ['sidebar_id' => 21, 'module_id' => 4, 'parent_id' => 19, 'name' => 'Blog Category', 'route' => 'blog.categories.index', 'type' => 2],

            //customers
            ['sidebar_id' => 23, 'module_id' => 5, 'parent_id' => null, 'name' => 'Customers', 'route' => 'cusotmer.list_active', 'type' => 1,'position' => 5],
            ['sidebar_id' => 24, 'module_id' => 5, 'parent_id' => 23, 'name' => 'Customer lists', 'route' => 'customer.show_details', 'type' => 2],


            //wallet manage
            ['sidebar_id' => 32, 'module_id' => 8, 'parent_id' => null, 'name' => 'Wallet manage', 'route' => 'wallet_manage', 'type' => 1,'position' => 8],
            ['sidebar_id' => 33, 'module_id' => 8, 'parent_id' => 32, 'name' => 'Online Recharge', 'route' => 'wallet_recharge.get-data', 'type' => 2],
            ['sidebar_id' => 164, 'module_id' => 8, 'parent_id' => 32, 'name' => 'Bank Recharge', 'route' => 'bank_recharge.index', 'type' => 2],
            ['sidebar_id' => 35, 'module_id' => 8, 'parent_id' => 32, 'name' => 'Offline Recharge', 'route' => 'wallet_recharge.offline_index_get_data', 'type' => 2],
            ['sidebar_id' => 165, 'module_id' => 8, 'parent_id' => 32, 'name' => 'Configuration', 'route' => 'wallet.wallet_configuration', 'type' => 2],

            //contact request
            ['sidebar_id' => 36, 'module_id' => 9, 'parent_id' => null, 'name' => 'Contact Request', 'route' => 'contact_request', 'type' => 1,'position' => 9],
            ['sidebar_id' => 37, 'module_id' => 9, 'parent_id' => 36, 'name' => 'Contact Request', 'route' => 'contactrequest.contact.index', 'type' => 2],

            //marketing module
            ['sidebar_id' => 38, 'module_id' => 10, 'parent_id' => null, 'name' => 'Marketing', 'route' => 'marketing_module', 'type' => 1,'position' => 10],
            ['sidebar_id' => 39, 'module_id' => 10, 'parent_id' => 38, 'name' => 'Flash Deal', 'route' => 'marketing.flash-deals', 'type' => 2],
            ['sidebar_id' => 40, 'module_id' => 10, 'parent_id' => 38, 'name' => 'Coupon', 'route' => 'marketing.coupon.get-data', 'type' => 2],
            ['sidebar_id' => 41, 'module_id' => 10, 'parent_id' => 38, 'name' => 'New User Zone', 'route' => 'marketing.new-user-zone', 'type' => 2],
            ['sidebar_id' => 42, 'module_id' => 10, 'parent_id' => 38, 'name' => 'News-Letter', 'route' => 'marketing.news-letter.get-data', 'type' => 2],
            ['sidebar_id' => 43, 'module_id' => 10, 'parent_id' => 38, 'name' => 'Bulk SMS', 'route' => 'marketing.bulk-sms.get-data', 'type' => 2],
            ['sidebar_id' => 44, 'module_id' => 10, 'parent_id' => 38, 'name' => 'Subscribers', 'route' => 'marketing.subscriber.get-data', 'type' => 2],
            ['sidebar_id' => 45, 'module_id' => 10, 'parent_id' => 38, 'name' => 'Referal Code', 'route' => 'marketing.referral-code.get-data', 'type' => 2],

            //gift cards
            ['sidebar_id' => 46, 'module_id' => 11, 'parent_id' => null, 'name' => 'Gift Card', 'route' => 'gift_card_manage', 'type' => 1,'position' => 11],
            ['sidebar_id' => 47, 'module_id' => 11, 'parent_id' => 46, 'name' => 'Gift Card List', 'route' => 'admin.giftcard.index', 'type' => 2],

            //products
            ['sidebar_id' => 48, 'module_id' => 12, 'parent_id' => null, 'name' => 'Product Module', 'route' => 'product_module', 'type' => 1,'position' => 12],
            ['sidebar_id' => 49, 'module_id' => 12, 'parent_id' => 48, 'name' => 'Categories', 'route' => 'product.category.index', 'type' => 2],
            ['sidebar_id' => 50, 'module_id' => 12, 'parent_id' => 48, 'name' => 'Brands', 'route' => 'product.brands.index', 'type' => 2],
            ['sidebar_id' => 51, 'module_id' => 12, 'parent_id' => 48, 'name' => 'Attributes', 'route' => 'product.attribute.index', 'type' => 2],
            ['sidebar_id' => 52, 'module_id' => 12, 'parent_id' => 48, 'name' => 'Units', 'route' => 'product.units.index', 'type' => 2],
            ['sidebar_id' => 53, 'module_id' => 12, 'parent_id' => 48, 'name' => 'Add new product', 'route' => 'product.create', 'type' => 2],
            ['sidebar_id' => 54, 'module_id' => 12, 'parent_id' => 48, 'name' => 'Products', 'route' => 'product.index', 'type' => 2],
            ['sidebar_id' => 55, 'module_id' => 12, 'parent_id' => 48, 'name' => 'Product Bulk Upload', 'route' => 'product.bulk_product_upload_page', 'type' => 2],
            ['sidebar_id' => 57, 'module_id' => 12, 'parent_id' => 48, 'name' => 'Recent Viewed', 'route' => 'product.recent_view_product_config', 'type' => 2],


            //reviews
            ['sidebar_id' => 58, 'module_id' => 13, 'parent_id' => null, 'name' => 'Reviews', 'route' => 'review_module', 'type' => 1,'position' => 13],
            ['sidebar_id' => 59, 'module_id' => 13, 'parent_id' => 58, 'name' => 'Product Reviews', 'route' => 'review.product.index', 'type' => 2],
            ['sidebar_id' => 60, 'module_id' => 13, 'parent_id' => 58, 'name' => 'Seller Reviews', 'route' => 'review.seller.index', 'type' => 2],
            ['sidebar_id' => 166, 'module_id' => 13, 'parent_id' => 58, 'name' => 'Configuration', 'route' => 'review.review_configuration', 'type' => 2],

            //order manages
            ['sidebar_id' => 63, 'module_id' => 14, 'parent_id' => null, 'name' => 'Admin Order Manage', 'route' => 'order_manage', 'type' => 1,'position' => 14],
            ['sidebar_id' => 65, 'module_id' => 14, 'parent_id' => 63, 'name' => 'Total Orders', 'route' => 'order_manage.total_sales_get_data', 'type' => 2],
            ['sidebar_id' => 67, 'module_id' => 14, 'parent_id' => 63, 'name' => 'Delivery Process', 'route' => 'order_manage.process_index', 'type' => 2],
            ['sidebar_id' => 68, 'module_id' => 14, 'parent_id' => 63, 'name' => 'Cancel Reason', 'route' => 'order_manage.cancel_reason_index', 'type' => 2],

           
            //refund manage
            ['sidebar_id' => 69, 'module_id' => 15, 'parent_id' => null, 'name' => 'Refund Manage', 'route' => 'refund_manage', 'type' => 1,'position' => 15],
            ['sidebar_id' => 70, 'module_id' => 15, 'parent_id' => 69, 'name' => 'Pending Refund List', 'route' => 'refund.total_refund_list', 'type' => 2],
            ['sidebar_id' => 71, 'module_id' => 15, 'parent_id' => 69, 'name' => 'Confirmed Refund List', 'route' => 'refund.confirmed_refund_requests', 'type' => 2],
            ['sidebar_id' => 73, 'module_id' => 15, 'parent_id' => 69, 'name' => 'Refund Reasons', 'route' => 'refund.reasons_list', 'type' => 2],
            ['sidebar_id' => 121, 'module_id' => 15, 'parent_id' => 69, 'name' => 'Refund Process', 'route' => 'refund.process_index', 'type' => 2],
            ['sidebar_id' => 74, 'module_id' => 15, 'parent_id' => 69, 'name' => 'Refund Configuration', 'route' => 'refund.config', 'type' => 2],

            //system setting
            ['sidebar_id' => 75, 'module_id' => 16, 'parent_id' => null, 'name' => 'System Settings', 'route' => 'system_settings', 'type' => 1,'position' => 16],
            ['sidebar_id' => 76, 'module_id' => 16, 'parent_id' => 75, 'name' => 'General Settings', 'route' => 'generalsetting.index', 'type' => 2],
            ['sidebar_id' => 77, 'module_id' => 16, 'parent_id' => 75, 'name' => 'Email Template Settings', 'route' => 'email_templates.index', 'type' => 2],
            ['sidebar_id' => 169, 'module_id' => 16, 'parent_id' => 75, 'name' => 'SMS Template Settings', 'route' => 'sms_templates.index', 'type' => 2],
            ['sidebar_id' => 78, 'module_id' => 16, 'parent_id' => 75, 'name' => 'Company Info', 'route' => 'company_info', 'type' => 2],
            ['sidebar_id' => 79, 'module_id' => 16, 'parent_id' => 75, 'name' => 'SMTP', 'route' => 'smtp_info', 'type' => 2],
            ['sidebar_id' => 80, 'module_id' => 16, 'parent_id' => 75, 'name' => 'SMS', 'route' => 'sms_info', 'type' => 2],
            ['sidebar_id' => 81, 'module_id' => 16, 'parent_id' => 75, 'name' => 'Analytics Tools', 'route' => 'setup.analytics.index', 'type' => 2],
            ['sidebar_id' => 82, 'module_id' => 16, 'parent_id' => 75, 'name' => 'Activation', 'route' => 'generalsetting.activation_index', 'type' => 2],
            ['sidebar_id' => 160, 'module_id' => 16, 'parent_id' => 75, 'name' => 'Maintenance mode', 'route' => 'maintenance.index', 'type' => 2],
            ['sidebar_id' => 161, 'module_id' => 16, 'parent_id' => 75, 'name' => 'Update System', 'route' => 'generalsetting.updatesystem', 'type' => 2],
            ['sidebar_id' => 162, 'module_id' => 16, 'parent_id' => 75, 'name' => 'Module Manager', 'route' => 'modulemanager.index', 'type' => 2],
            ['sidebar_id' => 163, 'module_id' => 16, 'parent_id' => 75, 'name' => 'Notification Setting', 'route' => 'notificationsetting.index', 'type' => 2],

            //payment gateways
            ['sidebar_id' => 83, 'module_id' => 17, 'parent_id' => null, 'name' => 'Payment Gateways', 'route' => 'payment_gateway.index', 'type' => 1,'position' => 17],

            //setup
            ['sidebar_id' => 84, 'module_id' => 18, 'parent_id' => null, 'name' => 'Setup', 'route' => 'setup_module', 'type' => 1,'position' => 18],
            ['sidebar_id' => 85, 'module_id' => 18, 'parent_id' => 84, 'name' => 'Language', 'route' => 'languages.index', 'type' => 2],
            ['sidebar_id' => 86, 'module_id' => 18, 'parent_id' => 84, 'name' => 'currency', 'route' => 'currencies.index', 'type' => 2],
            ['sidebar_id' => 87, 'module_id' => 18, 'parent_id' => 84, 'name' => 'Locations', 'route' => 'location_manage', 'type' => 2],
            ['sidebar_id' => 88, 'module_id' => 18, 'parent_id' => 84, 'name' => 'Shipping Method', 'route' => 'shipping_methods.index', 'type' => 2],
            ['sidebar_id' => 22, 'module_id' => 18, 'parent_id' => 84, 'name' => 'Tag', 'route' => 'tags.index', 'type' => 2],

            //GST Setup
            ['sidebar_id' => 89, 'module_id' => 19, 'parent_id' => null, 'name' => 'GST Setup', 'route' => 'gst_setup', 'type' => 1,'position' => 19],
            ['sidebar_id' => 90, 'module_id' => 19, 'parent_id' => 89, 'name' => 'GST List', 'route' => 'gst_tax.index', 'type' => 2],
            ['sidebar_id' => 91, 'module_id' => 19, 'parent_id' => 89, 'name' => 'GST Configuration', 'route' => 'gst_tax.configuration_index', 'type' => 2],

            //accounts
            ['sidebar_id' => 92, 'module_id' => 20, 'parent_id' => null, 'name' => 'Accounts', 'route' => 'account_module', 'type' => 1,'position' => 20],
            ['sidebar_id' => 93, 'module_id' => 20, 'parent_id' => 92, 'name' => 'Chart of Account', 'route' => 'account.chart-of-accounts.index', 'type' => 2],
            ['sidebar_id' => 94, 'module_id' => 20, 'parent_id' => 92, 'name' => 'Bank Account', 'route' => 'account.bank-accounts.index', 'type' => 2],
            ['sidebar_id' => 95, 'module_id' => 20, 'parent_id' => 92, 'name' => 'Income', 'route' => 'account.incomes.index', 'type' => 2],
            ['sidebar_id' => 96, 'module_id' => 20, 'parent_id' => 92, 'name' => 'Expense', 'route' => 'account.expenses.index', 'type' => 2],
            ['sidebar_id' => 97, 'module_id' => 20, 'parent_id' => 92, 'name' => 'Profit', 'route' => 'account.profit', 'type' => 2],
            ['sidebar_id' => 98, 'module_id' => 20, 'parent_id' => 92, 'name' => 'Transaction', 'route' => 'account.transaction', 'type' => 2],
            ['sidebar_id' => 99, 'module_id' => 20, 'parent_id' => 92, 'name' => 'Statement', 'route' => 'account.statement', 'type' => 2],

            // Support Ticket
            ['sidebar_id' => 100, 'module_id' => 21, 'parent_id' => null, 'name' => 'Support Ticket', 'route' => 'support_tickets', 'type' => 1,'position' => 21],
            ['sidebar_id' => 101, 'module_id' => 21, 'parent_id' => 100, 'name' => 'Ticket', 'route' => 'ticket.tickets.index', 'type' => 2],
            ['sidebar_id' => 102, 'module_id' => 21, 'parent_id' => 100, 'name' => 'Category', 'route' => 'ticket.category.index', 'type' => 2],
            ['sidebar_id' => 103, 'module_id' => 21, 'parent_id' => 100, 'name' => 'Priority', 'route' => 'ticket.priority.index', 'type' => 2],
            ['sidebar_id' => 104, 'module_id' => 21, 'parent_id' => 100, 'name' => 'Status', 'route' => 'ticket.status.index', 'type' => 2],
            ['sidebar_id' => 105, 'module_id' => 21, 'parent_id' => 100, 'name' => 'My Assign Tickets', 'route' => 'ticket.assign.user', 'type' => 2],

            // activity logs
            ['sidebar_id' => 107, 'module_id' => 22, 'parent_id' => null, 'name' => 'Activity Logs', 'route' => 'activity_logs', 'type' => 1,'position' => 22],
            ['sidebar_id' => 108, 'module_id' => 22, 'parent_id' => 107, 'name' => 'Activity Logs', 'route' => 'activity_log', 'type' => 2],
            ['sidebar_id' => 109, 'module_id' => 22, 'parent_id' => 107, 'name' => 'User Login Activity', 'route' => 'activity_log.login', 'type' => 2],

            // hr
            ['sidebar_id' => 110, 'module_id' => 23, 'parent_id' => null, 'name' => 'Human Resource', 'route' => 'human_resource', 'type' => 1,'position' => 23],
            ['sidebar_id' => 111, 'module_id' => 23, 'parent_id' => 110, 'name' => 'Staff', 'route' => 'staffs.index', 'type' => 2],
            ['sidebar_id' => 112, 'module_id' => 23, 'parent_id' => 110, 'name' => 'Role', 'route' => 'permission.roles.index', 'type' => 2],
            ['sidebar_id' => 113, 'module_id' => 23, 'parent_id' => 110, 'name' => 'Department', 'route' => 'departments.index', 'type' => 2],
            ['sidebar_id' => 114, 'module_id' => 23, 'parent_id' => 110, 'name' => 'Attendance', 'route' => 'attendances.index', 'type' => 2],
            ['sidebar_id' => 115, 'module_id' => 23, 'parent_id' => 110, 'name' => 'Attendance Report', 'route' => 'attendance_report.index', 'type' => 2],
            ['sidebar_id' => 116, 'module_id' => 23, 'parent_id' => 110, 'name' => 'Event', 'route' => 'events.index', 'type' => 2],
            ['sidebar_id' => 117, 'module_id' => 23, 'parent_id' => 110, 'name' => 'Holiday Setup', 'route' => 'holidays.index', 'type' => 2],

            //visitor setup
            ['sidebar_id' => 118, 'module_id' => 24, 'parent_id' => null, 'name' => 'Visitor Setup', 'route' => 'visitors_setup', 'type' => 1,'position' => 24],
            ['sidebar_id' => 119, 'module_id' => 24, 'parent_id' => 118, 'name' => 'Ignore IP', 'route' => 'ignore_ip_list', 'type' => 2],

            // sidebar manager
            ['sidebar_id' => 122, 'module_id' => 25, 'parent_id' => null, 'name' => 'Sidebar Manage', 'route' => 'sidebar-manager.index', 'type' => 1,'position' => 25],

            // Customer Panel
            ['sidebar_id' => 123, 'module_id' => 26, 'parent_id' => null, 'name' => 'Customer Panel', 'route' => 'customer_panel', 'type' => 1,'position' => 26],
            ['sidebar_id' => 124, 'module_id' => 26, 'parent_id' => 123, 'name' => 'My Purchase Orders', 'route' => 'frontend.my_purchase_order_list', 'type' => 2],
            ['sidebar_id' => 125, 'module_id' => 26, 'parent_id' => 123, 'name' => 'My Giftcards', 'route' => 'frontend.purchased-gift-card', 'type' => 2],
            ['sidebar_id' => 126, 'module_id' => 26, 'parent_id' => 123, 'name' => 'My Digital Products', 'route' => 'frontend.digital_product', 'type' => 2],
            ['sidebar_id' => 127, 'module_id' => 26, 'parent_id' => 123, 'name' => 'My Wishlists', 'route' => 'frontend.my-wishlist', 'type' => 2],
            ['sidebar_id' => 128, 'module_id' => 26, 'parent_id' => 123, 'name' => 'My Refund Desputes', 'route' => 'refund.frontend.index', 'type' => 2],
            ['sidebar_id' => 129, 'module_id' => 26, 'parent_id' => 123, 'name' => 'My Coupons', 'route' => 'customer_panel.coupon', 'type' => 2],
            ['sidebar_id' => 130, 'module_id' => 26, 'parent_id' => 123, 'name' => 'My Profiles', 'route' => 'frontend.customer_profile', 'type' => 2],
            ['sidebar_id' => 167, 'module_id' => 26, 'parent_id' => 123, 'name' => 'My Referral', 'route' => 'customer_panel.referral', 'type' => 2],

            

            // admin report
            ['sidebar_id' => 136, 'module_id' => 31, 'parent_id' => null, 'name' => 'Admin Report', 'route' => 'admin_report', 'type' => 1,'position' => 31],
            ['sidebar_id' => 138, 'module_id' => 31, 'parent_id' => 136, 'name' => 'User Searches', 'route' => 'report.user_searches', 'type' => 2],
            ['sidebar_id' => 139, 'module_id' => 31, 'parent_id' => 136, 'name' => 'Visitor Report', 'route' => 'report.visitor_report', 'type' => 2],
            ['sidebar_id' => 140, 'module_id' => 31, 'parent_id' => 136, 'name' => 'Inhouse Product Sale', 'route' => 'report.inhouse_product_sale', 'type' => 2],
            ['sidebar_id' => 141, 'module_id' => 31, 'parent_id' => 136, 'name' => 'Product Stock', 'route' => 'report.product_stock', 'type' => 2],
            ['sidebar_id' => 142, 'module_id' => 31, 'parent_id' => 136, 'name' => 'Wishlist Report', 'route' => 'report.wishlist', 'type' => 2],
            ['sidebar_id' => 143, 'module_id' => 31, 'parent_id' => 136, 'name' => 'Wallet Recharge History', 'route' => 'report.wallet_recharge_history', 'type' => 2],
            ['sidebar_id' => 145, 'module_id' => 31, 'parent_id' => 136, 'name' => 'Top Customers', 'route' => 'report.top_customer', 'type' => 2],
            ['sidebar_id' => 146, 'module_id' => 31, 'parent_id' => 136, 'name' => 'Top Selling Items', 'route' => 'report.top_selling_item', 'type' => 2],
            ['sidebar_id' => 147, 'module_id' => 31, 'parent_id' => 136, 'name' => 'Orders', 'route' => 'report.order', 'type' => 2],
            ['sidebar_id' => 148, 'module_id' => 31, 'parent_id' => 136, 'name' => 'Payments', 'route' => 'report.payment', 'type' => 2],
            ['sidebar_id' => 149, 'module_id' => 31, 'parent_id' => 136, 'name' => 'Product Reviews', 'route' => 'report.product_review', 'type' => 2],
            ['sidebar_id' => 150, 'module_id' => 31, 'parent_id' => 136, 'name' => 'Seller Reviews', 'route' => 'report.seller_review', 'type' => 2],


            // backup
            ['sidebar_id' => 159, 'module_id' => 33, 'parent_id' => null, 'name' => 'Backup', 'route' => 'backup.index', 'type' => 1,'position' => 33],

            // utilities
            ['sidebar_id' => 171, 'module_id' => 35, 'parent_id' => null, 'name' => 'Utilities', 'route' => 'utilities.index', 'type' => 1,'position' => 35],

            //start from 173  .....

            //module_id 35
        ];

        $users =  User::whereHas('role', function($query){
            $query->where('type', 'superadmin')->orWhere('type', 'admin')->orWhere('type', 'staff')->orWhere('type', 'seller');
        })->pluck('id');

        foreach ($users as $key=> $user)
        {
            $user_array[$key] = ['user_id' => $user];
            foreach ($sql as $row)
            {
                $final_row = array_merge($user_array[$key],$row);
                $sidebar = Sidebar::create($final_row);
                $route = explode('.',$sidebar->route);
                if (array_key_exists(1,$route)) {
                    if ($route[1] == 'widgets') {
                        Sidebar::where('type',3)->where('parent_id',null)->update(['parent_id' => 34]);
                    }
                    if ($route[1] == 'graph') {
                        Sidebar::where('type',3)->where('parent_id',null)->update(['parent_id' => 35]);
                    }
                }
            }
        }
        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sidebars');
    }
}
