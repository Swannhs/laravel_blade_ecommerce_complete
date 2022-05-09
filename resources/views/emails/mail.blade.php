
@if(isset($body))
@php echo $body; @endphp
@elseif(isset($content))
@php echo $content; @endphp
@endif