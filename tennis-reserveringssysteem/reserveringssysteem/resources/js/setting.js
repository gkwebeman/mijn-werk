$('#timeslot').on('change', function(e) {
    $.ajax({
        type : 'GET',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        dataType: 'json',
        url : "/setting/"+$('#clubs_id').val()+"/getLatestReservation",
        data:{
            'clubs_id':  $("#clubs_id").val(),
        },
        success:function(data){
            console.log(data);
            $('#startingDate').removeClass('d-none');
            $('#startdate').val(data.startdate);
            $('#enddate').val(data.enddate);
        },
        error:function(data) {
            // console.log(data);
        }
    })
});

