function successMsg(msg){
    Swal.fire({
        position: 'top',
        icon: 'success',
        title: msg,
        showConfirmButton: false,
        timer: 1500
    })
}

function errorMsg(msg){
    Swal.fire({
        position: 'top',
        icon: 'error',
        title: msg,
        showConfirmButton: false,
        timer: 1500
    })
}