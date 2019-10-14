    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.6.3/jquery-ui-timepicker-addon.min.js"></script>

    <script>

            $('#datepicker').datetimepicker({
                altField: "#datepickerAlt",
                altFieldTimeOnly: false,
                altFormat: "yy-mm-dd",
                controlType: 'select',
                oneLine: true,
                altTimeFormat: "H:m",
            });
      </script>
