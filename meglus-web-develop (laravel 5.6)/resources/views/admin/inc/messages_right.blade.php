@if($errors && count($errors) > 0)
    <div class="error-mesages-right text-left">
    @if(is_array($errors))
        @foreach($errors as $error)
            <p>{{ $error }}</p>
        @endforeach
    @else
        @foreach($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    @endif

</div>
@endif
