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
    rows += "<td>"
    rows += data[index].name
    rows += "</td>"
    rows += "<td>"
    rows += data[index].email
    rows += "</td>"
    rows += "<td>"
    rows += `
    <div class="dropdown">
    <button class="btn btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Action
    </button>
    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">`       
        rows += "<button type='button' class='btn btn-light btn-xs  dropdown-item' onClick='edit(\"" + data[index].id + "\")' style='margin-right: 5px;'><i class='fa fa-pencil feather-16'></i> Edit</button>"
        rows += "<button type='button' class='btn btn-light btn-xs  dropdown-item' onClick='destroy(\"" + data[index].id + "\")'><i class='fa fa-trash feather-16'></i> Delete</button>" 
    rows += `</div>
    </div>`
    rows += "</td>"
    rows += "</tr>"

    return rows
}

// clear value filter search
function clearFilter(){
    $("#filterName").val("")
    $("#filterEmail").val("")
    globalPage = 1
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
    var url = "/api/user/get?page=" + page
    
    var filterName = $("#filterName").val()
    var filterEmail = $("#filterEmail").val()
    var params = "&name=" + filterName + "&email=" + filterEmail

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
    $("#name").val('');
    $("#email").val('');
    $("#password").val('');
    $("#role").val('');
});

// function add
function add(){
    $('#modalForm').modal('show');
    $("#modalLabel").text("Add User Data");
    $('#pass').html(`
        <div class="form-group row">
            <label for="password" class="col-sm-3 col-form-label">Password</label>
            <div class="col-sm-9">
                <input type="password" class="form-control" id="password" name="password" placeholder="Password">
            </div>
        </div>`);
}

// function save
function save(){
    const regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
    commonJS.clearMessage()
    if ($("#name").val() == '') {
        $("#name").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Name"], commonMsg.MSG_REQUIRED))
        return
    }
    
    if ($("#email").val() == '') {
        $("#email").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Email"], commonMsg.MSG_REQUIRED))
        return
    }

    if ($("#role").val() == '') {
        $("#role").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Role"], commonMsg.MSG_REQUIRED))
        return
    }

    if (!regex.test($("#email").val())) {
        $("#email").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Email"], commonMsg.MSG_EMAIL_NOT_VALID))
        return
    }

    commonJS.loading(true)

    // harus kaya gini, kalau langsung ke jquery ga kedeteksi
    // var data
    let name = $("#name").val();
    let email = $("#email").val();
    let role = $("#role").val();

    if ($("#id").val() == ""){
        // validasi input password
        if ($("#password").val() == '') {
            $("#password").focus();
            commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Password"], commonMsg.MSG_REQUIRED))
            return
        }
    
        if ($("#password").val().length < 8) {
            $("#password").focus();
            commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Password"], commonMsg.MSG_MIN_8_CHAR))
            return
        }

        // get value input password
        let password = $("#password").val();

        let data = {
            "name": name,
            "email": email,
            "password": password,
            "role": role
        }

        commonAPI.postAPI("/api/user/create", data, function(response){
            commonJS.loading(false)
            search()
            $('#modalForm').modal('hide');
        }, function(response){
            commonJS.loading(false)
            commonJS.swalError(response.responseJSON.message);
        })
    }else{
        // json data
        let data = {
            "name": name,
            "email": email,
            "role": role,
        }
        commonAPI.putAPI("/api/user/put/" + $("#id").val(), data, function(response){
            commonJS.loading(false)
            search()
            $('#modalForm').modal('hide');
        }, function(response){
            commonJS.loading(false)
            commonJS.swalError(response.responseJSON.message);
        })
    }
}

// function edit
function edit(id){
    $('#modalForm').modal('show');
    $("#modalLabel").text("Edit User Data");
    $('#pass').html(``);
    commonJS.loading(true)
    commonAPI.getAPI(`/api/user/get/${id}`, (response) => {
        if(response.status==200){
            $("#id").val(response.data.id);
            $("#name").val(response.data.name);
            $("#email").val(response.data.email);
            $("#role").val(response.data.role);
            // console.log(response.data.role)
            // $('#role').each(function() {
            //     if($(this).val() == response.data.role) {
            //         $(this).prop("selected", true);
            //     }
            // });
            commonJS.loading(false)
        } else if(response.status==401){
            commonJS.loading(false)
            commonJS.swalError(response.responseJSON.message)
        }
    })
}

function destroy(id) {
    commonJS.swalConfirmAjax("Are you sure you want to delete this data?", "Yes", "No", commonAPI.deleteAPI, `/api/user/delete/${id}`, function(response){
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

$(function(){
    // on document ready
    setupEventHandler()
    search()
})