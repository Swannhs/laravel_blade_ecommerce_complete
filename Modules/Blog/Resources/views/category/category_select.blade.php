<option value="{{ $child_account->id }}">
    @for ($i = 1; $i < $child_account->level; $i++)
        <strong>-</strong>
    @endfor
    <strong>-></strong> {{ $child_account->name }}


</option>>



@if ($child_account->categories)
    @foreach ($child_account->categories as $child_account)
        @include('blog::category.category_select', ['child_account' => $child_account])
    @endforeach
@endif
