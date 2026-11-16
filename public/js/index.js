$(document).ready(function () {

    $(document).on('click', '.add-location', function () {
        var location = $(this).siblings('.location').html();
        var activity = $(this).siblings('.activity').html();
        var duration = $(this).siblings('.duration').html();
        var price = $(this).siblings('.price').html();

        $.ajax({
            url: 'api/addDestination.php',
            type: 'POST',
            data: {
                location: location,
                activity: activity,
                duration: duration,
                price: price
            },
            success: function () {
                alert('Destination successfully added!');
            }
        });
    });

    $(document).on('click', '.close', function () {
        var location = $(this).siblings().find('.addedLocation').html();
        var duration = $(this).siblings().find('.addedDuration').html();
        var activity = $(this).siblings().find('.addedActivity').html();
        var price = $(this).siblings().find('.addedPrice').html();

        $.ajax({
            url: 'api/deleteDestination.php',
            type: 'POST',
            data: {
                location: location,
                duration: duration,
                activity: activity,
                price: price
            },
            success: function () {
                window.location.reload();
            }
        });
    });
});
