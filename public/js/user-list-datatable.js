// public/js/user-list-datatable.js

$(document).ready(function() {
    $('#userListTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: '/pegawai/data',
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nip', name: 'nip' },
            { data: 'nama', name: 'nama' },
            { data: 'jabatan', name: 'jabatan' },
            { data: 'uptd', name: 'uptd' },
            { data: 'unit_kerja', name: 'unit_kerja' },
        ]
    });
});
