function search() {

    var id = localStorage.getItem('id_user')
    commonJS.loading(true)
    commonAPI.getAPI(`/api/user/get/${id}`, (response) => {
        if(response.status==200){
            $("#id").val(response.data.id);
            $("#name").val(response.data.name);
            $("#email").val(response.data.email);
            $("#role").val(response.data.role);
            $("#jabatan").val(response.data.jabatan);
            commonJS.loading(false)
        } else if(response.status==401){
            commonJS.loading(false)
            commonJS.swalError(response.responseJSON.message)
        }
    })
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

    if ($("#jabatan").val() == '') {
        $("#jabatan").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Jabatan"], commonMsg.MSG_REQUIRED))
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
    let jabatan = $("#jabatan").val();

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
            "role": role,
            "jabatan": jabatan
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
            "jabatan": jabatan
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

$(function(){
    // on document ready
    search()
})