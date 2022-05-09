<?php

namespace Modules\Menu\Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\URL;
use Modules\Menu\Entities\Menu;
use Modules\Menu\Entities\MenuColumn;
use Modules\Menu\Entities\MenuElement;
use Modules\Menu\Entities\MultiMegaMenu;
use Modules\Product\Entities\Brand;

class MenuPageTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_for_add_menu()
    {
        $this->actingAs(User::find(1));

        $this->post('/menu/store',[
            'name' => 'test name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'test_menu',
            'menu_position' => 'test',
            'status' => 0
        ])->assertStatus(200);
    }

    public function test_for_delete_menu()
    {
        $this->actingAs(User::find(1));

        $this->post('/menu/store',[
            'name' => 'test name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'test_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);

        $menu = Menu::orderBy('id', 'desc')->first();
        $this->post('/menu/delete',[
            'id' => $menu->id
        ])->assertStatus(200);
    }

    public function test_for_status_change_menu()
    {
        $this->actingAs(User::find(1));

        $this->post('/menu/store',[
            'name' => 'test name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'test_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);

        $menu = Menu::orderBy('id', 'desc')->first();
        $this->post('/menu/manage/status',[
            'id' => $menu->id,
            'status' => 1
        ])->assertStatus(200);
    }

   
    public function test_for_update_menu()
    {
        $this->actingAs(User::find(1));

        $this->post('/menu/store',[
            'name' => 'test name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'test_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);
        
        $menu = Menu::orderBy('id', 'desc')->first();

        $this->post('/menu/update',[
            'name' => 'test name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'test_menu',
            'menu_position' => 'test',
            'status' => 0,
            'id' => $menu->id
        ])->assertStatus(200);

    }

    public function test_for_add_menu_to_multi_mega_menu()
    {
        $this->actingAs(User::find(1));
        
        $multi_mega_menu = Menu::create([
            'name' => 'test name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'multi_mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);

        $mega_menu = Menu::create([
            'name' => 'test mega name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);
        $this->post('/menu/setup/add-menu',[
            'menu_id' => $multi_mega_menu->id,
            'menus' => [$mega_menu->id]
        ])->assertStatus(200);

    }

    public function test_for_update_multi_mega_menu_item()
    {
        $this->actingAs(User::find(1));
        
        $multi_mega_menu = Menu::create([
            'name' => 'test name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'multi_mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);

        $mega_menu = Menu::create([
            'name' => 'test mega name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);
        
        $menu_item = MultiMegaMenu::create([
            'title' => 'test menu',
            'multi_mega_menu_id' => $multi_mega_menu->id,
            'menu_id' => $mega_menu->id
        ]);
        
        $this->post('/menu/setup/menu-update',[
            'title' => 'test menu 1',
            'menu' => $mega_menu->id,
            'id' => $menu_item->id,
            'is_newtab' => 1,
            'menu_id' => $mega_menu->id

        ])->assertStatus(200);


    }

    public function test_for_delete_multi_mega_menu_item()
    {
        $this->actingAs(User::find(1));
        
        $multi_mega_menu = Menu::create([
            'name' => 'test name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'multi_mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);

        $mega_menu = Menu::create([
            'name' => 'test mega name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);
        
        $menu_item = MultiMegaMenu::create([
            'title' => 'test menu',
            'multi_mega_menu_id' => $multi_mega_menu->id,
            'menu_id' => $mega_menu->id
        ]);

        $this->post('/menu/setup/menu-delete',[
            'id' => $menu_item->id,
            'menu_id' => $multi_mega_menu->id
        ])->assertSee('Menu List');


    }
    
    public function test_for_add_column_in_mega_menu()
    {
        $this->actingAs(User::find(1));

        $mega_menu = Menu::create([
            'name' => 'test mega name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);
        
        $this->post('/menu/setup/add-column',[
            'column' => 'test column 1',
            'size' => '1/3',
            'id' => $mega_menu->id

        ])->assertStatus(200);
    }

    public function test_for_update_column_in_mega_menu()
    {
        $this->actingAs(User::find(1));

        $mega_menu = Menu::create([
            'name' => 'test mega name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);

        $column = MenuColumn::create([
            'column' => 'test column',
            'size' => '1/3',
            'menu_id' => $mega_menu->id,
            'position' => 987678
        ]);
        
        $this->post('/menu/setup/column-update',[
            'column' => 'test column 1',
            'size' => '1/3',
            'column_id' => $column->id,
            'menu_id' => $mega_menu->id

        ])->assertStatus(200);
    }

    public function test_for_add_element_in_mega_menu()
    {
        $this->actingAs(User::find(1));

        $mega_menu = Menu::create([
            'name' => 'test mega name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);
        $brand = Brand::create([
            'name' => 'test_brand4556546756',
            'status' => 0
        ]);
        
        $this->post('/menu/setup/add-element',[
            'element_id' => [$brand->id],
            'menu_id' => $mega_menu->id

        ])->assertStatus(200);
    }

    public function test_for_update_element_in_mega_menu()
    {
        $this->actingAs(User::find(1));

        $mega_menu = Menu::create([
            'name' => 'test mega name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);
        $brand = Brand::create([
            'name' => 'test_brand4556546756',
            'status' => 0
        ]);

        $element = MenuElement::create([
            'title' => $brand->name,
            'menu_id' => $mega_menu->id,
            'type' => 'brand',
            'element_id' => $brand->id,
            'position' => 387437
        ]);
        
        $this->post('/menu/setup/element-update',[
            'menu_id' => $mega_menu->id,
            'type' => 'brand',
            'brand' => $brand->id,
            'title' => 'test title',
            'id' => $element->id,

        ])->assertStatus(200);
    }

    public function test_for_delete_column_from_mega_menu()
    {
        $this->actingAs(User::find(1));

        $mega_menu = Menu::create([
            'name' => 'test mega name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);

        $column = MenuColumn::create([
            'column' => 'test column',
            'size' => '1/3',
            'menu_id' => $mega_menu->id,
            'position' => 987678
        ]);
        
        $this->post('/menu/setup/column-delete',[
            'id' => $column->id,
            'menu_id' => $mega_menu->id

        ])->assertStatus(200);
    }

    public function test_for_delete_element_from_mega_menu()
    {
        $this->actingAs(User::find(1));

        $mega_menu = Menu::create([
            'name' => 'test mega name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);
        $brand = Brand::create([
            'name' => 'test_brand4556546756',
            'status' => 0
        ]);

        $element = MenuElement::create([
            'title' => $brand->name,
            'menu_id' => $mega_menu->id,
            'type' => 'brand',
            'element_id' => $brand->id,
            'position' => 387437
        ]);
        
        $this->post('/menu/setup/element-delete',[
            'id' => $element->id,
            'menu_id' => $mega_menu->id

        ])->assertStatus(200);
    }

    public function test_for_add_to_column_in_mega_menu()
    {
        $this->actingAs(User::find(1));

        $mega_menu = Menu::create([
            'name' => 'test mega name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);

        $column = MenuColumn::create([
            'column' => 'test column',
            'size' => '1/3',
            'menu_id' => $mega_menu->id,
            'position' => 987678
        ]);

        $brand = Brand::create([
            'name' => 'test_brand4556546756',
            'status' => 0
        ]);
        
        $element = MenuElement::create([
            'title' => $brand->name,
            'menu_id' => $mega_menu->id,
            'type' => 'brand',
            'element_id' => $brand->id,
            'position' => 387437
        ]);

        $this->post('/menu/setup/add-to-column',[
            'element' => $element->id,
            'column_id' => $column->id

        ])->assertStatus(200);

    }
    public function test_for_remove_from_column_in_mega_menu()
    {
        $this->actingAs(User::find(1));

        $mega_menu = Menu::create([
            'name' => 'test mega name',
            'slug' => 'slug',
            'icon' => 'ti-plus',
            'menu_type' => 'mega_menu',
            'menu_position' => 'test',
            'status' => 0
        ]);

        $column = MenuColumn::create([
            'column' => 'test column',
            'size' => '1/3',
            'menu_id' => $mega_menu->id,
            'position' => 987678
        ]);

        $brand = Brand::create([
            'name' => 'test_brand4556546756',
            'status' => 0
        ]);
        
        $element = MenuElement::create([
            'title' => $brand->name,
            'menu_id' => $mega_menu->id,
            'type' => 'brand',
            'element_id' => $brand->id,
            'position' => 387437
        ]);

        $this->post('/menu/setup/remove-from-column',[
            'element' => $element->id,
            'column_id' => $column->id

        ])->assertStatus(200);

    }

}
