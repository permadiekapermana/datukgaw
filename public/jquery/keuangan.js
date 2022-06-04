var globalPage = 1;

// function action button enter
function setupEventHandler(){
    $(".filter input").keypress(function(event){
        if(event.keyCode == 13){
            search(1)
        }
    });
    
    $(".modal input").keypress(function(event){
        if(event.keyCode == 13){
            save()
        }
    });
}

function buildTemplate(data, index, page, perPage){
    var rows = ""
    rows += "<tr class='template-data'>"
    rows += "<td style='text-align: center'>"
    rows += parseInt(perPage * (page-1)) + parseInt(index) + 1
    rows += "</td>"
    rows += "<td style='width:auto; white-space: normal; padding: 10px;'>"
    rows += data[index].date
    rows += "</td>"
    rows += "<td style='width:auto; white-space: normal; padding: 10px;'>"
    rows += data[index].jenis_dokumen
    rows += "</td>"
    rows += "<td style='width:auto; white-space: normal; padding: 10px;'>"
    rows += data[index].tipe_dokumen
    rows += "</td>"
    rows += "<td style='width:auto; white-space: normal; padding: 10px;'>"
    rows += data[index].nama_dokumen
    rows += "</td>"
    rows += "<td style='width:auto; white-space: normal; text-align: center; padding: 10px;'>"
    rows += data[index].nomor_dokumen
    rows += "</td>"
    rows += "<td style='width:auto; white-space: normal; text-align: center; padding: 10px;'>"
    rows += data[index].updated_by
    rows += "</td>"
    rows += "<td>"   
    rows += `
    <div class="dropdown">
    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Action
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">`
        rows += "<button type='button' class='btn btn-light btn-xs dropdown-item' onClick='view(\"" + data[index].id + "\",\"" + data[index].nama_dokumen + "\",\"" + data[index].file + "\",\"" + data[index].date + "\",\"" + data[index].jenis_dokumen + "\",\"" + data[index].tipe_dokumen + "\",\"" + data[index].nomor_dokumen + "\",\"" + data[index].deskripsi_dokumen + "\")' style='margin-right: 5px;'><i class='fa fa-file-text feather-16'></i> View</button>"
        rows += "<button type='button' class='btn btn-light btn-xs dropdown-item' onClick='edit(\"" + data[index].id + "\")' style='margin-right: 5px;'><i class='fa fa-pencil feather-16'></i> Edit</button>"
        if(localStorage.getItem('role')=='admin'){
        rows += "<button type='button' class='btn btn-light btn-xs dropdown-item' onClick='destroy(\"" + data[index].id + "\")'><i class='fa fa-trash feather-16'></i> Delete</button>"    
        }
    rows += `</div>
    </div>`
    rows += "</td>"
    rows += "</tr>"

    return rows
}

// clear value filter search
function clearFilter(){
    $("#filterTahun").val("")
    $("#filterTipeDokumen").val("")
    $("#filterJenisDokumen").val("")
    search();
}

function setUpInfo(structure){
    // clear
    $("#pagination").html("")
    $("#tableInfo").html("")

    $("#pagination").append(commonJS.buildPagination(structure))
    $("#tableInfo").append(commonJS.buildTableInfo(structure))
    $("#selectPage").on("change", function(val){
        globalPage = $("#selectPage option:selected").val();
        search();
    })
}

function search(page) {
    if (!page) page = globalPage;
    var url = "/api/doc_belanja_pegawai/get?page=" + page
    
    var filterTahun = $("#filterTahun").val()
    var filterTipeDokumen = $("#filterTipeDokumen").val()
    var filterJenisDokumen = $("#filterJenisDokumen").val()
    var params = "&tahun=" + filterTahun + "&tipe_dokumen=" + filterTipeDokumen + "&jenis_dokumen=" + filterJenisDokumen

    $(".template-data").remove()
    commonJS.loading(true)
    commonAPI.getAPI(url + params, (response) => {
        // console.log(response)
        if(response.status==200){
            // refine structure
            var structure = response.data
            var data = structure.data

            // force search from page 1
            if (data.length == 0 && structure.current_page != 1){
                globalPage = 1
                search()
                return
            }

            var rows = "";
            if (data.length == 0){
                $("#nodata").show()
            }else{
                $("#nodata").hide()
            }
            for (var index in data){
                rows += buildTemplate(data, index, page, structure.per_page)
            }

            $("#data-table>tbody").append(rows);
            setUpInfo(structure)
            commonJS.loading(false)
        } else if(response.status==401){
            commonJS.swalError(response.message, function() {
                window.location = "/logout";
            });
        }
    })
}

// clear value when modal close
$(".modal").on("hidden.bs.modal", function(){
    $("#id").val('');
    $("#date").val('');
    $("#jenis_dokumen").val('');
    $("#tipe_dokumen").val('');
    $("#nama_dokumen").val('');
    $("#nomor_dokumen").val('');
    $("#deskripsi_dokumen").val('');
    $("#file").val('');
});

// function add
function add(){
    $('#modalForm').modal('show');
    $("#modalLabel").text("Add Dokumen Keuangan")
    $('#upload_file').html(`
        <div class="form-group row">
            <label for="file" class="col-sm-3 col-form-label">File</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" id="file" name="file" accept="application/pdf">
            </div>
        </div>`);
}

// function save
function save(){
    commonJS.clearMessage()
    if ($("#date").val() == '') {
        $("#date").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Tanggal"], commonMsg.MSG_REQUIRED))
        return
    }

    if ($("#jenis_dokumen").val() == '') {
        $("#jenis_dokumen").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Jenis Dokumen"], commonMsg.MSG_REQUIRED))
        return
    }

    if ($("#tipe_dokumen").val() == '') {
        $("#tipe_dokumen").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Tipe Dokumen"], commonMsg.MSG_REQUIRED))
        return
    }
    
    if ($("#nama_dokumen").val() == '') {
        $("#nama_dokumen").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Nama Dokumen"], commonMsg.MSG_REQUIRED))
        return
    }
    
    if ($("#nomor_dokumen").val() == '') {
        $("#nomor_dokumen").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Nomor Dokumen"], commonMsg.MSG_REQUIRED))
        return
    }

    if ($("#deskripsi_dokumen").val() == '') {
        $("#deskripsi_dokumen").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Deskripsi Dokumen"], commonMsg.MSG_REQUIRED))
        return
    }

    
    // console.log($("#file")[0].files[0])
    // validate required file
    if ($("#file").val() == '') {
        $("#file").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["File"], commonMsg.MSG_REQUIRED))
        return
    }
    // Validate type file
    if ($("#file")[0].files[0].type!='application/pdf') {
        $("#file").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["File"], commonMsg.MSG_ONLY_PDF))
        return
    }
    // validate file size
    if ($("#file")[0].files[0].size>10000000) {
        $("#file").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["File"], commonMsg.MSG_MORE_THAN_10MB))
        return
    }   

    commonJS.loading(true)

    // get value
    let id = $("#id").val(); 
    let date = $("#date").val(); 
    let jenis_dokumen = $("#jenis_dokumen").val();
    let tipe_dokumen = $("#tipe_dokumen").val();
    let nama_dokumen = $("#nama_dokumen").val();
    let nomor_dokumen = $("#nomor_dokumen").val();
    let deskripsi_dokumen = $("#deskripsi_dokumen").val();
    let file = $("#file")[0].files[0];
    // console.log($("#file")[0].files[0].type)
    // form data
    var data = new FormData();
    data.append("date", date);
    data.append("jenis_dokumen", jenis_dokumen);
    data.append("tipe_dokumen", tipe_dokumen);
    data.append("nama_dokumen", nama_dokumen);
    data.append("nomor_dokumen", nomor_dokumen);
    data.append("deskripsi_dokumen", deskripsi_dokumen);
    data.append("file", file);

    // console.log($("#id").val())

    if ($("#id").val() == ""){
        // POST API
        commonAPI.postFormDataAPI("/api/doc_belanja_pegawai/create", data, function(response){
            // console.log(response)

            // validate response hard code (Not Best Practice)
            let localJSON = {
                "error": {
                    "file": [
                        "File Must Be PDF Type"
                    ]
                }
            };
            // console.log(localJSON)
                
            if(JSON.stringify(response) == JSON.stringify(localJSON)){
                commonJS.swalError(response.error[Object.keys(response.error)[0]][0])
                commonJS.loading(false)
                return
            }
            // end validate response hard code (Not Best Practice)

            commonJS.loading(false)
            search()
            $('#modalForm').modal('hide');
        }, function(response){
            // console.log(response)
            commonJS.loading(false)
            commonJS.swalError(response.responseJSON.message);
        })

    }else{
        data.append("_method", "PUT");
        commonAPI.postFormDataAPI(`/api/doc_belanja_pegawai/put/${id}`, data, function(response){
            // console.log(response)

            // validate response hard code (Not Best Practice)
            let localJSON = {
                "error": {
                    "file": [
                        "File Must Be PDF Type"
                    ]
                }
            };
            // console.log(localJSON)
                
            if(JSON.stringify(response) == JSON.stringify(localJSON)){
                commonJS.swalError(response.error[Object.keys(response.error)[0]][0])
                commonJS.loading(false)
                return
            }
            // end validate response hard code (Not Best Practice)

            commonJS.loading(false)
            search()
            $('#modalForm').modal('hide');
        }, function(response){
            // console.log(response)
            commonJS.loading(false)
            commonJS.swalError(response.responseJSON.message);
        })
    }
}

// function edit
function edit(id){
    $('#modalForm').modal('show');
    $('#modalLabel').html('Edit Dokumen Keuangan');
    $('#upload_file').html(`
        <div class="form-group row">
            <label for="file" class="col-sm-3 col-form-label">File</label>
            <div class="col-sm-9">
                <input type="file" class="form-control" id="file" name="file" accept="application/pdf">
            </div>
        </div>`);
    commonJS.loading(true)
    commonAPI.getAPI(`/api/doc_belanja_pegawai/get/${id}`, (response) => {
        if(response.status==200){
            $("#id").val(response.data.id);
            $("#date").val(response.data.date);
            $("#jenis_dokumen").val(response.data.jenis_dokumen);
            $("#tipe_dokumen").val(response.data.tipe_dokumen);
            $("#nama_dokumen").val(response.data.nama_dokumen);
            $("#nomor_dokumen").val(response.data.nomor_dokumen);
            $("#deskripsi_dokumen").val(response.data.deskripsi_dokumen);
            commonJS.loading(false)
        } else if(response.status==401){
            commonJS.loading(false)
            commonJS.swalError(response.responseJSON.message)
        }
    })
}

function destroy(id) {
    commonJS.swalConfirmAjax("Are you sure you want to delete this data?", "Yes", "No", commonAPI.deleteAPI, `/api/doc_belanja_pegawai/delete/${id}`, function(response){
        if (response.status == 200) {
            search(globalPage);
        } else if (response.status==401){
            swalError(response.message)
        }
        commonJS.loading(false)
    }, function(response){
        commonJS.loading(false)
        commonJS.swalError(response.responseJSON.message);
    })
}

function view(id, nama_dokumen, file, date, jenis_dokumen, tipe_dokumen, nomor_dokumen, deskripsi_dokumen) {
    $('#modalPreview').modal('show');
    $('#modalPreviewLabel').html(nama_dokumen)
    $('#dateView').html(date)
    $('#jenis_dokumenView').html(jenis_dokumen)
    $('#tipe_dokumenView').html(tipe_dokumen)
    $('#nama_dokumenView').html(nama_dokumen)
    $('#nomor_dokumenView').html(nomor_dokumen)
    $('#deskripsi_dokumenView').html(deskripsi_dokumen)
    $("#previewFrame").attr("src", '/api/doc_belanja_pegawai/download/'+id)
    $("#footerPreview").html('<a href="/api/doc_belanja_pegawai/download/' + id + '" download="' + file + '"><button type="button" class="btn btn-input btn-dark"><i class="fa fa-download feather-16"></i> Download</button></a>')
}

$(function(){
    // on document ready
    search()
})