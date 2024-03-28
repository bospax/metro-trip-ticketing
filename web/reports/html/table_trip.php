<script>
    if (!$.fn.DataTable.isDataTable('#table-account')) {
        $('#table-trips').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });
    }
</script>