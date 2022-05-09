<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="{{url('/')}}">
    @isset($products)
    @foreach ($products as $product)
    <url>
        <loc>{{route('frontend.item.show',$product->slug)}}</loc>
        <lastmod>{{ $product->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    @endisset


    @isset($pages)
    @foreach ($pages as $page)
    <url>
        <loc>{{url('/'.$page->slug)}}</loc>
        <lastmod>{{ @$page->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    @endisset
    @isset($blogs)
    @foreach ($blogs as $blog)
    <url>
        <loc>{{url('/'.$blog->slug)}}</loc>
        <lastmod>{{ @$blog->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    @endisset
    @isset($categories)
    @foreach ($categories as $category)
    <url>
        <loc>{{route('frontend.category-product',['slug' => @$category->slug, 'item' =>'category'])}}</loc>
        <lastmod>{{ @$category->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    @endisset
    @isset($brands)
    @foreach ($brands as $brand)
    <url>
        <loc>{{route('frontend.category-product',['slug' => $brand->slug, 'item' =>'brand'])}}</loc>
        <lastmod>{{ @$brand->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    @endisset
    @isset($tags)
    @foreach ($tags as $tag)
    <url>
        <loc>{{route('frontend.category-product',['slug' => $tag->tag->name, 'item' =>'tag'])}}</loc>
        <lastmod>{{ @$tag->tag->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endforeach
    @endisset
    @isset($flash_deal)
    <url>
        <loc>{{url('/flash-deal'.'/'.$flash_deal->slug)}}</loc>
        <lastmod>{{ @$flash_deal->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endisset
    @isset($new_user_zone)
    <url>
        <loc>{{url('new-user-zone/'.$new_user_zone->slug)}}</loc>
        <lastmod>{{ @$new_user_zone->updated_at->tz('UTC')->toAtomString() }}</lastmod>
        <changefreq>weekly</changefreq>
        <priority>0.8</priority>
    </url>
    @endisset


</urlset>
