<script>
    $(function(){
        "use strict";
        $(document).ready(function () {

            $(document).on('change','#background-type',function(){
                if($('#background-type').val() == 'color') {
                    $('#div-image').hide();
                    $('#div-color').show();
                    $("#meta_image").prop('required',false);
                    $('body').css('background', $("#background_color").val());
                } else {
                    $('#div-color').hide();
                    $('#div-image').show();
                    $("#meta_image").prop('required',true);

                }
            });

            $(document).on('change','#color_mode',function(){
                if($('#color_mode').val() == 'solid') {
                    $('#div-gradient-1').hide();
                    $('#div-gradient-2').hide();
                    $('#div-gradient-3').hide();
                    $('#div-solid').show();
                    $("#solid_color").prop('required',true);
                    $("#gradient_1").prop('required',false);
                    $("#gradient_2").prop('required',false);
                    $("#gradient_3").prop('required',false);
                    let solid_val = $('#solid_color').val();
                    document.documentElement.style.setProperty('--gradient_1', solid_val);
                    document.documentElement.style.setProperty('--gradient_2', solid_val);
                    document.documentElement.style.setProperty('--gradient_3', solid_val);
                } else {
                    $('#div-solid').hide();
                    $('#div-gradient-1').show();
                    $('#div-gradient-2').show();
                    $('#div-gradient-3').show();
                    $("#gradient_1").prop('required',true);
                    $("#gradient_2").prop('required',true);
                    $("#gradient_3").prop('required',true);
                    document.documentElement.style.setProperty('--gradient_1', $("#gradient_1").val());
                    document.documentElement.style.setProperty('--gradient_2', $("#gradient_2").val());
                    document.documentElement.style.setProperty('--gradient_3', $("#gradient_3").val());

                }
            });

            $(document).on('input', '#border_color', function(){
                document.documentElement.style.setProperty('--border_color', $(this).val());
            });
            $(document).on('input', '#scroll_color', function(){
                document.documentElement.style.setProperty('--scroll_color', $(this).val());
            });
            $(document).on('input', '#background_white', function(){
                document.documentElement.style.setProperty('--bg_white', $(this).val());
            });
            $(document).on('input', '#background_black', function(){
                document.documentElement.style.setProperty('--bg_black', $(this).val());
            });
            $(document).on('input', '#text_white', function(){
                document.documentElement.style.setProperty('--text_white', $(this).val());
            });
            $(document).on('input', '#text_black', function(){
                document.documentElement.style.setProperty('--text_black', $(this).val());
            });
            $(document).on('input', '#input_background', function(){
                document.documentElement.style.setProperty('--input__bg', $(this).val());
            });
            $(document).on('input', '#base_color', function(){
                document.documentElement.style.setProperty('--base_color', $(this).val());
            });
            $(document).on('input', '#text_color', function(){
                document.documentElement.style.setProperty('--text-color', $(this).val());
            });


            $(document).on('input', '#solid_color', function(){
                let solid_val = $('#solid_color').val();
                document.documentElement.style.setProperty('--gradient_1', solid_val);
                document.documentElement.style.setProperty('--gradient_2', solid_val);
                document.documentElement.style.setProperty('--gradient_3', solid_val);
            });

            $(document).on('input', '#gradient_1', function(){
                document.documentElement.style.setProperty('--gradient_1', $(this).val());
            });
            $(document).on('input', '#gradient_2', function(){
                document.documentElement.style.setProperty('--gradient_2', $(this).val());
            });
            $(document).on('input', '#gradient_3', function(){
                document.documentElement.style.setProperty('--gradient_3', $(this).val());
            });

            $(document).on('input', '#background_color', function(){
                $('body').css('background', $(this).val());
            });

            $(document).on('input', '#meta_image', function(){
                let input = this;
                if($('#background-type').val() === 'image'){
                    if (input.files && input.files[0]) {
                        $('#backGroundImagePlaceholder').attr('placeholder', input.files[0].name);
                        let reader = new FileReader();
                        reader.onload = function(e) {
                            $('body').css({
                                'background': 'url('+ e.target.result + ')  no-repeat center',
                                'background-size' : 'cover',
                                'background-attachment': 'fixed',
                                'background-position': 'top'
                            });
                        };
                        reader.readAsDataURL(input.files[0]);
                    }
                }
            });


        });

    });
</script>
