$(document).ready(function(){const o=$("#courseTable").DataTable({processing:!0,serverSide:!0,ajax:"/dev/corpu2/simapeka/public/courses/data",columns:[{data:"DT_RowIndex",name:"DT_RowIndex",orderable:!1,searchable:!1},{data:"thumbnail",name:"thumbnail",render:e=>`<img src="${e}" alt="Thumbnail" style="width: 50px;">`},{data:"title",name:"title"},{data:"description",name:"description"},{data:null,name:"time_period",render:e=>`
                    <span>${t(e.start_date)} - ${t(e.end_date)}</span>
                `},{data:null,name:"check_in_time",render:e=>e.check_in_start&&e.check_in_end?`<span>${t(e.check_in_start)} - ${t(e.check_in_end)}</span>`:"<span>Not Set</span>"},{data:"material",name:"material",render:e=>e?`
                            <a href="${t(e)}" target="_blank" class="btn btn-sm btn-primary" title="Download Material">
                                <i class="fas fa-file-powerpoint"></i> Download
                            </a>
                        `:"<span>No Material</span>",orderable:!1,searchable:!1},{data:null,render:function(e){return`
                        <button class="btn btn-sm btn-warning edit-course"
                            data-id="${t(e.id)}"
                            data-title="${t(e.title)}"
                            data-description="${t(e.description)}"
                            data-thumbnail="${t(e.thumbnail)}"
                            data-material="${t(e.material)}"
                            data-start_date="${t(e.start_date)}"
                            data-end_date="${t(e.end_date)}"
                            data-check_in_start="${t(e.check_in_start)}"
                            data-check_in_end="${t(e.check_in_end)}"
                            title="Edit Course">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger delete-course"
                            data-id="${t(e.id)}"
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
                    `},orderable:!1,searchable:!1}]});function t(e){return String(e).replace(/&/g,"&amp;").replace(/</g,"&lt;").replace(/>/g,"&gt;").replace(/"/g,"&quot;").replace(/[\u00A0-\u9999<>&]/g,a=>`&#${a.charCodeAt(0)};`).replace(/'/g,"&#039;")}$("#courseTable").on("click",".edit-course",function(){const e=$(this).data("id"),a=$(this).data("title"),r=$(this).data("description"),s=$(this).data("thumbnail"),n=$(this).data("material"),i=$(this).data("start_date"),c=$(this).data("end_date"),l=$(this).data("check_in_start"),d=$(this).data("check_in_end");$("#editCourseId").val(e),$("#editCourseTitle").val(a),$("#editCourseDescription").val(r),$("#currentThumbnail").attr("src",s),$("#editCourseStartDate").val(i),$("#editCourseEndDate").val(c),$("#editCheckInStart").val(l),$("#editCheckInEnd").val(d),n?($("#currentMaterial").show(),$("#currentMaterialLink").attr("href",n).text("View Current Material")):$("#currentMaterial").hide(),$("#editCourseModal").modal("show")}),$("#editCourseForm").on("submit",function(e){e.preventDefault();const a=new FormData(this);$.ajax({url:"/dev/corpu2/simapeka/public/course-management/update",type:"POST",data:a,processData:!1,contentType:!1,headers:{"X-CSRF-TOKEN":$('meta[name="csrf-token"]').attr("content")},success:function(r){$("#editCourseModal").modal("hide"),o.ajax.reload(null,!1),alert("Course updated successfully!")},error:function(r){if(r.status===422){let s=r.responseJSON.errors,n=`Validation errors:
`;for(let i in s)n+=`${i}: ${s[i].join(", ")}
`;alert(n)}else alert("An error occurred. Please try again.");console.log(r.responseText)}})}),$("#courseTable").on("click",".delete-course",function(){const e=$(this).data("id");confirm("Are you sure you want to delete this course?")&&$.ajax({url:`/dev/corpu2/simapeka/public/course-management/delete/${e}`,type:"DELETE",data:{_token:$('meta[name="csrf-token"]').attr("content")},success:function(a){o.ajax.reload(null,!1),alert("Course deleted successfully!")},error:function(a){alert("An error occurred. Please try again.")}})}),$("#addCourseForm").on("submit",function(e){e.preventDefault();const a=new FormData(this);a.append("_token",$('meta[name="csrf-token"]').attr("content")),$.ajax({url:"/dev/corpu2/simapeka/public/courses/store",type:"POST",data:a,processData:!1,contentType:!1,success:function(){$("#addCourseModal").modal("hide"),o.ajax.reload(),alert("Course added successfully!")},error:function(){alert("Failed to add course.")}})})});
