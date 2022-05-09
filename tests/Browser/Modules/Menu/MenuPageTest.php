<?php

namespace Tests\Browser\Modules\Menu;

use App\Models\User;
use App\Traits\ImageStore;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\WithFaker;
use Laravel\Dusk\Browser;
use Modules\Menu\Entities\MegaMenuBottomPanel;
use Modules\Menu\Entities\MegaMenuRightPanel;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Entities\MenuColumn;
use Modules\Menu\Entities\MenuElement;
use Modules\Menu\Entities\MultiMegaMenu;
use Modules\Product\Entities\Brand;
use Modules\Product\Entities\Category;
use Modules\Product\Entities\Product;
use Modules\Product\Entities\ProductSku;
use Modules\Product\Entities\ProductTag;
use Modules\Product\Entities\UnitType;
use Modules\Seller\Entities\SellerProduct;
use Modules\Seller\Entities\SellerProductSKU;
use Modules\Shipping\Entities\ShippingMethod;
use Tests\DuskTestCase;

class MenuPageTest extends DuskTestCase
{
    use WithFaker;
    use ImageStore;

    protected $categories =[];
    protected $brands =[];
    protected $units =[];
    protected $shipping_methods =[];
    protected $products =[];
    protected $productSKUS =[];
    protected $tags =[];
    protected $sellerProducts = [];
    protected $sellerProductSKUS = [];


    public function setUp(): void
    {
        parent::setUp();

        for ($i = 0; $i < 3; $i++) {
            $this->categories[] = Category::create([
                'name' => $this->faker->name,
                'slug' => $this->faker->slug,
                'parent_id' => 0
            ]);


            $this->brands[] = Brand::create([
                'name' => $this->faker->name,
                'slug' => $this->faker->slug,
                'status' => 1,
                'logo' => 'backend/testing/60dfe802a57ab.png'
            ]);

            $this->units[] = UnitType::create([
                'name' => $this->faker->name,
                'status' => 1
            ]);

            $this->shipping_methods[] = ShippingMethod::create([
                'method_name' => $this->faker->name,
                'phone' => $this->faker->phoneNumber,
                'shipping_time' => '8-12 days',
                'cost' => 5,
                'is_active' => 1
            ]);

            $this->products[] = Product::create([
                'product_type' => 1,
                'product_name' => $this->faker->name,
                'model_number' => 'euirwe7457845',
                'category_id' => $this->categories[0]->id,
                'brand_id' => $this->brands[0]->id,
                'unit_type_id' => $this->units[0]->id,
                'barcode_type' => 'c39',
                'minimum_order_qty' => '1',
                'max_order_qty' => '5',
                "tags" => "tag,tag 2",
                "description" => "<p>test</p>",
                "selling_price" => "0",
                "tax" => "0",
                "tax_type" => "1",
                "discount" => "0",
                "discount_type" => "1",
                "specification" => "<p>test</p>",
                "is_physical" => "1",
                "additional_shipping" => "0",
                "meta_title" => null,
                "meta_description" => null,
                "video_provider" => "youtube",
                "video_link" => null,
                "status" => "1",
                "display_in_details" => "1",
                'thumbnail_image' => 'backend/testing/60dfe802a57ab.png'
            ]);

            $this->productSKUS[] = ProductSku::create([
                'product_id' => $this->products[$i]->id,
                'sku' =>  'sku-748578'.$this->products[$i]->id,
                'purchase_price' => 100,
                'selling_price' => 100,
                'additional_shipping' => 0,
                'status' => 1,
            ]);

            $this->tags[] = ProductTag::create([
                'product_id' => $this->products[$i]->id,
                'tag' => $this->faker->slug
            ]);

            $this->sellerProducts[] = SellerProduct::create([
                "product_id" => $this->products[$i]->id,
                "user_id" => 1,
                "stock_manage" => "1",
                "slug" => $this->faker->slug,
                "product_stock" => 5,
                "selling_price" => 6250,
                "product_name" => $this->products[$i]->product_name,
                "tax" => 5,
                "tax_type" => 0,
                "discount" => 50,
                "discount_type" => 1,
                "discount_start_date" => "05/01/2021",
                "discount_end_date" => "08/31/2021",
                'thum_img' => 'backend/testing/60dfe802a57ab.png'
            ]);

            $this->sellerProductSKUS[] = SellerProductSKU::create([
                "user_id" => 1,
                "product_id" => $this->products[$i]->id,
                "product_sku_id" => $this->productSKUS[$i]->id,
                "selling_price" => $this->productSKUS[$i]->selling_price
            ]);

        }

    }

    public function tearDown(): void
    {

        foreach ($this->categories as $category) {
            $category->delete();
        }
        foreach ($this->brands as $brand) {
            $brand->delete();
        }
        foreach ($this->units as $unit) {
            $unit->delete();
        }
        foreach ($this->shipping_methods as $shipping_method) {
            $shipping_method->delete();
        }

        foreach ($this->products as $product) {
            $product->delete();
        }
        foreach ($this->productSKUS as $sku) {
            $sku->delete();
        }

        foreach ($this->tags as $tag) {
            $tag->delete();
        }

        foreach ($this->sellerProducts as $product) {
            $product->delete();
        }

        foreach ($this->sellerProductSKUS as $sku) {
            $sku->delete();
        }

        $menus = Menu::pluck('id');
        Menu::destroy($menus);
        $columns = MenuColumn::pluck('id');
        MenuColumn::destroy($columns);
        $elements = MenuElement::pluck('id');
        MenuElement::destroy($elements);

        $multi_mega_menus = MultiMegaMenu::pluck('id');
        MultiMegaMenu::destroy($multi_mega_menus);

        parent::tearDown(); // TODO: Change the autogenerated stub
    }

    /**
     * A Dusk test example.
     *
     * @return void
     */
    public function test_for_visit_menu_index()
    {
        $this->browse(function (Browser $browser) {
            $browser->loginAs(User::find(1))
                    ->visit('/menu/manage')
                    ->assertSee('Menu List');
        });
    }

    public function test_for_create_menu(){
        $this->test_for_visit_menu_index();
        $this->browse(function (Browser $browser) {
            $browser->type('#name', $this->faker->name)
                ->type('#icon','ti-star')
                ->click('#create_form > div > div > div:nth-child(1) > div:nth-child(2) > div > label')
                ->pause(2000)
                ->click('#menu_type_div > div > div')
                ->click('#menu_type_div > div > div > ul > li:nth-child(2)')
                ->click('#display_position_div > div > div')
                ->click('#display_position_div > div > div > ul > li:nth-child(4)')
                ->click('#create_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Created successfully!');
        });
    }

    public function test_for_validate_create_menu(){
        $this->test_for_visit_menu_index();
        $this->browse(function (Browser $browser) {
            $browser->click('#create_btn')
                ->waitForText('The name field is required.', 25)
                ->assertSee('The name field is required.')
                ->assertSee('The slug field is required.')
                ->assertSee('The menu type field is required.')
                ->assertSee('The menu position field is required.');
        });
    }

    public function test_for_edit_menu(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $browser->click('#mainTbody > tr > td:nth-child(6) > div > button')
                ->click('#mainTbody > tr > td:nth-child(6) > div > div > a.dropdown-item.edit_menu')
                ->waitForText('Edit Menu', 25)
                ->type('#name', $this->faker->name)
                ->type('#icon','ti-star')
                ->click('#edit_form > div > div > div:nth-child(1) > div:nth-child(2) > div > label')
                ->pause(2000)
                ->click('#theme_nav > li:nth-child(1) > label > span')
                ->click('#display_position_div > div > div')
                ->click('#display_position_div > div > div > ul > li:nth-child(3)')
                ->click('#create_btn')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
        
    }

    public function test_for_delete_menu(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $browser->click('#mainTbody > tr > td:nth-child(6) > div > button')
                ->click('#mainTbody > tr > td:nth-child(6) > div > div > a.dropdown-item.delete_menu')
                ->whenAvailable('#menu_delete_form', function($modal){
                    $modal->click('#menuDeleteBtn');
                })
                ->pause(6000)
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');

        });
    }

    public function test_for_menu_status_change(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $browser->click('#mainTbody > tr > td:nth-child(5) > label > div')
                ->pause(6000)
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
        });
    }


    public function test_for_visit_setup_menu(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $item = Menu::latest()->first();

            $browser->click('#mainTbody > tr > td:nth-child(6) > div > button')
                ->click('#mainTbody > tr > td:nth-child(6) > div > div > a.dropdown-item.setup_menu')
                ->assertPathIs('/menu/setup/'.$item->id)
                ->assertSeeIn('#headingOne > h5 > button', 'Add Column');

        });


    }

    public function test_for_add_column(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $item = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$item->id)
            ->assertPathIs('/menu/setup/'.$item->id)
            ->assertSeeIn('#headingOne > h5 > button', 'Add Column')
            ->click('#headingOne > h5')
            ->waitFor('#row',4)
            ->type('#row', $this->faker->title)
            ->click('#row_element_div > div:nth-child(2) > div > div')
            ->click('#row_element_div > div:nth-child(2) > div > div > ul > li:nth-child(4)')
            ->click('#add_row_btn')
            ->waitFor('.toast-message',25)
            ->assertSeeIn('.toast-message', 'Created successfully!');
                
        });
    }

    public function test_for_edit_column(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $column = MenuColumn::where('menu_id', $menu->id)->first();
            $browser->visit('/menu/setup/'.$menu->id)
                ->assertPathIs('/menu/setup/'.$menu->id)
                ->assertSeeIn('#headingOne > h5 > button', 'Add Column')
                ->click('#accordion_column_'.$column->id.' > div.pull-right > a.panel-title.d-inline.mr-10.primary-btn')
                ->waitFor('#edit_column', 4)
                ->type('#edit_column', $this->faker->name)
                ->click('#columnEditForm > div > div:nth-child(3) > div > div')
                ->click('#columnEditForm > div > div:nth-child(3) > div > div > ul > li:nth-child(5)')
                ->click('#columnEditForm > div > div.col-lg-12.text-center > div > button')
                ->waitFor('.toast-message',25)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_delete_column(){
        $this->test_for_add_column();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $column = MenuColumn::where('menu_id', $menu->id)->latest()->first();

            $browser->click('#accordion_column_'.$column->id.' > div.pull-right > a.d-inline.primary-btn.column_delete_btn')
                ->whenAvailable('#column_delete_form', function($modal){
                    $modal->click('#columnDeleteBtn');
                })
                ->pause(7000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');
        });
    }

    public function test_for_add_link_to_mega_menu(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
                ->assertPathIs('/menu/setup/'.$menu->id)
                ->assertSeeIn('#headingOne > h5 > button', 'Add Column')
                ->click('#headingTwo > h5')
                ->waitFor('#title', 4)
                ->type('#title', $this->faker->title)
                ->type('#link', $this->faker->slug)
                ->click('#add_link_btn')
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }

    public function test_for_edit_link_to_mega_menu(){
        $this->test_for_add_link_to_mega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title',6)
                ->click('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title')
                ->waitFor('#elementEditForm > div > div:nth-child(3) > div > input')
                ->type('#elementEditForm > div > div:nth-child(3) > div > input', $this->faker->title)
                ->type('#elementEditForm > div > div:nth-child(4) > div > input', $this->faker->slug)
                ->click('#elementEditForm > div > div.col-xl-12 > div > ul > li > label > span')
                ->click('#elementEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(5000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');
            
        });
    }

    public function test_for_delete_element_to_mega_menu(){
        $this->test_for_add_link_to_mega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.primary-btn.element_delete_btn',6)
                ->click('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.primary-btn.element_delete_btn')
                ->whenAvailable('#element_delete_form', function($modal){
                    $modal->click('#elementDeleteBtn');
                })
                ->pause(7000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');
            
        });

    }

    public function test_for_add_category_to_mega_menu(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingOne > h5 > button', 'Add Column')
            ->click('#headingThree > h5')
            ->click('#collapseThree > div > div > div:nth-child(1) > div > div')
            ->click('#collapseThree > div > div > div:nth-child(1) > div > div > ul > li:nth-child(1)')
            ->click('#collapseThree > div > div > div:nth-child(1) > div > div')
            ->click('#collapseThree > div > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
            ->click('#add_category_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }

    public function test_for_edit_category_to_mega_menu(){
        $this->test_for_add_category_to_mega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title',4)
                ->click('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title')
                ->waitFor('#elementEditForm > div > div:nth-child(3) > div > input', 4)
                ->type('#elementEditForm > div > div:nth-child(3) > div > input', $this->faker->name)
                ->click('#elementEditForm > div > div:nth-child(4) > div > div')
                ->click('#elementEditForm > div > div:nth-child(4) > div > div > ul > li:nth-child(4)')
                ->click('#elementEditForm > div > div.col-xl-12 > div > ul > li > label > span')
                ->click('#elementEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(6000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');


        });
    }

    public function test_for_add_page_to_mega_menu(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingOne > h5 > button', 'Add Column')
            ->click('#headingPages > h5')
            ->click('#pages > div > div > div:nth-child(1) > div > div')
            ->click('#pages > div > div > div:nth-child(1) > div > div > ul > li:nth-child(1)')
            ->click('#pages > div > div > div:nth-child(1) > div > div')
            ->click('#pages > div > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
            ->click('#add_page_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }

    public function test_for_edit_page_to_mega_menu(){
        $this->test_for_add_page_to_mega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title',4)
                ->click('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title')
                ->waitFor('#elementEditForm > div > div:nth-child(3) > div > input', 4)
                ->type('#elementEditForm > div > div:nth-child(3) > div > input', $this->faker->name)
                ->click('#elementEditForm > div > div:nth-child(4) > div > div')
                ->click('#elementEditForm > div > div:nth-child(4) > div > div > ul > li:nth-child(4)')
                ->click('#elementEditForm > div > div.col-xl-12 > div > ul > li > label > span')
                ->click('#elementEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(5000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_add_product_to_mega_menu(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingOne > h5 > button', 'Add Column')
            ->click('#headingProduct > h5')
            ->click('#products > div > div > div:nth-child(1) > div > div')
            ->click('#products > div > div > div:nth-child(1) > div > div > ul > li:nth-child(1)')
            ->click('#products > div > div > div:nth-child(1) > div > div')
            ->click('#products > div > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
            ->click('#add_product_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }

    public function test_for_edit_product_to_mega_menu(){
        $this->test_for_add_product_to_mega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title',4)
                ->click('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title')
                ->waitFor('#elementEditForm > div > div:nth-child(3) > div > input', 4)
                ->type('#elementEditForm > div > div:nth-child(3) > div > input', $this->faker->name)
                ->click('#elementEditForm > div > div:nth-child(4) > div > div')
                ->click('#elementEditForm > div > div:nth-child(4) > div > div > ul > li:nth-child(4)')
                ->click('#elementEditForm > div > div.col-xl-12 > div > ul > li > label > span')
                ->click('#elementEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(5000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_add_brand_to_mega_menu(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingOne > h5 > button', 'Add Column')
            ->click('#headingBrand > h5')
            ->click('#brands > div > div > div:nth-child(1) > div > div')
            ->click('#brands > div > div > div:nth-child(1) > div > div > ul > li:nth-child(1)')
            ->click('#brands > div > div > div:nth-child(1) > div > div')
            ->click('#brands > div > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
            ->click('#add_brand_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }


    public function test_for_edit_brand_to_mega_menu(){
        $this->test_for_add_brand_to_mega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title',4)
                ->click('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title')
                ->waitFor('#elementEditForm > div > div:nth-child(3) > div > input', 4)
                ->type('#elementEditForm > div > div:nth-child(3) > div > input', $this->faker->name)
                ->click('#elementEditForm > div > div:nth-child(4) > div > div')
                ->click('#elementEditForm > div > div:nth-child(4) > div > div > ul > li:nth-child(4)')
                ->click('#elementEditForm > div > div.col-xl-12 > div > ul > li > label > span')
                ->click('#elementEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(5000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_add_tag_to_mega_menu(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingOne > h5 > button', 'Add Column')
            ->click('#headingTag > h5')
            ->click('#tags > div > div > div:nth-child(1) > div > div')
            ->click('#tags > div > div > div:nth-child(1) > div > div > ul > li:nth-child(1)')
            ->click('#tags > div > div > div:nth-child(1) > div > div')
            ->click('#tags > div > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
            ->click('#add_tag_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }


    public function test_for_edit_tag_to_mega_menu(){
        $this->test_for_add_tag_to_mega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title',4)
                ->click('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title')
                ->waitFor('#elementEditForm > div > div:nth-child(3) > div > input', 4)
                ->click('#elementEditForm > div > div:nth-child(4) > div > div')
                ->click('#elementEditForm > div > div:nth-child(4) > div > div > ul > li:nth-child(3)')
                ->click('#elementEditForm > div > div.col-xl-12 > div > ul > li > label > span')
                ->click('#elementEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(6000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_right_panel_category_add_to_mega_menu(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingOne > h5 > button', 'Add Column')
            ->click('#main-content > section > div.row > div > div > div > ul > li:nth-child(2)')
            ->waitFor('#heading_rightpanel_create > h5 >button', 4)
            ->assertSeeIn('#heading_rightpanel_create > h5 > button', 'Add Category')
            ->click('#heading_rightpanel_create > h5 >button')
            ->waitFor('#menusrightpanel_create > div > div > div:nth-child(1) > div > div', 4)
            ->click('#menusrightpanel_create > div > div > div:nth-child(1) > div > div')
            ->click('#menusrightpanel_create > div > div > div:nth-child(1) > div > div > ul > li:nth-child(1)')
            ->click('#menusrightpanel_create > div > div > div:nth-child(1) > div > div')
            ->click('#menusrightpanel_create > div > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
            ->click('#add_category_rightpanel_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });

    }

    public function test_for_right_panel_category_edit_to_mega_menu(){
        $this->test_for_right_panel_category_add_to_mega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MegaMenuRightPanel::where('menu_id', $menu->id)->first();
            $browser->waitFor('#accordion_right_'.$element->id.' > div.card-header.card_header_element > a.pull-right.d-inline.mr-10.primary-btn',4)
                ->click('#accordion_right_'.$element->id.' > div.card-header.card_header_element > a.pull-right.d-inline.mr-10.primary-btn')
                ->waitFor('#rightPanelDataEditForm > div > div:nth-child(2) > div > input', 4)
                ->type('#rightPanelDataEditForm > div > div:nth-child(2) > div > input', $this->faker->name)
                ->click('#rightPanelDataEditForm > div > div:nth-child(3) > div > div')
                ->click('#rightPanelDataEditForm > div > div:nth-child(3) > div > div > ul > li:nth-child(3)')
                ->click('#rightPanelDataEditForm > div > div.col-xl-12 > div > ul > li > label > span')
                ->click('#rightPanelDataEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(6000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_right_panel_category_delete_to_mega_menu(){
        $this->test_for_right_panel_category_add_to_mega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MegaMenuRightPanel::where('menu_id', $menu->id)->first();
            $browser->waitFor('#accordion_right_'.$element->id.' > div.card-header.card_header_element > a.pull-right.d-inline.primary-btn.right_panel_category_delete_btn',4)
                ->click('#accordion_right_'.$element->id.' > div.card-header.card_header_element > a.pull-right.d-inline.primary-btn.right_panel_category_delete_btn')
                ->whenAvailable('#category_delete_form', function($modal){
                    $modal->click('#categoryDeleteBtn');
                })
                ->pause(6000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');

        });
    }


    public function test_for_bottom_panel_brand_add_to_mega_menu(){
        $this->test_for_create_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingOne > h5 > button', 'Add Column')
            ->click('#main-content > section > div.row > div > div > div > ul > li:nth-child(3)')
            ->waitFor('#headingBrand_bottompanel_create > h5 > button', 4)
            ->assertSeeIn('#headingBrand_bottompanel_create > h5 > button', 'Add Brand')
            ->click('#headingBrand_bottompanel_create > h5 > button')
            ->waitFor('#brands_bottompanel_create > div > div > div:nth-child(1) > div > div', 4)
            ->click('#brands_bottompanel_create > div > div > div:nth-child(1) > div > div')
            ->click('#brands_bottompanel_create > div > div > div:nth-child(1) > div > div > ul > li:nth-child(1)')
            ->click('#brands_bottompanel_create > div > div > div:nth-child(1) > div > div')
            ->click('#brands_bottompanel_create > div > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
            ->click('#add_brand_bottompanel_create_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });

    }

    public function test_for_bottom_panel_brand_edit_to_mega_menu(){
        $this->test_for_bottom_panel_brand_add_to_mega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MegaMenuBottomPanel::where('menu_id', $menu->id)->first();
            $browser->waitFor('#accordion_bottom_'.$element->id.' > div.card-header.card_header_element > a.pull-right.d-inline.mr-10.primary-btn',4)
                ->click('#accordion_bottom_'.$element->id.' > div.card-header.card_header_element > a.pull-right.d-inline.mr-10.primary-btn')
                ->waitFor('#bottomPanelDataEditForm > div > div:nth-child(2) > div > input', 4)
                ->type('#bottomPanelDataEditForm > div > div:nth-child(2) > div > input', $this->faker->name)
                ->click('#bottomPanelDataEditForm > div > div:nth-child(3) > div > div')
                ->click('#bottomPanelDataEditForm > div > div:nth-child(3) > div > div > ul > li:nth-child(3)')
                ->click('#bottomPanelDataEditForm > div > div.col-xl-12 > div > ul > li > label > span')
                ->click('#bottomPanelDataEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(5000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_bottom_panel_brand_delete_to_mega_menu(){
        $this->test_for_bottom_panel_brand_add_to_mega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MegaMenuBottomPanel::where('menu_id', $menu->id)->first();
            $browser->waitFor('#accordion_bottom_'.$element->id.' > div.card-header.card_header_element > a.pull-right.d-inline.primary-btn.bottom_panel_brand_delete_btn',4)
                ->click('#accordion_bottom_'.$element->id.' > div.card-header.card_header_element > a.pull-right.d-inline.primary-btn.bottom_panel_brand_delete_btn')
                ->whenAvailable('#deleteBrandModal > div > div > div.modal-body > div.mt-40.d-flex.justify-content-between', function($modal){
                    $modal->click('#brandDeleteBtn');
                })
                ->pause(6000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');

        });
    }


    public function test_for_create_normal_menu(){
        $this->test_for_visit_menu_index();
        $this->browse(function (Browser $browser) {
            $browser->type('#name', $this->faker->name)
                ->type('#icon','ti-star')
                ->click('#create_form > div > div > div:nth-child(1) > div:nth-child(2) > div > label')
                ->pause(2000)
                ->click('#menu_type_div > div > div')
                ->click('#menu_type_div > div > div > ul > li:nth-child(4)')
                ->click('#display_position_div > div > div')
                ->click('#display_position_div > div > div > ul > li:nth-child(3)')
                ->click('#create_btn')
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Created successfully!');
        });
    }

    public function test_for_add_link_to_normal_menu(){
        $this->test_for_create_normal_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingTwo > h5 > button', 'Add Links')
            ->click('#headingTwo > h5')
            ->waitFor('#title', 4)
            ->type('#title', $this->faker->name)
            ->type('#link', $this->faker->slug)
            ->click('#add_link_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }

    public function test_for_edit_link_to_normal_menu(){
        $this->test_for_add_link_to_normal_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.btn_zindex.panel-title',4)
                ->click('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.btn_zindex.panel-title')
                ->waitFor('#elementEditForm > div > div:nth-child(3) > div > input', 4)
                ->type('#elementEditForm > div > div:nth-child(3) > div > input', $this->faker->title)
                ->type('#elementEditForm > div > div:nth-child(4) > div > input', $this->faker->slug)
                ->click('#elementEditForm > div > div:nth-child(5) > div > ul > li:nth-child(1) > label > span')
                ->click('#elementEditForm > div > div:nth-child(6) > div > ul > li > label > span')
                ->click('#elementEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(5000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_delete_element_to_normal_menu(){
        $this->test_for_add_link_to_normal_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.element_delete_btn.btn_zindex',4)
                ->click('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.element_delete_btn.btn_zindex')
                ->whenAvailable('#element_delete_form', function($modal){
                    $modal->click('#elementDeleteBtn');
                })
                ->pause(6000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');

        });
    }

    public function test_for_add_category_to_normal_menu(){
        $this->test_for_create_normal_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingTwo > h5 > button', 'Add Links')
            ->click('#headingThree > h5')
            ->waitFor('#collapseThree > div > div > div:nth-child(1) > div > div', 4)
            ->click('#collapseThree > div > div > div:nth-child(1) > div > div')
            ->click('#collapseThree > div > div > div:nth-child(1) > div > div > ul > li:nth-child(1)')
            ->click('#collapseThree > div > div > div:nth-child(1) > div > div')
            ->click('#collapseThree > div > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
            ->click('#add_category_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }

    public function test_for_edit_category_to_normal_menu(){
        $this->test_for_add_category_to_normal_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.btn_zindex.panel-title',4)
                ->click('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.btn_zindex.panel-title')
                ->waitFor('#elementEditForm > div > div:nth-child(3) > div > input', 4)
                ->type('#elementEditForm > div > div:nth-child(3) > div > input', $this->faker->title)
                ->click('#elementEditForm > div > div:nth-child(4) > div > div')
                ->click('#elementEditForm > div > div:nth-child(4) > div > div > ul > li:nth-child(4)')
                ->click('#elementEditForm > div > div:nth-child(5) > div > ul > li:nth-child(1) > label > span')
                ->click('#elementEditForm > div > div:nth-child(6) > div > ul > li > label > span')
                ->click('#elementEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(5000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }


    public function test_for_add_page_to_normal_menu(){
        $this->test_for_create_normal_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingTwo > h5 > button', 'Add Links')
            ->click('#headingPages > h5')
            ->waitFor('#pages > div > div > div:nth-child(1) > div > div', 4)
            ->click('#pages > div > div > div:nth-child(1) > div > div')
            ->click('#pages > div > div > div:nth-child(1) > div > div > ul > li:nth-child(1)')
            ->click('#pages > div > div > div:nth-child(1) > div > div')
            ->click('#pages > div > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
            ->click('#add_page_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }


    public function test_for_edit_page_to_normal_menu(){
        $this->test_for_add_page_to_normal_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.btn_zindex.panel-title',4)
                ->click('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.btn_zindex.panel-title')
                ->waitFor('#elementEditForm > div > div:nth-child(3) > div > input', 4)
                ->type('#elementEditForm > div > div:nth-child(3) > div > input', $this->faker->title)
                ->click('#elementEditForm > div > div:nth-child(4) > div > div')
                ->click('#elementEditForm > div > div:nth-child(4) > div > div > ul > li:nth-child(3)')
                ->click('#elementEditForm > div > div:nth-child(5) > div > ul > li:nth-child(1) > label > span')
                ->click('#elementEditForm > div > div:nth-child(6) > div > ul > li > label > span')
                ->click('#elementEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(5000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_add_product_to_normal_menu(){
        $this->test_for_create_normal_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingTwo > h5 > button', 'Add Links')
            ->click('#headingProduct > h5')
            ->waitFor('#products > div > div > div:nth-child(1) > div > div', 4)
            ->click('#products > div > div > div:nth-child(1) > div > div')
            ->click('#products > div > div > div:nth-child(1) > div > div > ul > li:nth-child(1)')
            ->click('#products > div > div > div:nth-child(1) > div > div')
            ->click('#products > div > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
            ->click('#add_product_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }

    public function test_for_edit_product_to_normal_menu(){
        $this->test_for_add_product_to_normal_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.btn_zindex.panel-title',4)
                ->click('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.btn_zindex.panel-title')
                ->waitFor('#elementEditForm > div > div:nth-child(3) > div > input', 4)
                ->type('#elementEditForm > div > div:nth-child(3) > div > input', $this->faker->title)
                ->click('#elementEditForm > div > div:nth-child(4) > div > div')
                ->click('#elementEditForm > div > div:nth-child(4) > div > div > ul > li:nth-child(3)')
                ->click('#elementEditForm > div > div:nth-child(5) > div > ul > li:nth-child(1) > label > span')
                ->click('#elementEditForm > div > div:nth-child(6) > div > ul > li > label > span')
                ->click('#elementEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(5000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_add_brand_to_normal_menu(){
        $this->test_for_create_normal_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingTwo > h5 > button', 'Add Links')
            ->click('#headingBrand > h5')
            ->waitFor('#brands > div > div > div:nth-child(1) > div > div', 4)
            ->click('#brands > div > div > div:nth-child(1) > div > div')
            ->click('#brands > div > div > div:nth-child(1) > div > div > ul > li:nth-child(1)')
            ->click('#brands > div > div > div:nth-child(1) > div > div')
            ->click('#brands > div > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
            ->click('#add_brand_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }


    public function test_for_edit_brand_to_normal_menu(){
        $this->test_for_add_brand_to_normal_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.btn_zindex.panel-title',4)
                ->click('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.btn_zindex.panel-title')
                ->waitFor('#elementEditForm > div > div:nth-child(3) > div > input', 4)
                ->type('#elementEditForm > div > div:nth-child(3) > div > input', $this->faker->title)
                ->click('#elementEditForm > div > div:nth-child(4) > div > div')
                ->click('#elementEditForm > div > div:nth-child(4) > div > div > ul > li:nth-child(3)')
                ->click('#elementEditForm > div > div:nth-child(5) > div > ul > li:nth-child(1) > label > span')
                ->click('#elementEditForm > div > div:nth-child(6) > div > ul > li > label > span')
                ->click('#elementEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(5000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_add_tag_to_normal_menu(){
        $this->test_for_create_normal_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingTwo > h5 > button', 'Add Links')
            ->click('#headingTag > h5')
            ->waitFor('#tags > div > div > div:nth-child(1) > div > div', 4)
            ->click('#tags > div > div > div:nth-child(1) > div > div')
            ->click('#tags > div > div > div:nth-child(1) > div > div > ul > li:nth-child(1)')
            ->click('#tags > div > div > div:nth-child(1) > div > div')
            ->click('#tags > div > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
            ->click('#add_tag_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }

    public function test_for_edit_tag_to_normal_menu(){
        $this->test_for_add_tag_to_normal_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MenuElement::where('menu_id', $menu->id)->first();
            $browser->waitFor('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.btn_zindex.panel-title',4)
                ->click('#heading_'.$element->id.' > div.pull-right.btn_div > a.primary-btn.btn_zindex.panel-title')
                ->waitFor('#elementEditForm > div > div:nth-child(3) > div > input', 4)
                ->click('#elementEditForm > div > div:nth-child(4) > div > div')
                ->click('#elementEditForm > div > div:nth-child(4) > div > div > ul > li:nth-child(3)')
                ->click('#elementEditForm > div > div:nth-child(5) > div > ul > li:nth-child(1) > label > span')
                ->click('#elementEditForm > div > div:nth-child(6) > div > ul > li > label > span')
                ->click('#elementEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(5000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_create_multimega_menu(){
        $this->test_for_visit_menu_index();
        $this->browse(function (Browser $browser) {
            $browser->type('#name', $this->faker->name)
                ->type('#icon','ti-star')
                ->click('#create_form > div > div > div:nth-child(1) > div:nth-child(2) > div > label')
                ->pause(2000)
                ->click('#menu_type_div > div > div')
                ->click('#menu_type_div > div > div > ul > li:nth-child(3)')
                ->click('#display_position_div > div > div')
                ->click('#display_position_div > div > div > ul > li:nth-child(4)')
                ->click('#create_btn')
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Created successfully!');
        });
    }

    public function test_for_add_menu_to_multi_mega_menu(){
        $this->test_for_create_menu();
        $this->test_for_create_menu();
        $this->test_for_create_multimega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $browser->visit('/menu/setup/'.$menu->id)
            ->assertPathIs('/menu/setup/'.$menu->id)
            ->assertSeeIn('#headingMenu > h5 > button', 'Add Menu')
            ->click('#headingMenu > h5')
            ->waitFor('#menus > div > div > div:nth-child(1) > div > div', 4)
            ->click('#menus > div > div > div:nth-child(1) > div > div')
            ->click('#menus > div > div > div:nth-child(1) > div > div > ul > li:nth-child(1)')
            ->click('#menus > div > div > div:nth-child(1) > div > div')
            ->click('#menus > div > div > div:nth-child(1) > div > div > ul > li:nth-child(2)')
            ->click('#add_menu_btn')
            ->waitFor('.toast-message',30)
            ->assertSeeIn('.toast-message', 'Added successfully!');
        });
    }

    public function test_for_edit_menu_to_multi_mega_menu(){
        $this->test_for_add_menu_to_multi_mega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MultiMegaMenu::where('multi_mega_menu_id', $menu->id)->first();
            $browser->waitFor('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title',4)
                ->click('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.mr-10.primary-btn.panel-title')
                ->waitFor('#menuEditForm > div > div:nth-child(2) > div > input', 4)
                ->type('#menuEditForm > div > div:nth-child(2) > div > input', $this->faker->title)
                ->click('#menuEditForm > div > div:nth-child(3) > div > div')
                ->click('#menuEditForm > div > div:nth-child(3) > div > div > ul > li:nth-child(2)')
                ->click('#menuEditForm > div > div.col-xl-12 > div > ul > li > label > span')
                ->click('#menuEditForm > div > div.col-lg-12.text-center > div > button')
                ->pause(5000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Updated successfully!');

        });
    }

    public function test_for_delete_menu_to_multi_mega_menu(){
        $this->test_for_add_menu_to_multi_mega_menu();
        $this->browse(function (Browser $browser) {
            $menu = Menu::latest()->first();
            $element = MultiMegaMenu::where('multi_mega_menu_id', $menu->id)->first();
            $browser->waitFor('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.primary-btn.menu_delete_btn',4)
                ->click('#accordion_'.$element->id.' > div.card-header.card_header_element > div > a.d-inline.primary-btn.menu_delete_btn')
                ->whenAvailable('#menu_delete_form', function($modal){
                    $modal->click('#menuDeleteBtn');
                })
                ->pause(6000)
                ->waitFor('.toast-message',30)
                ->assertSeeIn('.toast-message', 'Deleted successfully!');

        });
    }


}
