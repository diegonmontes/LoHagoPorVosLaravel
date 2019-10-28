    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}"></script>
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
                dateFormat: "dd/mm/yy",
                timeFormat: "HH:mm",
                minDate: 0
            });

            
      </script>
    <script>
        $(document).ready(function(){
            var valorInicial = $('select#idProvincia').val();
            cargarLocalidades(valorInicial);
            
            $("#idProvincia").change(function(){
                var idProvincia = $(this).val();
                cargarLocalidades(idProvincia);
            });
            
            $('#borrarCampos').click(function() {
                $('input[type="text"]').val('');
                $('select[name="idProvincia"]').val('20');
                cargarLocalidades(20);
                $('input[type=checkbox]').prop('checked',false);
            });

            
        });
    </script>

