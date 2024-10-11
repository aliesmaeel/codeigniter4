setInterval(function()
{
    $('.alert').fadeOut('slow');
}, 3000);


$(document).ready(function (){

    $('.btn-confirm').click(function (e){
        e.preventDefault();
        var btn=$(this);
        var id= $(this).val();

        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to revert this!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                    $.ajax({
                        url:'/student/ajax-delete/'+id,
                        success : function (response){
                            btn.closest('tr').remove();
                            var textnumber=$('.students-num').text();
                            let intNumber=parseInt(textnumber)-1;
                            $('.students-num').text(intNumber);
                        }
                    })
            }
        });
    })
})

let table = new DataTable('#myTable');
