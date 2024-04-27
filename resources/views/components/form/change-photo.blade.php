@props(['name' => '', 'src', 'alt' => ''])

@push('styles')
    <style>
        .photo-field-container {
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
        }

        .photo-field-container:hover .photo-overlay {
            opacity: 1;
        }

        .photo-field-container,
        .photo-field-container img,
        .photo-field-container .photo-overlay {
            width: 200px;
            height: 200px;
            border-radius: 50%;
            cursor: pointer;
        }

        .photo-field-container img {
            object-fit: cover;
        }

        .photo-field-container .photo-overlay {
            display: block;
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #fff;
            opacity: 0;
            transition: .5s ease-in-out;
        }
    </style>
@endpush

<x-alerts.success if="{{ session()->get('status') == 'profile-photo-updated' }}"
    message="{{ __('The profile photo has been updated.') }}" auto_close="profile-photo-updated" delay="10000" />


<div class="row">
    <div class="col-4">
        <div class="photo-field-container">
            <input type="file" name="{{ $name }}" id="photo-field" class="d-none">
            <label for="photo-field">
                <img src="{{ $src }}" alt="{{ $alt }}" id="photo-preview">
                <span class="photo-overlay">
                    <i class="feather icon-camera"></i>
                </span>
            </label>
        </div>

        @error('photo')
            <small class="text-danger d-block">{{ $message }}</small>
        @enderror
    </div>
</div>

<x-buttons.success text="{{ __('Update') }}" />

<x-buttons.light text="{{ __('Reset') }}" style="display: none" id="reset-photo-field" type="button" />


@push('scripts')
    <script>
        $(document).ready(function() {
            $('#photo-field').on('change', function(e) {
                const photoPreview = $("#photo-preview")[0];
                const defaultPhotoUrl = photoPreview.src;

                const photo = e.target.files[0];


                if (photo.type.startsWith('image')) {
                    const reader = new FileReader();
                    reader.readAsDataURL(photo);
                    reader.onload = function(e) {
                        const url = e.target.result;
                        photoPreview.src = url;
                    }

                    $('#reset-photo-field').css('display', 'inline-block');

                    $('#reset-photo-field').click(function() {
                        $('#photo-field').val('');
                        photoPreview.src = defaultPhotoUrl;
                        $('#reset-photo-field').css('display', 'none');
                    });
                } else {
                    photoPreview.src = defaultPhotoUrl;
                    $('#photo-field').val('');
                }
            })
        });
    </script>
@endpush
