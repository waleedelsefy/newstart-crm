@extends('layouts.app')

@section('title', __('Leads List'))

@section('breadcrumb')
    @parent

    <li class="breadcrumb-item active">
        @yield('title', config('app.name'))
    </li>
@endsection

@push('styles')
    <style>
        .tbl-container {
            max-width: fit-content;
            max-height: fit-content;
        }

        .tbl-fixed {
            overflow-x: scroll;
            overflow-y: scroll;
            height: fit-content;
            max-height: 70vh;
        }

        table {
            min-width: max-content;
            border-collapse: separate;
        }

        table th {
            position: sticky;
            top: 0;
            background-color: #fff;
            z-index: 1;
        }
    </style>
@endpush


@section('content')

    <div class="card leads-table-container">
        <div class="card-body">
            <div class="errors">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="m-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            @include('pages.leads.partials._top-filters')



            <div class="tbl-container">
                <div class="tbl-fixed">


                    <table class="table">
                        @include('pages.leads.partials.table._thead')
                        @include('pages.leads.partials.table._tbody')
                    </table>

                </div>
            </div>
        </div>
    </div>


    <div class="bottom-actions mt-2">
        <div class="app-pagination">
            {{ $leads->links() }}
        </div>
    </div>
@endsection


@push('scripts')
    <script>
        // multiple
        var mySwiper4 = new Swiper('.swiper-leads-filter', {
            slidesPerView: 4,
            spaceBetween: 10,
            breakpoints: {
                640: {
                    slidesPerView: 1,
                },
                768: {
                    slidesPerView: 2,
                },
                1024: {
                    slidesPerView: 3,
                },
            },
        });
    </script>

    <script src="{{ asset('js/leads-multi-operations.js') }}"></script>

    <script>
        const assignToButtons = document.querySelectorAll('.assign-to');

        assignToButtons.forEach(button => {
            button.addEventListener('click', (e) => {
                $.ajax({
                    url: button.dataset.url,
                    method: "POST",
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    body: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(HTMLResponse) {
                        const modalArea = document.getElementById('modal-area');
                        modalArea.innerHTML = "";
                        modalArea.innerHTML = HTMLResponse;
                        $('#general-modal').modal('show');
                        $('#assignable_id').select2();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            })
        });
    </script>
@endpush



@push('scripts')
    <script>
        // width = 100vw - main-menu width
    </script>
@endpush
