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
    'SETTINGS' => [
        'DEFAULT_RETRY'     => 'default_retry',
        'DEFAULT_CALL_TIME' => 'default_call_time',
        'RETRY_MIN'         => 0,
        'RETRY_MAX'         => 3,
        'CALL_TIME_MIN'     => 0,
        'CALL_TIME_MAX'     => 120
    ],
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
        'MSG_010' => 'Login Id is already exist',       // Login Id already exist
        'MSG_011' => 'エラーが発生しました。',             // An error occurred.
        'MSG_012' => 'ユーザーを削除します。',             // Delete the user.
        'MSG_013' => '電話番号は必須です。',               // Telephone number is require
        'MSG_014' => '説明は必須です。',                  // Description is require
        'MSG_015' => 'The phone number is already exist。', // Description is require
        'MSG_016' => '{電話番号, 説明}が正しく反映されました', // {Phone number, explanation} correctly reflected
        'MSG_017' => '発信元番号を削除します。',        // Delete the source number.
    ],
];
