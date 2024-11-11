
$(document).ready(function() {
    $('#myTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: '/dev/corpu2/simapeka/public/data_bangkom', // Update the URL to include the correct path
            type: 'GET'
        },
        columns: [
            { 
                data: 'DT_RowIndex', 
                name: 'DT_RowIndex', 
                orderable: false, 
                searchable: false 
            },
            { data: 'nama_diklat', name: 'nama_diklat' },
            { 
                data: 'perangkatdaerah.nama_perangkat_daerah', // Ensure relation is correct
                name: 'perangkatdaerah.nama_perangkat_daerah',
                defaultContent: '-' 
            },
            { data: 'unit_kerja', name: 'unit_kerja', defaultContent: '-' },
            {
                data: 'id',
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-warning btn-sm edit-btn" 
                                data-id="${data}" 
                                data-nama_diklat="${row.nama_diklat}"
                                data-unit_kerja="${row.unit_kerja}" 
                                data-uptd="${row.uptd}" 
                                data-toggle="modal" 
                                data-target="#editModal">
                            <i class="fas fa-pen"></i>
                        </button>
                        <form action="/data_bangkom/${data}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    `;
                },
                orderable: false, 
                searchable: false
            }
        ]
    });
});