function displayRegionSelect(countryId)
{
    $('.regions').remove();
    $('.cities').remove();
    $('#select-group').append('<select name="regions" class="form-control  regions"></select>');
    $('.regions').append('<option>Loading.....</option>');
    $.ajax({
        type: 'POST',
        url: '/user/register?country_id='+countryId,
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function (data) {
            $('.regions').empty();
            $('.regions').append('<option value="0">Please select your region:');
            $.each(data, function (index, item) {
                $('.regions').append('<option value="' + data[index].id + '">' + data[index].region_name + '</option>');
            });
        }
    });
}

function displayCitySelect(regionId)
{
    $('.cities').remove();
    $('#select-group').append('<select name="cities" class="form-control  cities"></select>');
    $('.cities').append('<option>Loading.....</option>');
    $.ajax({
        type: 'POST',
        url: '/user/register?region_id='+regionId,
        contentType: 'application/json; charset=utf-8',
        dataType: 'json',
        success: function (data) {
            $('.cities').empty();
            $('.cities').append('<option value="0">Please select your city:');
            $.each(data, function (index, item) {
                $('.cities').append('<option value="' + data[index].id + '">' + data[index].city_name + '</option>');
            });
        }
    });
}

$(document).ready(function () {
    $('#select-group').on('change', 'select', function () {
        if ($(this).hasClass('countries')) {
            var countryId = $('.countries').val();
            displayRegionSelect(countryId);
        } else if ($(this).hasClass('regions')) {
            var regionId = $('.regions').val();
            displayCitySelect(regionId);
        }
    });
});
