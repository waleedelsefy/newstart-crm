@props(['notifications', 'fullDescription' => false])


<li class="scrollable-container media-list">

    @forelse ($notifications as $notification)
        <a class="d-flex justify-content-between" href="{{ route('notifications.markAsRead', $notification) }}">
            <div class="media d-flex align-items-start"
                style="{{ $notification->read_at == null ? 'background: #e7e7e7' : '' }}">
                <div class="media-left">
                    @if ($notification->image)
                        <img class="notification-image" src="{{ $notification->image }}" alt="{{ $notification->title }}">
                    @elseif ($notification->icon)
                        <i class="{{ $notification->icon }} font-medium-5 {{ $notification->color }}">
                        </i>
                    @endif
                </div>
                <div class="media-body">
                    <h6 class="{{ $notification->color }} media-heading">
                        {{ $notification->title }}
                    </h6>

                    @if ($notification->description)
                        <small class="notification-text dark">
                            @if ($fullDescription)
                                {!! $notification->description !!}
                            @else
                                {{ $notification->shortDescription }}
                            @endif
                        </small>
                    @endif

                </div>
                <small>
                    <time class="media-meta" datetime="2015-06-11T18:29:20+08:00">
                        {{ $notification->created_at->diffForHumans() }}
                    </time>
                </small>
            </div>
        </a>
    @empty
        <a class="d-flex justify-content-between" href="javascript:void(0)">
            <div class="media d-flex align-items-center">
                <div class="media-body text-center">
                    <small class="notification-text">{{ __('There\'s no notifications') }}</small>
                </div>
            </div>
        </a>
    @endforelse
</li>
