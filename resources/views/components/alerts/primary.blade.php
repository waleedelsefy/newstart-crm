@props(['message', 'if' => true, 'auto_close' => false, 'delay' => 5000])

<x-alerts.base :message="$message" {{ $attributes->class(['alert-primary']) }} :if="$if" :auto_close="$auto_close"
    :delay="$delay" />
