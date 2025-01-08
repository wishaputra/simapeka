$(document).ready(function(){const i=$("#courseTable").DataTable({processing:!0,serverSide:!0,ajax:"/dev/corpu2/simapeka/public/courses/data",columns:[{data:"DT_RowIndex",name:"DT_RowIndex",orderable:!1,searchable:!1},{data:"thumbnail",name:"thumbnail",render:e=>`<img src="${e}" alt="Thumbnail" style="width: 50px;">`},{data:"nama_diklat",name:"nama_diklat"},{data:"title",name:"title"},{data:"description",name:"description"},{data:null,name:"time_period",render:e=>`
                  <span>${a(e.start_date)} - ${a(e.end_date)}</span>
              `},{data:null,name:"check_in_time",render:e=>e.check_in_start&&e.check_in_end?`<span>${a(e.check_in_start)} - ${a(e.check_in_end)}</span>`:"<span>Not Set</span>"},{data:"material",name:"material",render:e=>e?`
                          <a href="${a(e)}" target="_blank" class="btn btn-sm btn-primary" title="Download Material">
                            <i class="fas fa-file-powerpoint"></i> Download
                          </a>
                      `:"<span>No Material</span>",orderable:!1,searchable:!1},{data:null,render:function(e){return`
                      <button class="btn btn-sm btn-warning edit-course"
                          data-id="${a(e.id)}"
                          data-nama_diklat="${a(e.nama_diklat)}"
                          data-title="${a(e.title)}"
                          data-description="${a(e.description)}"
                          data-thumbnail="${a(e.thumbnail)}"
                          data-material="${a(e.material)}"
                          data-start_date="${a(e.start_date)}"
                          data-end_date="${a(e.end_date)}"
                          data-check_in_start="${a(e.check_in_start)}"
                          data-check_in_end="${a(e.check_in_end)}"
                          title="Edit Course">
                          <i class="fas fa-edit"></i>
                      </button>
                      <button class="btn btn-sm btn-danger delete-course"
                          data-id="${a(e.id)}"
                          title="Delete Course">
                          <i class="fas fa-trash"></i>
                      </button>
                      <a href="/dev/corpu2/simapeka/public/courses/${e.id}/exams"
                          class="btn btn-sm btn-secondary manage-exams"
                          title="Manage Exams">
                          <i class="fas fa-book"></i> Exams
                      </a>
                      <a href="/dev/corpu2/simapeka/public/courses/${e.id}/attendance"
                          class="btn btn-sm btn-info manage-attendance"
                          title="View Attendance">
                          <i class="fas fa-list-alt"></i> Attendance
                      </a>
                  `},orderable:!1,searchable:!1}]});function a(e){return String(e).replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/[\u00A0-\u9999<>&]/g,r=>`&#${r.charCodeAt(0)};`).replace(/'/g,"&#039;")}$("#addCourseForm").on("submit",function(e){e.preventDefault();const r=new FormData(this);$.ajax({url:"/dev/corpu2/simapeka/public/courses/store",type:"POST",data:r,processData:!1,contentType:!1,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){$("#addCourseModal").modal("hide"),i.ajax.reload(),toastr.success("Course added successfully!")},error:function(t){if(t.status===422){let s=t.responseJSON.errors,n="";for(let o in s)n+=`${s[o].join(", ")}
`;toastr.error(n,"Validation Error")}else toastr.error("Failed to add course.","Error")}})}),$("#courseTable").on("click",".edit-course",function(){const e=$(this).data("id"),r=$(this).data("nama_diklat"),t=$(this).data("title"),s=$(this).data("description"),n=$(this).data("thumbnail"),o=$(this).data("material"),c=$(this).data("start_date"),l=$(this).data("end_date"),d=$(this).data("check_in_start"),u=$(this).data("check_in_end");$("#editCourseId").val(e),$("#editCourseDiklat").val(r),$("#editCourseTitle").val(t),$("#editCourseDescription").val(s),$("#currentThumbnail").attr("src",n),$("#editCourseStartDate").val(c),$("#editCourseEndDate").val(l),$("#editCheckInStart").val(d),$("#editCheckInEnd").val(u),o?($("#currentMaterial").show(),$("#currentMaterialLink").attr("href",o).text("View Current Material")):$("#currentMaterial").hide(),$("#editCourseThumbnail").val(""),$("#editCourseMaterial").val(""),$("#editCourseModal").modal("show")}),$("#editCourseForm").on("submit",function(e){e.preventDefault();const r=new FormData(this);$.ajax({url:"/dev/corpu2/simapeka/public/course-management/update",type:"POST",data:r,processData:!1,contentType:!1,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(t){$("#editCourseModal").modal("hide"),i.ajax.reload(null,!1),toastr.success("Course updated successfully!")},error:function(t){if(t.status===422){let s=t.responseJSON.errors,n="";for(let o in s)n+=`${s[o].join(", ")}
`;toastr.error(n,"Validation Error")}else toastr.error("An error occurred. Please try again.","Error");console.log(t.responseText)}})}),$("#courseTable").on("click",".delete-course",function(){const e=$(this).data("id");confirm("Are you sure you want to delete this course?")&&$.ajax({url:`/dev/corpu2/simapeka/public/course-management/delete/${e}`,type:"DELETE",data:{_token:$('meta[name="csrf-token"]').attr("content")},success:function(r){i.ajax.reload(null,!1),toastr.success("Course deleted successfully!")},error:function(r){toastr.error("An error occurred. Please try again.","Error")}})})});
