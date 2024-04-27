    <script src="{{ asset('js/core/libraries/jquery.min.js') }}"></script>
    <!-- BEGIN: Vendor JS-->
    <script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
    <script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
    <!-- BEGIN Vendor JS-->

    <!-- BEGIN: Page Vendor JS-->
    <script src="{{ asset('vendors/js/ui/prism.min.js') }}"></script>
    <!-- END: Page Vendor JS-->

    <!-- BEGIN: Theme JS-->
    <script src="{{ asset('js/core/app-menu.js') }}"></script>
    <script src="{{ asset('js/core/app.js') }}"></script>
    <!-- END: Theme JS-->




    <script src="{{ asset('js/scripts/forms/select/form-select2.min.js') }}"></script>

    <script>
        const inputs = document.querySelectorAll('input');
        inputs.forEach(input => {
            input.autocomplete = 'off';
        });
    </script>
