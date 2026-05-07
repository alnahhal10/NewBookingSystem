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

    'accepted' => 'يجب قبول حقل :attribute.',
    'accepted_if' => 'يجب قبول حقل :attribute عندما يكون :other هو :value.',
    'active_url' => 'يجب أن يكون حقل :attribute رابطاً صحيحاً.',
    'after' => 'يجب أن يكون حقل :attribute تاريخاً بعد :date.',
    'after_or_equal' => 'يجب أن يكون حقل :attribute تاريخاً بعد أو يساوي :date.',
    'alpha' => 'يجب أن يحتوي حقل :attribute على أحرف فقط.',
    'alpha_dash' => 'يجب أن يحتوي حقل :attribute على أحرف وأرقام وشرطات وشرطات سفلية فقط.',
    'alpha_num' => 'يجب أن يحتوي حقل :attribute على أحرف وأرقام فقط.',
    'any_of' => 'حقل :attribute غير صالح.',
    'array' => 'يجب أن يكون حقل :attribute مصفوفة.',
    'ascii' => 'يجب أن يحتوي حقل :attribute على أحرف أبجدية رقمية ورموز فقط.',
    'before' => 'يجب أن يكون حقل :attribute تاريخاً قبل :date.',
    'before_or_equal' => 'يجب أن يكون حقل :attribute تاريخاً قبل أو يساوي :date.',
    'between' => [
        'array' => 'يجب أن يحتوي حقل :attribute على بين :min و :max عنصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute بين :min و :max كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute بين :min و :max.',
        'string' => 'يجب أن يكون طول حقل :attribute بين :min و :max حرفاً.',
    ],
    'boolean' => 'يجب أن تكون قيمة حقل :attribute صواباً أو خطأ.',
    'can' => 'حقل :attribute يحتوي على قيمة غير مسموحة.',
    'confirmed' => 'تأكيد حقل :attribute غير متطابق.',
    'contains' => 'حقل :attribute يفتقر إلى قيمة مطلوبة.',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => 'يجب أن يكون حقل :attribute تاريخاً صحيحاً.',
    'date_equals' => 'يجب أن يكون حقل :attribute تاريخاً يساوي :date.',
    'date_format' => 'يجب أن يتطابق حقل :attribute مع التنسيق :format.',
    'decimal' => 'يجب أن يحتوي حقل :attribute على :decimal أماكن عشرية.',
    'declined' => 'يجب رفض حقل :attribute.',
    'declined_if' => 'يجب رفض حقل :attribute عندما يكون :other هو :value.',
    'different' => 'يجب أن يكون حقل :attribute و :other مختلفين.',
    'digits' => 'يجب أن يحتوي حقل :attribute على :digits أرقام.',
    'digits_between' => 'يجب أن يحتوي حقل :attribute على بين :min و :max أرقام.',
    'dimensions' => 'أبعاد الصورة في حقل :attribute غير صالحة.',
    'distinct' => 'حقل :attribute يحتوي على قيمة مكررة.',
    'doesnt_contain' => 'يجب ألا يحتوي حقل :attribute على أي مما يلي: :values.',
    'doesnt_end_with' => 'يجب ألا ينتهي حقل :attribute بأي مما يلي: :values.',
    'doesnt_start_with' => 'يجب ألا يبدأ حقل :attribute بأي مما يلي: :values.',
    'email' => 'يجب أن يكون حقل :attribute بريداً إلكترونياً صحيحاً.',
    'encoding' => 'يجب أن يكون ترميز حقل :attribute هو :encoding.',
    'ends_with' => 'يجب أن ينتهي حقل :attribute بأي مما يلي: :values.',
    'enum' => 'الحقل المحدد :attribute غير صالح.',
    'exists' => 'الحقل المحدد :attribute غير صالح.',
    'extensions' => 'يجب أن يكون لحقل :attribute أحد الامتدادات التالية: :values.',
    'file' => 'يجب أن يكون حقل :attribute ملفاً.',
    'filled' => 'يجب أن يحتوي حقل :attribute على قيمة.',
    'gt' => [
        'array' => 'يجب أن يحتوي حقل :attribute على أكثر من :value عناصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute أكبر من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أكبر من :value.',
        'string' => 'يجب أن يكون طول حقل :attribute أكبر من :value أحرف.',
    ],
    'gte' => [
        'array' => 'يجب أن يحتوي حقل :attribute على :value عناصر أو أكثر.',
        'file' => 'يجب أن يكون حجم حقل :attribute أكبر من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أكبر من أو تساوي :value.',
        'string' => 'يجب أن يكون طول حقل :attribute أكبر من أو يساوي :value أحرف.',
    ],
    'hex_color' => 'يجب أن يكون حقل :attribute لوناً سداسياً عشرياً صحيحاً.',
    'image' => 'يجب أن يكون حقل :attribute صورة.',
    'in' => 'الحقل المحدد :attribute غير صالح.',
    'in_array' => 'يجب أن يوجد حقل :attribute في :other.',
    'in_array_keys' => 'يجب أن يحتوي حقل :attribute على مفتاح واحد على الأقل من: :values.',
    'integer' => 'يجب أن يكون حقل :attribute عدداً صحيحاً.',
    'ip' => 'يجب أن يكون حقل :attribute عنوان IP صحيحاً.',
    'ipv4' => 'يجب أن يكون حقل :attribute عنوان IPv4 صحيحاً.',
    'ipv6' => 'يجب أن يكون حقل :attribute عنوان IPv6 صحيحاً.',
    'json' => 'يجب أن يكون حقل :attribute نصاً صالحاً بصيغة JSON.',
    'list' => 'يجب أن يكون حقل :attribute قائمة.',
    'lowercase' => 'يجب أن يكون حقل :attribute أحرفاً صغيرة.',
    'lt' => [
        'array' => 'يجب أن يحتوي حقل :attribute على أقل من :value عناصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute أقل من :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أقل من :value.',
        'string' => 'يجب أن يكون طول حقل :attribute أقل من :value أحرف.',
    ],
    'lte' => [
        'array' => 'يجب ألا يحتوي حقل :attribute على أكثر من :value عناصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute أقل من أو يساوي :value كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute أقل من أو تساوي :value.',
        'string' => 'يجب أن يكون طول حقل :attribute أقل من أو يساوي :value أحرف.',
    ],
    'mac_address' => 'يجب أن يكون حقل :attribute عنوان MAC صحيحاً.',
    'max' => [
        'array' => 'يجب ألا يحتوي حقل :attribute على أكثر من :max عنصر.',
        'file' => 'يجب ألا يتجاوز حجم حقل :attribute :max كيلوبايت.',
        'numeric' => 'يجب ألا تكون قيمة حقل :attribute أكبر من :max.',
        'string' => 'يجب ألا يتجاوز طول حقل :attribute :max حرفاً.',
    ],
    'max_digits' => 'يجب ألا يحتوي حقل :attribute على أكثر من :max أرقام.',
    'mimes' => 'يجب أن يكون حقل :attribute ملفاً من النوع: :values.',
    'mimetypes' => 'يجب أن يكون حقل :attribute ملفاً من النوع: :values.',
    'min' => [
        'array' => 'يجب أن يحتوي حقل :attribute على الأقل على :min عنصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute على الأقل :min كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute على الأقل :min.',
        'string' => 'يجب أن يكون طول حقل :attribute على الأقل :min حرفاً.',
    ],
    'min_digits' => 'يجب أن يحتوي حقل :attribute على الأقل على :min أرقام.',
    'missing' => 'يجب أن يكون حقل :attribute غائباً.',
    'missing_if' => 'يجب أن يكون حقل :attribute غائباً عندما يكون :other هو :value.',
    'missing_unless' => 'يجب أن يكون حقل :attribute غائباً إلا عندما يكون :other هو :value.',
    'missing_with' => 'يجب أن يكون حقل :attribute غائباً عندما يكون :values موجوداً.',
    'missing_with_all' => 'يجب أن يكون حقل :attribute غائباً عندما يكون :values جميعها موجودة.',
    'multiple_of' => 'يجب أن يكون حقل :attribute مضاعفاً لـ :value.',
    'not_in' => 'الحقل المحدد :attribute غير صالح.',
    'not_regex' => 'صيغة حقل :attribute غير صالحة.',
    'numeric' => 'يجب أن يكون حقل :attribute رقماً.',
    'password' => [
        'letters' => 'يجب أن يحتوي حقل :attribute على حرف واحد على الأقل.',
        'mixed' => 'يجب أن يحتوي حقل :attribute على حرف كبير وحرف صغير واحد على الأقل.',
        'numbers' => 'يجب أن يحتوي حقل :attribute على رقم واحد على الأقل.',
        'symbols' => 'يجب أن يحتوي حقل :attribute على رمز واحد على الأقل.',
        'uncompromised' => 'ظهر حقل :attribute في تسريب بيانات. يرجى اختيار حقل :attribute مختلف.',
    ],
    'present' => 'يجب أن يكون حقل :attribute موجوداً.',
    'present_if' => 'يجب أن يكون حقل :attribute موجوداً عندما يكون :other هو :value.',
    'present_unless' => 'يجب أن يكون حقل :attribute موجوداً إلا عندما يكون :other هو :value.',
    'present_with' => 'يجب أن يكون حقل :attribute موجوداً عندما يكون :values موجوداً.',
    'present_with_all' => 'يجب أن يكون حقل :attribute موجوداً عندما تكون :values جميعها موجودة.',
    'prohibited' => 'حقل :attribute محظور.',
    'prohibited_if' => 'حقل :attribute محظور عندما يكون :other هو :value.',
    'prohibited_if_accepted' => 'حقل :attribute محظور عندما يكون :other مقبولاً.',
    'prohibited_if_declined' => 'حقل :attribute محظور عندما يكون :other مرفوضاً.',
    'prohibited_unless' => 'حقل :attribute محظور إلا عندما يكون :other في :values.',
    'prohibits' => 'حقل :attribute يحظر :other من الوجود.',
    'regex' => 'صيغة حقل :attribute غير صالحة.',
    'required' => 'حقل :attribute مطلوب.',
    'required_array_keys' => 'يجب أن يحتوي حقل :attribute على إدخالات لـ: :values.',
    'required_if' => 'حقل :attribute مطلوب عندما يكون :other هو :value.',
    'required_if_accepted' => 'حقل :attribute مطلوب عندما يكون :other مقبولاً.',
    'required_if_declined' => 'حقل :attribute مطلوب عندما يكون :other مرفوضاً.',
    'required_unless' => 'حقل :attribute مطلوب إلا عندما يكون :other في :values.',
    'required_with' => 'حقل :attribute مطلوب عندما يكون :values موجوداً.',
    'required_with_all' => 'حقل :attribute مطلوب عندما تكون :values جميعها موجودة.',
    'required_without' => 'حقل :attribute مطلوب عندما يكون :values غير موجود.',
    'required_without_all' => 'حقل :attribute مطلوب عندما لا يكون أي من :values موجوداً.',
    'same' => 'يجب أن يتطابق حقل :attribute مع :other.',
    'size' => [
        'array' => 'يجب أن يحتوي حقل :attribute على :size عناصر.',
        'file' => 'يجب أن يكون حجم حقل :attribute :size كيلوبايت.',
        'numeric' => 'يجب أن تكون قيمة حقل :attribute :size.',
        'string' => 'يجب أن يكون طول حقل :attribute :size أحرف.',
    ],
    'starts_with' => 'يجب أن يبدأ حقل :attribute بأي مما يلي: :values.',
    'string' => 'يجب أن يكون حقل :attribute نصاً.',
    'timezone' => 'يجب أن يكون حقل :attribute نطاقاً زمنياً صحيحاً.',
    'unique' => 'حقل :attribute مستخدم بالفعل.',
    'uploaded' => 'فشل رفع حقل :attribute.',
    'uppercase' => 'يجب أن يكون حقل :attribute أحرفاً كبيرة.',
    'url' => 'يجب أن يكون حقل :attribute رابطاً صحيحاً.',
    'ulid' => 'يجب أن يكون حقل :attribute ULID صحيحاً.',
    'uuid' => 'يجب أن يكون حقل :attribute UUID صحيحاً.',

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
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
