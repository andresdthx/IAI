<?php

return [

/*
|--------------------------------------------------------------------------
| Validation Language Lines
|--------------------------------------------------------------------------
|
| The following language lines contain the default error messages used by
| the validator class. Some of these rules have multiple versions such
| as the size rules. Feel free to tweak each of these messages here.
|
*/

'required'  => 'El :attribute es requerido.',
'unique'    => 'Este :attribute ya esta registrado',  
/*
|--------------------------------------------------------------------------
| Custom Validation Language Lines
|--------------------------------------------------------------------------
|
| Here you may specify custom validation messages for attributes using the
| convention "attribute.rule" to name the lines. This makes it quick to
| specify a specific custom language line for a given attribute rule.
|
*/

'custom' => [
    'attribute-name' => [
        'rule-name' => 'custom-message',
    ],


    'contraseña' => [
        'required'  => 'La :attribute es requerida',
        'confirmed' => 'La :attribute y su confirmación no coinciden.',
        'min'       => 'La :attribute debe de tener al menos :min caracteres.',
    ],

    'new_password' => [
        'confirmed' => 'La nueva contraseña y su confirmación no coinciden.',
        'min'       => 'La nueva contraseña debe de tener al menos :min caracteres.',
    ],

    'estrategia' => [
        'required' => 'La estrategia es requerida.'
    ],

    'email' => [
        'confirmed' => 'El :attribute y su confirmación no coinciden.',
    ]
],

/*
|--------------------------------------------------------------------------
| Custom Validation Attributes
|--------------------------------------------------------------------------
|
| The following language lines are used to swap attribute place-holders
| with something more reader friendly such as E-Mail Address instead
| of "email". This simply helps us make messages a little cleaner.
|
*/

'attributes' => [],

];
