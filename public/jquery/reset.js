// function save
function reset(){
    commonJS.clearMessage()
    if ($("#email").val() == '') {
        $("#email").focus();
        commonJS.showErrorMessage("#msgBox", commonMsg.getMessage(["Email"], commonMsg.MSG_REQUIRED))
        return
    }

    commonJS.loading(true)

    // harus kaya gini, kalau langsung ke jquery ga kedeteksi
    // var data
    let email = $("#email").val();

    commonAPI.resetAPI(`/api/user/forgot-password/${email}`, function(response){
        commonJS.loading(false)
        $("#email").val(``);
    }, function(response){
        commonJS.loading(false)        
        commonJS.swalError(response.responseJSON.message);
    })
    $("#email").val(``);
    
}