<?php

return array(
    /*
      |--------------------------------------------------------------------------
      | Validierungssprachzeilen
      |--------------------------------------------------------------------------
      |
      | Die folgenden Sprachzeilen enthalten die standardmäßigen Fehlermeldungen, die von
      | der Validierungsklasse verwendet werden. Einige dieser Regeln haben mehrere Versionen,
      | wie beispielsweise die Größenregeln. Sie können jede dieser Meldungen nach Belieben anpassen.
      |
     */

    "accepted" => ":attribute muss akzeptiert werden.",
    "active_url" => ":attribute muss eine gültige URL sein.",
    "after" => ":attribute muss ein Datum sein, das nach dem :date liegt.",
    "alpha" => ":attribute darf nur Buchstaben enthalten.",
    "alpha_dash" => ":attribute darf nur Buchstaben, Zahlen und Bindestriche enthalten.",
    "alpha_num" => ":attribute darf nur Buchstaben und Zahlen enthalten.",
    "array" => ":attribute muss ein Array sein.",
    "before" => ":attribute muss ein Datum sein, das vor dem :date liegt.",
    "between" => array(
        "numeric" => ":attribute muss zwischen :min und :max liegen.",
        "file" => ":attribute muss zwischen :min und :max Kilobyte groß sein.",
        "string" => ":attribute muss zwischen :min und :max Zeichen lang sein.",
        "array" => ":attribute muss zwischen :min und :max Elemente haben."
    ),
    "confirmed" => ":attribute stimmt nicht mit der Bestätigung überein.",
    "date" => ":attribute muss ein gültiges Datum sein.",
    "date_format" => ":attribute entspricht nicht dem Format :format.",
    "different" => ":attribute und :other müssen unterschiedlich sein.",
    "digits" => ":attribute muss :digits Ziffern haben.",
    "digits_between" => ":attribute muss zwischen :min und :max Ziffern haben.",
    "email" => ":attribute hat ein ungültiges Format.",
    "exists" => "Das ausgewählte :attribute ist ungültig.",
    "image" => ":attribute muss eine Bilddatei sein.",
    "in" => ":attribute ist ungültig.",
    "integer" => ":attribute muss eine Ganzzahl sein.",
    "ip" => ":attribute muss eine gültige IP-Adresse sein.",
    "max" => array(
        "numeric" => ":attribute darf nicht größer als :max sein.",
        "file" => ":attribute darf nicht größer als :max Kilobyte sein.",
        "string" => ":attribute darf nicht mehr als :max Zeichen haben.",
        "array" => ":attribute darf nicht mehr als :max Elemente haben."
    ),
    "mimes" => ":attribute muss das Dateiformat :values haben.",
    "min" => array(
        "numeric" => ":attribute muss größer oder gleich :min sein.",
        "file" => ":attribute muss mindestens :min Kilobyte groß sein.",
        "string" => ":attribute muss mindestens :min Zeichen haben.",
        "array" => ":attribute muss mindestens :min Elemente haben."
    ),
    "not_in" => "Das ausgewählte :attribute ist ungültig.",
    "numeric" => ":attribute muss eine Zahl sein.",
    "regex" => ":attribute hat ein ungültiges Format.",
    "required" => ":attribute ist erforderlich.",
    "required_if" => ":attribute ist erforderlich, wenn :other den Wert :value hat.",
    "required_with" => ":attribute ist erforderlich, wenn :values vorhanden ist.",
    "required_with_all" => ":attribute ist erforderlich, wenn :values vorhanden ist.",
    "required_without" => ":attribute ist erforderlich, wenn :values nicht vorhanden ist.",
    "required_without_all" => ":attribute ist erforderlich, wenn keines der :values vorhanden ist.",
    "same" => ":attribute und :other müssen übereinstimmen.",
    "size" => array(
        "numeric" => ":attribute muss :size sein.",
        "file" => ":attribute muss :size Kilobyte groß sein.",
        "string" => ":attribute muss :size Zeichen lang sein.",
        "array" => ":attribute muss :size Elemente haben."
    ),
    "unique" => ":attribute wurde bereits verwendet.",
    "url" => ":attribute hat ein ungültiges Format.",
    /*
      |--------------------------------------------------------------------------
      | Benutzerdefinierte Validierungssprachzeilen
      |--------------------------------------------------------------------------
      |
      | Hier können Sie benutzerdefinierte Validierungsmeldungen für Attribute festlegen, indem Sie die
      | Konvention "attribute.rule" verwenden, um die Zeilen zu benennen. Dies macht es schnell und einfach,
      | eine bestimmte benutzerdefinierte Sprachzeile für eine bestimmte Attributregel festzulegen.
      |
     */
    'custom' => array(),
    /*
      |--------------------------------------------------------------------------
      | Benutzerdefinierte Validierungsattribute
      |--------------------------------------------------------------------------
      |
      | Die folgenden Sprachzeilen werden verwendet, um Platzhalter für Attribute auszutauschen
      | gegen etwas leserfreundlicheres, wie zum Beispiel "E-Mail-Adresse" anstelle von "email". Dies hilft uns einfachere Nachrichten zu erstellen.
      |
     */
    'attributes' => array(),
);
