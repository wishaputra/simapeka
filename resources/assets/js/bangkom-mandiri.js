$(document).ready(function() {
    const table = $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        paging: false, // Disable paging to show all data
        ajax: {
            url: '/dev/corpu2/simapeka/public/bangkom_mandiri',
            type: 'GET',
            dataType: 'json'
        },
        columns: [
            {data: 'id', render: function (data, type, row, meta) { return meta.row + meta.settings._iDisplayStart + 1; }},
            {data: 'nama_diklat', name: 'nama_diklat'}, // Make sure 'nama_diklat' matches your table column
            {data: 'action', orderable: false, searchable: false}
        ]
    });

    let selectedCount = 0;

    function updateCheckboxes() {
        if (selectedCount >= 3) { // Limit to 3 checkboxes
            $('.diklat-checkbox').each(function() {
                if (!$(this).is(':checked')) {
                    $(this).prop('disabled', true);
                }
            });
        } else {
            $('.diklat-checkbox').prop('disabled', false);
        }
    }

    $('#myTable').on('change', '.diklat-checkbox', function() {
        let diklatId = $(this).val();
        let isChecked = $(this).is(':checked');

        if (isChecked && selectedCount >= 3) {
            alert('Hanya bisa Checklist 3 data!');
            $(this).prop('checked', false);
            return;
        }

        if (isChecked) {
            selectedCount++;
        } else {
            selectedCount--;
        }

        updateCheckboxes();

        $.ajax({
            url: '/diklat_mandiri/store',
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                diklat_id: diklatId,
                checked: isChecked ? 1 : 0
            },
            success: function(response) {
                console.log('Success:', response);
            },
            error: function(xhr) {
                console.error('Error:', xhr);
            }
        });
    });

    $('#myTable').on('draw.dt', function() {
        selectedCount = $('.diklat-checkbox:checked').length;
        updateCheckboxes();
    });

    // Initial call to set the correct checkbox state on page load
    updateCheckboxes();
});



