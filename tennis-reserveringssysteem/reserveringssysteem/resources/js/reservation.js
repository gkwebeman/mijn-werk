$('#reservationKind').on('change', function(e) {
    let normalReservation = document.getElementById('normalReservation');
    let eventReservation = document.getElementById('eventReservation');
    let classReservation = document.getElementById('classReservation');

    if (($('#reservationKind').val() == 1))
    {
        normalReservation.classList.remove('d-none');
        eventReservation.classList.add('d-none');
        classReservation.classList.add('d-none');
        eventReservation.classList.remove('d-block');
    } else
    if (($('#reservationKind').val() == 2))
    {
        normalReservation.classList.add('d-none');
        eventReservation.classList.add('d-none');
        classReservation.classList.remove('d-none');
        eventReservation.classList.remove('d-block');
    } else
    if (($('#reservationKind').val() == 3))
    {
        normalReservation.classList.add('d-none');
        eventReservation.classList.remove('d-none');
        classReservation.classList.add('d-none');
    }
});
