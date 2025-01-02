 $(document).ready(function () {
        $('#penilaianTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: '/dev/corpu2/simapeka/public/get-diklat-data',
                type: 'GET',
                dataType: 'json',
                data: function (d) {
                    d.page = Math.ceil(d.start / d.length) + 1; // calculate the current page number
                    d.length = d.length; // send the desired page length to the server
                },
                dataSrc: function (json) {
                    // Add any additional data manipulation here if needed
                    return json.data;
                }
            },
            columns: [
                {data: 'nip'},
                {data: 'nama'},
                {data: 'jabatan'},
                {data: 'aksi', orderable: false, searchable: false}
            ],
            lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]]
        });
    });
