<div {{ $attributes->merge(['class' => "alert alert-".$type]) }} role="alert">
    <h5>{{ $randomNumber }}</h5>
    <span class="badge badge-{{ $type }} {{ $textColor($type) }}">{{ $message }}</span>
    {{ $slot }}
</div>
