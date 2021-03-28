@extends('layouts.app')
@section('content')

    <div class="p-4 ml-3"  style="margin-left: 20px">
        <div class="row">
            <div class="col-md-5 mt-2 row">
                <div style="display: flex">
                    <input type="file" name="select_file" id="select_file" style="display: none" onchange="uploadExcelFile()"/>
                </div>
                <div>
                    <a class="btn btn-primary" style="color: white" onclick="document.getElementById('select_file').click()">Upload Excel File and Send SMS</a>
                </div>
            </div>
        </div>
    </div>

@endsection
<script>
    // setTimeout(function () {
    //     $('#customer-table').DataTable();
    // },1000);


    function uploadExcelFile() {
        let formData = new FormData();
        formData.append("select_file", document.getElementById('select_file').files[0]);
        formData.append("_token", "{{ csrf_token() }}");
        $.ajax
        ({
            type: 'POST',
            beforeSend: function(){

            },
            complete: function(){

            },
            url: `{{env('APP_URL')}}/import_excel/import`,
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (data) {
                data = JSON.parse(data);
                if (data.status === true) {
                    swal.fire({
                        "title": "",
                        "text": "Excel Imported Successfully!",
                        "type": "success",
                        "showConfirmButton": true,
                        "onClose": function (e) {
                            window.location.reload();
                        }
                    })
                } else {
                    alert(data.message);
                }
            },

            error: function (data) {
                swal.fire({
                    "title": "",
                    "text": "Maximum execution reached on server. Please try again with other contacts",
                    "type": "success",
                    "showConfirmButton": true,
                    "onClose": function (e) {
                        window.location.reload();
                    }
                })
                console.log("data", data);
            }
        });
    }
</script>
