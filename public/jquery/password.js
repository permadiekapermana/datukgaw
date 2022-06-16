// function save
function save(){
    commonJS.clearMessage()
    if ($("#password").val() == '') {
        $("#password").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Password"], commonMsg.MSG_REQUIRED))
        return
    }
    if ($("#password2").val() == '') {
        $("#password2").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Confirm Password"], commonMsg.MSG_REQUIRED))
        return
    }
    if ($("#password").val() != $("#password2").val()) {
        commonJS.showErrorMessage("#msgBox", "Password and Confirm Password Doesnt Match!")
        return
    }

    commonJS.loading(true)

    // harus kaya gini, kalau langsung ke jquery ga kedeteksi
    // var data
    let id = localStorage.getItem('id_user')
    let password = $("#password").val();
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

    // json data
    let data = {
        "password": password
    }
    commonAPI.putAPI("/api/user/put/" + id, data, function(response){
        commonJS.loading(false)
        $("#password").val("")
        commonJS.swalOk(response.message);
    }, function(response){
        commonJS.loading(false)
        commonJS.swalError(response.responseJSON.message);
    })
    
}