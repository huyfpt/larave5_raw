<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | such as the size rules. Feel free to tweak each of these messages.
    |
    */

    "accepted"             => "Le champ :attribute doit être accepté.",
    "active_url"           => "Le champ :attribute n'est pas une URL valide.",
    "after"                => "Le champ :attribute doit être une date postérieure au champ :date.",
    "after_or_equal"       => "Le champ :attribute doit être une date postérieure ou égale au champ :date.",
    "alpha"                => "Le champ :attribute doit seulement contenir des lettres.",
    "alpha_dash"           => "Le champ :attribute doit seulement contenir des lettres, des chiffres et des tirets.",
    "alpha_num"            => "Le champ :attribute doit seulement contenir des chiffres et des lettres.",
    "array"                => "Le champ :attribute doit être un tableau.",
    "before"               => "Le champ :attribute doit être une date antérieure au champ :date.",
    "before_or_equal"      => "Le champ :attribute doit être une date antérieure ou égale au champ :date.",
    "between"              => [
        "numeric" => "La valeur de :attribute doit être comprise entre :min et :max.",
        "file"    => "Le fichier :attribute doit avoir une taille entre :min et :max kilo-octets.",
        "string"  => "Le texte :attribute doit avoir entre :min et :max caractères.",
        "array"   => "Le tableau :attribute doit avoir entre :min et :max éléments.",
    ],
    "boolean"              => "Le champ :attribute doit être vrai ou faux.",
    "confirmed"            => "Le champ de confirmation :attribute ne correspond pas.",
    "date"                 => "Le champ :attribute n'est pas une date valide.",
    "date_format"          => "Le champ :attribute ne correspond pas au format :format.",
    "different"            => "Les champs :attribute et :other doivent être différents.",
    "digits"               => "Le champ :attribute doit avoir :digits chiffres.",
    "digits_between"       => "Le champ :attribute doit avoir entre :min and :max chiffres.",
    "email"                => "Le champ :attribute doit être une adresse email valide.",
    "exists"               => "Le champ :attribute sélectionné est invalide.",
    "filled"               => "Le champ :attribute est obligatoire.",
    "image"                => "Le champ :attribute doit être une image.",
    "in"                   => "Le champ :attribute est invalide.",
    "integer"              => "Le champ :attribute doit être un entier.",
    "ip"                   => "Le champ :attribute doit être une adresse IP valide.",
    "max"                  => [
        "numeric" => "La valeur de :attribute ne peut être supérieure à :max.",
        "file"    => "Le fichier :attribute ne peut être plus gros que :max kilo-octets.",
        "string"  => "Le texte de :attribute ne peut contenir plus de :max caractères (attention aux images insérées).",
        "array"   => "Le tableau :attribute ne peut avoir plus de :max éléments.",
    ],
    "mimes"                => "Le champ :attribute doit être un fichier de type : :values.",
    "min"                  => [
        "numeric" => "La valeur de :attribute doit être supérieure à :min.",
        "file"    => "Le fichier :attribute doit être plus gros que :min kilo-octets.",
        "string"  => "Le texte :attribute doit contenir au moins :min caractères.",
        "array"   => "Le tableau :attribute doit avoir au moins :min éléments.",
    ],
    "not_in"               => "Le champ :attribute sélectionné n'est pas valide.",
    "numeric"              => "Le champ :attribute doit contenir un nombre.",
    "regex"                => "Le format du champ :attribute est invalide.",
    "required"             => "Le champ :attribute est obligatoire.",
    'required_global'      => 'Le champ est obligatoire',
    "required_if"          => "Le champ :attribute est obligatoire quand la valeur de :other est :value.",
    "required_with"        => "Le champ :attribute est obligatoire quand :values est présent.",
    "required_with_all"    => "Le champ :attribute est obligatoire quand :values est présent.",
    "required_without"     => "Le champ :attribute est obligatoire quand :values n'est pas présent.",
    "required_without_all" => "Le champ :attribute est requis quand aucun de :values n'est présent.",
    "same"                 => "Les champs :attribute et :other doivent être identiques.",
    "size"                 => [
        "numeric" => "La valeur de :attribute doit être :size.",
        "file"    => "La taille du fichier de :attribute doit être de :size kilo-octets.",
        "string"  => "Le texte de :attribute doit contenir :size caractères.",
        "array"   => "Le tableau :attribute doit contenir :size éléments.",
    ],
    "string"               => "Le champ :attribute doit être une chaîne de caractères.",
    "timezone"             => "Le champ :attribute doit être un fuseau horaire valide.",
    "unique"               => "La valeur du champ :attribute est déjà utilisée.",
    "url"                  => "Le format de l'URL de :attribute n'est pas valide.",

    'file_extension_error'  => 'L\'extension du fichier n\'est pas correct',
    'file_maxsize_exceeded' => 'Le poids du fichier est trop important. (max: 5 Mo)',

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
        'email' => [
            'unique' => 'Vous êtes déjà inscrit.'
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

    'attributes' => [
        "name"                  => "Nom",
        "username"              => "Pseudo",
        "email"                 => "E-mail",
        "first_name"            => "Prénom",
        "firstname"             => "Prénom",
        "last_name"             => "Nom",
        "lastname"              => "Nom",
        "password"              => "Mot de passe",
        "password_confirmation" => "Confirmation du mot de passe",
        "city"                  => "Ville",
        "country"               => "Pays",
        "address"               => "Adresse",
        "phone"                 => "Téléphone",
        "mobile"                => "Portable",
        "age"                   => "Age",
        "sex"                   => "Sexe",
        "gender"                => "Genre",
        "day"                   => "Jour",
        "month"                 => "Mois",
        "year"                  => "Année",
        "hour"                  => "Heure",
        "minute"                => "Minute",
        "second"                => "Seconde",
        "title"                 => "Titre",
        "content"               => "Contenu",
        "description"           => "Description",
        "excerpt"               => "Extrait",
        "date"                  => "Date",
        "time"                  => "Heure",
        "available"             => "Disponible",
        "size"                  => "Taille",
        'function'              => 'Fonction',
        'civility'              => 'Civilité',
        'address1'              => 'Adresse',
        'address2'              => 'Complément',
        'zip'                   => 'Code postal',
        'date_at'               => 'Date',
        'provider_id'           => 'partenaire',
        'families'              => 'familles',
        'reference_amarante'    => 'référence',
        'duration'              => 'Durée',
        'price'                 => 'Prix',
        'objective'             => 'Objectif',
        'program'               => 'Programme',
        'reference'             => 'Référence',
        'length'                => 'Longeur',
        'width'                 => 'Largeur',
        'height'                => 'Hauteur',
        'start_at'              => 'Date début',
        'end_at'                => 'Date fin',
        'visual'                => 'Visuel'
    ],

    // validation for faqs
    'greater_than_field' => 'La date de fin doit être supérieure à la date de début.',
    'difference_value'   => 'Nom doit avoir une valeur différente de la catégorie parente.'
];
