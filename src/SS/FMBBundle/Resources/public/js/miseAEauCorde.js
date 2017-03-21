var tabFormulaire = [];
function validation() {
    if (parseInt($('#quantit').val()) < 0) {
        alert("vous avez demander de mettre un nombre superieur de corde que celle preparé");
        return false;
    } else {
        check = confirm('vous confirmer les données (date de retrait, article , lot que vous avez choisie');
        if (check == true) {
            return true;
        }
        else {
            return false;
        }
    }
}

$(document).ready(function () {
    $('input:checkbox').change(function () {
        if ($(this).is(':checked')) {
            $('#quantit').val(parseInt($('#quantit').val()) - 1);
        } else {
            $('#quantit').val(parseInt($('#quantit').val()) + 1);
        }
    });

    $('input:checkbox').hide();
    $('.cochage').hide();
    $('#dateCordeChoix').hide();
    $('#articlechoix').hide();
    $('#articlelotchoix').hide();
    $('#articlecyclechoix').hide();
    $('#quantierchoix').hide();
    $('input[type="submit"]').hide();
    $('#cordechoix').ready(function () {
            chercherDatePreparer($('#cordechoix  option:selected').val());
        }
    ).change(function () {
            chercherDatePreparer($('#cordechoix  option:selected').val());
            $("input:checkbox").each(function () {
                $(this).prop('checked', false);
            });
        }
    );
});
function chercherDatePreparer(corde) {
    $.ajax({
        type: 'get',
        url: Routing.generate('ssfmb_parcDateCPreparer', {corde: corde}),
        beforeSend: function () {
            tabFormulaire = [];
            $('#dateCordeChoix').hide();
            $('#articlechoix').hide();
            $('#articlelotchoix').hide();
            $('#articlecyclechoix').hide();
            $('#quantierchoix').hide();
            $('input[type="submit"]').hide();
            $('loadquantit').show();
            $('#dateCordeChoix').empty();
            $('#articlechoix').empty();
            $('input[type="submit"]').hide();

            $('#quantit').val(0);
            $('#loadquantit').show();
            $('input:checkbox').hide();
            $('.cochage').hide();
        },
        success: function (data) {
            tabFormulaire = data;
            if (tabFormulaire.length != 0) {
                $.each(tabFormulaire, function (k, v) {
                    $('#dateCordeChoix').append('<option value="' + k + '">' + k + '</option>');
                });
            }
        },
        complete: function () {
            $('#dateCordeChoix').show();
            if (tabFormulaire.length != 0) {
                $('#dateCordeChoix').change(function () {
                    trouveArticle($('#dateCordeChoix option:selected').val());
                    $("input:checkbox").each(function () {
                        $(this).prop('checked', false);
                    });
                });

                trouveArticle($('#dateCordeChoix option:selected').val());
            } else {
                $('#quantit').val(0);
                $('#loadquantit').hide();
                $('input:checkbox').hide();
                $('.cochage').hide();
            }
        }
    });
}
function trouveArticle(date) {
    $('#articlechoix').empty();
    $.each(tabFormulaire[date], function (k, v) {
        $('#articlechoix').append('<option value="' + k + '">' + k + '</option>');
    });
    $('#articlechoix').show();
    $('#articlechoix').change(function () {
        afficheLot($('#dateCordeChoix option:selected').val(), $('#articlechoix').val());
        cycleArticle($('#articlechoix').val());
        $("input:checkbox").each(function () {
            $(this).prop('checked', false);
        });
    });
    cycleArticle($('#articlechoix').val());
    afficheLot($('#dateCordeChoix option:selected').val(), $('#articlechoix').val());
}
function afficheLot(datec, article) {
    $('#articlelotchoix').empty();
    $.each(tabFormulaire[datec][article], function (k, v) {
        $('#articlelotchoix').append('<option value="' + k + '">' + k + '</option>');
    });

    $('#articlelotchoix').show();
    $('#articlelotchoix').change(function () {
        affichageQte($('#dateCordeChoix option:selected').val(), $('#articlechoix').val(), $('#articlelotchoix').val());
        $("input:checkbox").each(function () {
            $(this).prop('checked', false);
        });
    });
    affichageQte($('#dateCordeChoix option:selected').val(), $('#articlechoix').val(), $('#articlelotchoix').val());
}
function affichageQte(datec, article, lot) {
    $('#quantierchoix').empty();
    $.each(tabFormulaire[datec][article][lot], function (k, v) {
        $('#quantierchoix').append('<option value="' + k + '">' + k + '</option>');
    });
    $('#quantierchoix').change(function () {
        affichageNombreDispo($('#dateCordeChoix option:selected').val(), $('#articlechoix').val(), $('#articlelotchoix').val(), $('#quantierchoix').val());
        $("input:checkbox").each(function () {
            $(this).prop('checked', false);
        });
    });
    $('#quantierchoix').show();
    affichageNombreDispo($('#dateCordeChoix option:selected').val(), $('#articlechoix').val(), $('#articlelotchoix').val(), $('#quantierchoix').val());
}
function affichageNombreDispo(datec, article, lot, qte) {
    $('#quantit').val(tabFormulaire[datec][article][lot][qte]);
    $('#loadquantit').hide();
    $('input[type="submit"]').show();
    $('input:checkbox').show();
    $('.cochage').show();
}
function cycleArticle(article) {
    $.ajax({
        type: "POST",
        url: Routing.generate('ssfmb_articlecyclechoix', {sarticle: article}),
        beforeSend: function () {
            $('#loadquantit').show();
        },
        success: function (data) {
            if ($.trim(data)) {
                $('#articlecyclechoix').show();
                $('#articlecyclechoix').html('');
                $.each(data, function (k, v) {
                    $('#articlecyclechoix').append('<option value="' + k + '">' + v + '</option>');
                });
            }
        },
        complete: function () {
            $('#loadquantit').hide();
        }
    });
}
function fillCheckbox(containerID, fill) {
    var checkbox = $('#' + containerID);
    var checkbox = checkbox.find('input[type="checkbox"]');
    checkbox.each(function () {
        switch (fill) {
            case '0':
                if (this.checked == true)
                    $('#quantit').val(parseInt($('#quantit').val()) + 1);
                this.checked = false;
                break;
            case '1':
                if (this.checked == false)
                    $('#quantit').val(parseInt($('#quantit').val()) - 1);
                this.checked = true;
                break;
            case 2:
                this.checked = !this.checked;
                break;
        }
    });
}


