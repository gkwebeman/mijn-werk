$("#changeUserRoleModal").on('shown.bs.modal', function (e) {
    $.ajax({
        type : 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        url : "/user/"+$(e.relatedTarget).attr('name'),
        success:function(data){
            $("#userName").val(data.name);
            $("#roles_id").val(data.role_id);
            $("#changeUserRoleBtn").attr('name', data.id);
        },
        error:function(data) {
            //
            // console.log(data);
        }
    });
});

$("#changeUserRoleBtn").on('click', function (e) {
    $.ajax({
        type : 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        url : "/user/"+$('#changeUserRoleBtn').attr('name'),
        data:{
            'role_id':  $("#roles_id").val(),
        },
        success:function(data){
            $('#changeUserRoleModal').modal('hide');
            $('.warning').addClass('d-none');
            window.location.reload();
        },
        error:function(data) {
            // console.log(data);
        }
    });
});

$('#deleteUserPicture').on('click', function(e) {
    e.preventDefault();
    let id = document.getElementById('user_id');
    let deleteUserPictureBtn = document.querySelector('.deleteUserPictureBtn'); // needs to be hidden
    let deleteUserPhotoFile = document.querySelector('.deleteUserPhotoFile'); // needs to be shown
    let userPicture = document.querySelector('.userPicture'); // needs to be hidden

    $.ajax(
        "/user/" + id.value + "/deleteUserImage",
    {
        dataType: 'json',
        success:function(data){
            deleteUserPictureBtn.classList.add('d-none');
            userPicture.classList.add('d-none');
            deleteUserPhotoFile.classList.remove('d-none');
        },
        error:function(data) {
            // console.log(data);
        },
        type : 'PUT',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },

    });
});

$('#addNewUserPictureFile').on('change', function(e) {
    $('#addProfilePhoto').submit();
});

$('#addUserPictureFile').on('change', function(e) {
    $('#addProfilePhoto').submit();
});
