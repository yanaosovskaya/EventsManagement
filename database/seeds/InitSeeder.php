<?php

use Illuminate\Database\Seeder;

class InitSeeder extends Seeder
{
    protected $settings = [
        [
            'key' => 'contact_form_captcha',
            'value' => '1',
            'title' => 'Switching Captcha',
            'active' => 1,
            'group' => \App\Models\Setting::GROUP_CONTACT_FORM,
            'type' => \App\Models\Setting::TYPE_RADIO,
        ],
        [
            'key' => 'contact_form_recipient_email_address',
            'value' => '',
            'title' => 'Recipient EMAIL Address',
            'active' => 1,
            'group' => \App\Models\Setting::GROUP_CONTACT_FORM,
            'type' => \App\Models\Setting::TYPE_MULTI_SELECT,
        ],
        [
            'key' => 'contact_form_from',
            'value' => 'From Site',
            'title' => 'Text FROM',
            'active' => 1,
            'group' => \App\Models\Setting::GROUP_CONTACT_FORM,
            'type' => \App\Models\Setting::TYPE_STRING,
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::updateOrCreate(
            [
                'email' => env('ADMIN_MAIL')
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => env('ADMIN_MAIL'),
                'password' => \Hash::make('123456'),
            ]
        );
        \App\Models\Profile::create([
            'user_id' => $user->id
        ]);
        

        foreach ($this->settings as $setting) {
            \Setting::set(
                $setting['key'],
                $setting['value'],
                $setting['title'],
                $setting['active'],
                $setting['group'],
                $setting['type']
            );
        }
    }
}
