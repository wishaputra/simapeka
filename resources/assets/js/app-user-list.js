$(document).ready(function () {
    const userTable = $('#userListTable').DataTable({
        processing: true,
        serverSide: true,
        responsive: true,
        ajax: {
            url: '/dev/corpu2/simapeka/public/pegawai/data',
            type: 'GET'
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
            { data: 'nip', name: 'nip' },
            { data: 'nama', name: 'nama' },
            { data: 'jabatan', name: 'jabatan' },
            { data: 'unit_kerja', name: 'unit_kerja' },
            { data: 'uptd', name: 'uptd' },
            {
                data: null,
                orderable: false,
                searchable: false,
                render: function (data, type, row) {
                    return `
                        <button class="btn btn-sm btn-warning edit-user" data-id="${row.id}" data-bs-toggle="modal" data-bs-target="#editUserModal">
                            Edit
                        </button>
                    `;
                }
            }
        ]
    });

    // Handle edit button click
    $('#userListTable').on('click', '.edit-user', function () {
        const userId = $(this).data('id');

        // Fetch user data
        $.ajax({
            url: `/dev/corpu2/simapeka/public/pegawai/${userId}/edit`, // Adjust based on your route
            type: 'GET',
            success: function (data) {
                // Populate read-only fields
                $('#editUserModal #editNip').val(data.nip);
                $('#editUserModal #editNama').val(data.nama);
                $('#editUserModal #editJabatan').val(data.jabatan);
                $('#editUserModal #editUnitKerja').val(data.unit_kerja);
                $('#editUserModal #editUPTD').val(data.uptd);

                $('#editUserModal').data('id', userId); // Attach user ID to modal

                // Populate role dropdown
                $.ajax({
                    url: `/dev/corpu2/simapeka/public/roles`, // Endpoint to fetch roles
                    type: 'GET',
                    success: function (roles) {
                        const roleDropdown = $('#editUserModal #editRole');
                        roleDropdown.empty(); // Clear existing options
                        roles.forEach(role => {
                            const isSelected = data.id_role === role.id ? 'selected' : '';
                            roleDropdown.append(`<option value="${role.id}">${role.role}</option>`);
                        });
                    },
                    error: function () {
                        alert('Failed to fetch roles.');
                    }
                });
            },
            error: function () {
                alert('Failed to fetch user data.');
            }
        });
    });

    $('#editUserForm').on('submit', function (e) {
        e.preventDefault();
    
        const userId = $('#editUserModal').data('id');
        const formData = {
            id_role: $('#editRole').val(),
            _token: $('meta[name="csrf-token"]').attr('content')
        };
    
        $.ajax({
            url: `/dev/corpu2/simapeka/public/pegawai/${userId}`,
            type: 'PUT',
            data: formData,
            success: function (response) {
                $('#editUserModal').modal('hide');
                userTable.ajax.reload(null, false); // Reload the DataTable without resetting the page
                alert('User role updated successfully!');
            },
            error: function () {
                alert('Failed to update user role.');
            }
        });
    });
    

    

    // // Save User
    // $('#userForm').on('submit', function(e) {
    //     e.preventDefault();
    //     const formData = $(this).serialize();
    //     const url = $('#userId').val() ? `/dev/corpu2/simapeka/public/pegawai/${$('#userId').val()}` : '/dev/corpu2/simapeka/public/pegawai/store';
    //     const method = $('#userId').val() ? 'PUT' : 'POST';

    //     $.ajax({
    //         url: url,
    //         type: method,
    //         data: formData,
    //         success: function() {
    //             $('#userModal').modal('hide');
    //             userTable.ajax.reload();
    //             alert('User saved successfully!');
    //         },
    //         error: function() {
    //             alert('Failed to save user.');
    //         }
    //     });
    // });

    // // Delete User
    // $(document).on('click', '.deleteUserBtn', function() {
    //     const userId = $(this).data('id');
    //     if (confirm('Are you sure you want to delete this user?')) {
    //         $.ajax({
    //             url: `/dev/corpu2/simapeka/public/pegawai/${userId}`,
    //             type: 'DELETE',
    //             success: function() {
    //                 userTable.ajax.reload();
    //                 alert('User deleted successfully!');
    //             },
    //             error: function() {
    //                 alert('Failed to delete user.');
    //             }
    //         });
    //     }
    // });
});