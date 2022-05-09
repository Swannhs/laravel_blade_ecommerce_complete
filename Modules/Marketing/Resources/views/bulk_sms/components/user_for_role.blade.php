<option disabled>{{ __('common.select') }}</option>
@foreach($users as $key => $user)
<option selected value="{{$user->id}}">{{$user->username}}</option>
@endforeach