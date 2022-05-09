<?php

return [
    'options' => [
        "closeButton" => true,
        "debug" => false,
        "newestOnTop" => true,
        "progressBar" => false,
        "positionClass" => env('toastr_position'),
        "preventDuplicates" => true,
        "onclick" => null,
        "showDuration" => "300",
        "hideDuration" => "1000",
        "timeOut" => env('toastr_time'),
        "extendedTimeOut" => "1000",
        "showEasing" => "swing",
        "hideEasing" => "linear",
        "showMethod" => "fadeIn",
        "hideMethod" => "fadeOut"
    ],
];
