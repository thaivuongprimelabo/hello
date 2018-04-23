<?php

return [
    
    #GLOBAL
    'Home_Title' => 'Zenrin Call System',
    
    'TYPE_NAME' => [
        'SAME_TIME'      => '同報',
        'ORDER'          => '順次'
    ],
    'EMPTY_ITEM'   => '指定なし',
    'ROW_PER_PAGE' => 10,
    'CONTENT_LENGTH' => 10,
    'SETTINGS_DEFAULT_ENTRY'     => 'default_retry',
    'SETTINGS_DEFAULT_CALL_TIME' => 'default_call_time',
    'MESSAGE_NOTIFICATION' => [
        'MSG_001' => 'この項目は必須入力です。',           // The input field is require
        'MSG_002' => '電話番号は必須です。',              // Telephone number is require
        'MSG_003' => '説明は必須です。',                 // Desciption field is require
        'MSG_004' => '225文字以下',                     // 225 characters or less
        'MSG_005' => '数字とハイフンのみ',               // Only numbers and hyphens
        'MSG_006' => 'ユーザー名は必須です。',           // User name is required.
        'MSG_007' => 'ログインIDは必須です。',           // Login ID is required.
        'MSG_008' => 'パスワードは8文字以上の英数字で入力してください。',  // Please enter a password with at least 8 alphanumeric characters.
        'MSG_009' => '英数字	',                          // Alphameric characters
    ],
];
