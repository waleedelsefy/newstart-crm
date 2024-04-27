<div class="modal-size-lg mr-1 mb-1 d-inline-block">
    <!-- Modal -->
    <div class="modal fade text-left" id="leads-{{ $lead->id }}-contacts-model" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel17" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel17">{{ $lead->name }}</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>{{ __('Phones List') }}</th>
                                    <th>{{ __('Actions') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($lead->phones as $phone)
                                    <tr>
                                        <td style="direction: ltr">{{ $phone->number }}</td>
                                        <td>
                                            <x-buttons.success
                                                href="https://api.whatsapp.com/send?phone={{ $phone->phoneWithoutPlus() }}"
                                                text="" icon="fa fa-whatsapp" class="btn-sm" target="blank" />

                                            <x-buttons.primary href="tel:{{ $phone->number }}" text=""
                                                icon="fa fa-phone" class="btn-sm" />
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2">{{ __('Unknown') }}</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    {{-- <button type="button" class="btn btn-primary" data-dismiss="modal">Accept</button> --}}
                </div>
            </div>
        </div>
    </div>
</div>
