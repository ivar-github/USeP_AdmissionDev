function swalGenericAdd(message){
  Swal.fire({
    title: message,
    icon: 'success',
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
  }).then((result) => {
    if (result.isConfirmed) {
      location.reload();
    }
  });
}

function swalGenericUpdate(message){
  Swal.fire({
    title: message,
    icon: 'success',
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
  }).then((result) => {
    if (result.isConfirmed) {
      location.reload();
    }
  });
}


function swalGenericDelete(){
    Swal.fire({
    title: 'Deleted Successfully?',
    icon: 'success',
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Ok'
  })
}


function swalGenericExport(){
  Swal.fire({
    title: 'Exported and Downloaded Successfully!',
    icon: 'success',
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
  })
}


function swalGenericError(message,msg){
  Swal.fire({
    title: message,
    text: msg,
    icon: 'error',
    showCancelButton: false,
    confirmButtonColor: '#d33',
  })
}







// function swalGenericDelete(){
//     Swal.fire({
//     title: 'Are you sure?',
//     text: "You won't be able to revert this!",
//     icon: 'warning',
//     showCancelButton: true,
//     confirmButtonColor: '#3085d6',
//     cancelButtonColor: '#d33',
//     confirmButtonText: 'Yes, delete it!'
//   }).then((result) => {
//     if (result.isConfirmed) {
//       Swal.fire(
//         'Deleted!',
//         'Your file has been deleted.',
//         'success'
//       )
//     }
//   });
// }
