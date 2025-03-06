
function swalGenericAdd(message) {
  Swal.fire({
    title: "Added",
    text: message,
    icon: 'success',
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
  }).then((result) => {
    if (result.isConfirmed) {
      location.reload();
    }
  });
}

function swalGenericSinglePageAdd(message){
  Swal.fire({
    title: "Added",
    text: message,
    icon: 'success',
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
  }).then((result) => {
    if (result.isConfirmed) {
      // location.reload();
    }
  });
}

function swalGenericUpdate(message){

  Swal.fire({
    title: "Updated",
    text: message,
    icon: 'success',
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
  }).then((result) => {
    if (result.isConfirmed) {
      location.reload();
    }
  });
}

function swalGenericSinglePageUpdate(message){
  Swal.fire({
    // title: "Updated",
    title: message,
    icon: 'success',
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
  }).then((result) => {
    if (result.isConfirmed) {
      // location.reload();
    }
  });
}

function swalGenericDelete(){
    Swal.fire({
    title: 'Deleted',
    text: 'Deletion Successful',
    icon: 'success',
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Ok',
    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
  }).then((result) => {
    if (result.isConfirmed) {
      // location.reload();
    }
  });
}


function swalGenericSinglePageDelete(){
    Swal.fire({
    title: 'Deleted',
    text: 'Deletion Successful',
    icon: 'success',
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'Ok',
    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
  })
}


function swalGenericExport(){
  Swal.fire({
    title: 'Exported',
    text: 'Exported and Downloaded Successfully!',
    icon: 'success',
    showCancelButton: false,
    confirmButtonColor: '#3085d6',
    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
  })
}


function swalGenericError(message,msg){
  Swal.fire({
    title: message,
    text: msg,
    icon: 'error',
    showCancelButton: false,
    confirmButtonColor: '#d33',
    background: document.documentElement.classList.contains('dark') ? '#1F2937' : '#ffffff',
    color: document.documentElement.classList.contains('dark') ? '#ffffff' : '#374151',
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
