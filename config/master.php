<?php

return [
    #GLOBAL
    'Home_Title' => 'Zenrin Call System',
    'TWILIO_ACCOUNT_SID' => 'AC999655102e6299c3150c547a29745a19',
    'TWILIO_AUTH_TOKEN' => '40e37e2ae4c6f63b08cbe7634ea4668c',
    'TYPE' => [
        'SAME_TIME' => 'SAME_TIME',
        'ORDER' => 'ORDER'
    ],
    'EMPTY_ITEM' => '指定なし',
    'ROW_PER_PAGE' => 10,
    'CONTENT_LENGTH' => 10,
    /**
     * @Description: SETTINGS
     * @Author: 
     * @Date: 
     */
    'SETTINGS' => [
        'DEFAULT_RETRY' => 'default_retry',
        'DEFAULT_CALL_TIME' => 'default_call_time',
        'RETRY_MIN' => 0,
        'RETRY_MAX' => 3,
        'CALL_TIME_MIN' => 0,
        'CALL_TIME_MAX' => 120
    ],
    /**
     * @Description: TWILIO STATUS
     * @Author: 
     * @Date: 
     */
    'TWILIO_STATUS' => [
        'CALLING' => 'CALLING',
        'WAITING' => 'WAITING',
        'TWILIO_CREATED' => 'TWILIO_CREATED',
        'RINGING' => 'RINGING',
        'IN_PROGRESS' => 'IN_PROGRESS',
        'FINISHED' => 'FINISHED',
        'TIMEOUT' => 'TIMEOUT',
        'CANCELED' => 'CANCELED',
        'FAILED' => 'FAILED',
        'DENIED' => 'DENIED',
        'SUCCESS' => 'SUCCESS',
        'TWILIO_FAILED' => 'TWILIO_FAILED'
    ],
    /**
     * @Description: MESSAGE NOTIFICATION
     * @Author: 
     * @Date: 
     */
    'MESSAGE_NOTIFICATION' => [
        'MSG_001' => 'この項目は必須入力です。', // The input field is require
        'MSG_002' => '電話番号は必須です。', // Telephone number is require
        'MSG_003' => '説明は必須です。', // Desciption field is require
        'MSG_004' => '225文字以下', // 225 characters or less
        'MSG_005' => '数字とハイフンのみ', // Only numbers and hyphens
        'MSG_006' => 'ユーザー名は必須です。', // User name is required.
        'MSG_007' => 'ログインIDは必須です。', // Login ID is required.
        'MSG_008' => 'パスワードは8文字以上の英数字で入力してください。', // Please enter a password with at least 8 alphanumeric characters.
        'MSG_009' => '英数字	', // Alphameric characters
        'MSG_010' => 'Login Id is already exist', // Login Id already exist
        'MSG_011' => 'エラーが発生しました。', // An error occurred.
        'MSG_012' => 'ユーザーを削除します。', // Delete the user.
        'MSG_013' => '電話番号は必須です。', // Telephone number is require
        'MSG_014' => '説明は必須です。', // Description is require
        'MSG_015' => 'The phone number is already exist。', // Description is require
        'MSG_016' => '{電話番号, 説明}が正しく反映されました', // {Phone number, explanation} correctly reflected
        'MSG_017' => '発信元番号を削除します。',        // Delete the source number.
        'MSG_018' => 'パスワード が正しく反映されました',  // Password was reflected correctly
        'MSG_019' => 'ユーザー情報 が正しく反映されました',  // User information was reflected correctly
        'MSG_020' => ' を作成しました。',                   // is created.
    ],
    /**
     * @Description: MESSAGE API NOTIFICATION
     * @Author: ThanhBinh-PrimeLabo
     * @Date: 02-05-18
     */
    'MESSAGE_API_NOTIFICATION' => [
        'MSG_001' => 'ログインIDまたはパスワードが違います。', // failed_authentication
        'MSG_002' => '有効な認証情報キーではありません。', // invalid_key
        'MSG_003' => '発信元番号が誤っています。', // no_source_phone_number
        'MSG_004' => '値がただしくありません。', // invalid_request_parameter
        'MSG_005' => '対象の音声通知はすでに終了しています。', // call_is_already_finished
        'MSG_006' => '指定の音声通知は存在しません。', // call_not_found
        'MSG_007' => '対象の音声通知は通話中のためキャンセルできません。', // call_is_in_progress
    ],
];
