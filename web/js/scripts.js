jQuery(document).ready(function($) {
    "use strict";

    $('.favorites_button, .favorites_link').on('click', (function () {
        var self = $(this);

        $.ajax({
            url: '/news/favorites',
            type: 'GET',
            data: {
             id: $(this).attr('data-id')
            },
            success: function(){
                if (self.hasClass('favorites_link')) {
                    self.toggleClass('favorites_link_active');
                }
                if (self.hasClass('favorites_button')) {
                    window.console.log(self[0].innerText);
                    if (self.hasClass('favorites_button_active')) {
                        self.addClass('btn-warning');
                        self.removeClass('favorites_button_active');
                        self[0].innerHTML = 'Добавить в избранное ' +
                            '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    } else {
                        self.removeClass('btn-warning');
                        self.addClass('favorites_button_active');
                        self[0].innerHTML = 'Убрать из избранного ' +
                            '<span class="glyphicon glyphicon-star" aria-hidden="true"></span>';
                    }
                }
            },
            error: function(){
                window.alert('Error!');
            }
        });
        return false;
    }));
})