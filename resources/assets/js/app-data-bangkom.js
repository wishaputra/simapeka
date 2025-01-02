const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

$(document).ready(function() {
    $('#myTable').DataTable({
    processing: true,
    serverSide: true,
    ajax: {
        url: '/dev/corpu2/simapeka/public/data_bangkom',
        type: 'GET',
        dataType: 'json' 
        
    }, 
    columns: [
        { 
            data: 'id', 
            render: function (data, type, row, meta) { 
                return meta.row + meta.settings._iDisplayStart + 1; 
            },
            searchable: false // Disable search on this if needed, otherwise omit
        },
        { 
            data: 'nama_diklat', 
            searchable: true // Make sure this is enabled for searching
        },
        { 
            data: 'unit_kerja',
            render: function(data, type, row) {
                return data ? data : '-'; // Handle case where there's no unit_kerja
            },
            searchable: true // Make sure this is searchable
        },
        { 
            data: 'uptd',
            render: function(data, type, row) {
                return data ? data : '-'; // Handle case where uptd might be null
            },
            searchable: true // Ensure this column is searchable
        },
        { 
            data: 'tahun',
            render: function(data, type, row) {
                return data ? data : '-'; // Handle case where uptd might be null
            },
            searchable: true // Ensure this column is searchable
        },
        {
            data: 'id',
            render: function(data, type, row) {
                return `
                    <form action="/dev/corpu2/simapeka/public/data_bangkom/${data}" method="POST" class="d-inline delete-form">
                        <input type="hidden" name="_method" value="DELETE">
                        <input type="hidden" name="_token" value="${csrfToken}">
                        <button type="button" class="btn btn-sm btn-danger delete-btn">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    <button type="button" class="btn btn-sm btn-primary edit-btn" data-id="${data}" data-nama_diklat="${row.nama_diklat}" data-unit_kerja="${row.unit_kerja}" data-uptd="${row.uptd}" data-tahun="${row.tahun}">
                        <i class="fas fa-edit"></i>
                    </button>
                `;
            },
            searchable: false
        }
        
    ]
});


// Edit User Modal
// $(document).on('click', '.editUserBtn', function() {
//     const userId = $(this).data('id');
//     $.get(`/dev/corpu2/simapeka/public/pegawai/${userId}`, function(data) {
//         $('#userId').val(data.id);
//         $('#nip').val(data.nip);
//         $('#nama').val(data.nama);
//         $('#jabatan').val(data.jabatan);
//         $('#unit_kerja').val(data.unit_kerja);
//         $('#uptd').val(data.uptd);
//         $('#userModalLabel').text('Edit User');
//         $('#userModal').modal('show');
//     });
// });

$(document).on('click', '.edit-btn', function() {
    const id = $(this).data('id');
    const namaDiklat = $(this).data('nama_diklat');
    const unitKerja = $(this).data('unit_kerja');
    const uptd = $(this).data('uptd');
    const tahun = $(this).data('tahun');

    // Populate modal fields
    $('#edit_id').val(id);
    $('#edit_nama_diklat').val(namaDiklat);
    $('#edit_unit_kerja').val(unitKerja);
    $('#edit_uptd').val(uptd);
    $('#edit_tahun').val(tahun);

    // Update form action
    $('#editForm').attr('action', `/dev/corpu2/simapeka/public/data_bangkom/${id}`);

    // Show modal
    $('#editModal').modal('show');
});

    
   
   

// Handle unit_kerja change in the edit form
// $('#editUnitKerja').change(function() {
//     var unitKerja = $(this).val();
//     var modal = $('#editModal');
    
//     // Fetch UPTD values based on the selected unit_kerja
//     $.ajax({
//         url: '/dev/corpu2/simapeka/public/getUptds',
//         type: 'GET',
//         data: { unit_kerja: unitKerja },
//         success: function(data) {
//             var uptdSelect = modal.find('#editUptd');
//             uptdSelect.empty();
//             uptdSelect.append('<option value="">-- Pilih Nama UPTD --</option>');
            
//             $.each(data, function(key, value) {
//                 uptdSelect.append('<option value="' + value.uptd + '">' + value.uptd + '</option>');
//             });
//         },
//         error: function() {
//             console.log('Error fetching UPTD data');
//             var uptdSelect = modal.find('#editUptd');
//             uptdSelect.empty();
//             uptdSelect.append('<option value="">-- Error fetching UPTD --</option>');
//         }
//     });
// });




    // Handle Delete Button Click
    $('#myTable').on('click', '.delete-btn', function(e) {
        e.preventDefault(); // Prevent the default form submission

        var form = $(this).closest('form'); // Get the closest form
        var row = $(this).closest('tr'); // Get the row of the table

        // Show confirmation dialog
        if (confirm('Are you sure you want to delete this item?')) {
            form.submit(); // Submit the form if confirmed
        }
    });
    
    $('#unit_kerja').on('change', function() {
    var unitKerja = $(this).val();
    
    if (unitKerja) {
        $.ajax({
            url: '/dev/corpu2/simapeka/public/getUptds', // Updated route to fetch UPTDs by unit_kerja
            type: 'GET',
            data: { unit_kerja: unitKerja },
            success: function(data) {
                $('#id_uptd').empty();
                $('#id_uptd').append('<option value="">-- Pilih Nama UPTD --</option>');
                
                // Populate the dropdown with `uptd` values
                $.each(data, function(key, value) {
                    $('#id_uptd').append('<option value="' + value.uptd + '">' + value.uptd + '</option>');
                });
            },
            error: function() {
                console.log('Error fetching UPTD data');
            }
        });
    } else {
        $('#id_uptd').empty();
        $('#id_uptd').append('<option value="">-- Pilih Nama UPTD --</option>');
    }
});

});