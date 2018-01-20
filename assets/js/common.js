var hostURL = hostURL = window.location.origin + '/sonu/funny-app/';

function confirmAndRedirect(event, ele, title = "Confirm !", msg = "Are You Sure ?", confirmText = "Yes", cancelText = "No") {
    event.preventDefault();
    var href = $(ele).attr('href');
    $.confirm({
        title: title,
        content: msg,
        buttons: {
            confirm: {
                text: confirmText,
                btnClass: 'btn-red',
                keys: ['enter', 'shift'],
                action: function() {
                    window.location.href = href;
                }
            },
            cancel: {
                text: cancelText,
                btnClass: 'btn-blue',
                keys: ['enter', 'shift'],
                action: function() {
                    event.preventDefault();
                }
            }
        }
    });
}
$(document).ready(function() {
    $('body').on('click', '.delete', function(e) {
        confirmAndRedirect(e, this);
    });
    $('.datepicker').datepicker({
        format: 'dd MM, yyyy'
    });
    $('.datatable').DataTable();

    $('.select').select2();

    $('.cat-add-form').validate({
        ignore: "",
        errorPlacement: function(error, element) {
            if ($(element).attr('name') == 'tags') {
                error.insertAfter(element.next('.bootstrap-tagsinput'));
            } else {
                error.insertAfter(element);
            }
        }
    });
    $('.cat-add-form').on('submit', function(e) {
        if ($('input[name="appBackgroundImg[]"')[0].files.length == 0 && $('.back-img-preview').length==0) {
            alert('You need to add at least one background image !');
            e.preventDefault();

        }
    });
    $('.add-more-image').on('click', function(e) {
        e.preventDefault();

        var inputFile = '<div class="remove-image-input-container"><br><a class="pull-right btn btn-danger remove-image-input" style="margin-bottom:10px;"><span aria-hidden="true"><i class="fa fa-minus"></i></span></a><input type="file" name="appBackgroundImg[]" class="form-control image-input required" ></div>';
        $(inputFile).insertAfter($('.image-input:last'));
    });

    $('body').on('click', '.remove-image-input', function(e) {
        e.preventDefault();
        /*if ($('.remove-image-input-container').length==1) {
            alert('You can\'t delete last image !');
            return;
        }*/
        $(this).parent('.remove-image-input-container').remove();
    });

    $(".resizable").resizable({
        minHeight: 60,
        aspectRatio: true,
        maxHeight: 330,
        resize: function(event, ele) {
            var height = ele.element.height();
            var width = ele.element.width();
            $('.imgHeight').val(height);
            $('.imgWidth').val(width);

            var offset = $('.user-name-container').find('.draggable').offset();
            var offsetDiv = $('.app-preview').offset();

            var left = offset.left - offsetDiv.left;
            var top = offset.top - offsetDiv.top;

            $('.nameTop').val(top);
            $('.nameLeft').val(left);
        }
    });
    $(".draggable").draggable({
        drag: function() {
            var offset = $(this).offset();
            var offsetDiv = $('.app-preview').offset();

            var left = offset.left - offsetDiv.left;
            var top = offset.top - offsetDiv.top;

            if ($(this).find('img').length) {
                $('.imgTop').val(top);
                $('.imgLeft').val(left);
            } else {
                $('.nameTop').val(top);
                $('.nameLeft').val(left);
            }
        }
    });

    $('input[name="7"]').on('change', function(e) {
        var val = $(this).val();
        if (val == 1) {
            $('.resizable').css('display', 'block');
        } else {
            $('.resizable').css('display', 'none')
        }
    });
    $('input[name="profileImgBorder"]').on('change', function(e) {
        var val = $(this).val();
        $('.resizable').css('border-radius', val);
    });
    $('input[name="showName"]').on('change', function(e) {
        var val = $(this).val();
        if (val == 1) {
            $('.user-name-container').css('display', 'block');
        } else {
            $('.user-name-container').css('display', 'none')
        }
    });

    $('body').on('change', '.appFeaturedImg', function(e) {
        var input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function(e) {
                $('.app-preview').css('background-image', 'url(' + e.target.result + ')');
            }

            reader.readAsDataURL(input.files[0]);
        }
    });

    $('input[name="totalFriends"]').on('change, keyup', function(e) {
        e.preventDefault();
        var totalFriends = $(this).val();
        var appendHTML = '';
        for (var i = totalFriends - 1; i >= 0; i--) {
            appendHTML += '<div class=col-sm-2><div class=user-image-container><div class=draggable><img class="img-responsive resizable"src="' + hostURL + 'assets/images/user.png"></div><input class=imgHeight name=imgFriendHeight type=hidden value=100><input class=imgWidth name=imgFriendWidth type=hidden value=100> <input class=imgTop name=imgFriendTop type=hidden value=0><input class=imgLeft name=imgFriendLeft type=hidden value=0></div><div class=user-name-container><span class=draggable>Friend Name</span> <input class=nameTop name=nameFriendTop type=hidden value=100><input class=nameLeft name=nameFriendLeft type=hidden value=0></div></div>';
        }

        $('.app-preview').find('.friendsContainer').html(appendHTML);
        $('.draggable').draggable()
    });
});