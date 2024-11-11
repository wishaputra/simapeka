$(document).ready(function(){$("#myTable").DataTable({processing:!0,serverSide:!0,ajax:{url:"/data_bangkom",type:"GET"},columns:[{data:"DT_RowIndex",name:"DT_RowIndex",orderable:!1,searchable:!1},{data:"nama_diklat",name:"nama_diklat"},{data:"perangkatdaerah.nama_perangkat_daerah",name:"perangkatdaerah.nama_perangkat_daerah",defaultContent:"-"},{data:"unit_kerja",name:"unit_kerja",defaultContent:"-"},{data:"id",render:function(t,e,a){return`
                        <button class="btn btn-warning btn-sm edit-btn" 
                                data-id="${t}" 
                                data-nama_diklat="${a.nama_diklat}"
                                data-unit_kerja="${a.unit_kerja}" 
                                data-uptd="${a.uptd}" 
                                data-toggle="modal" 
                                data-target="#editModal">
                            <i class="fas fa-pen"></i>
                        </button>
                        <form action="/data_bangkom/${t}" method="POST" style="display:inline;" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger btn-sm delete-btn">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    `},orderable:!1,searchable:!1}]})});
